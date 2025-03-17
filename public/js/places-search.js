document.getElementById("geo-locate-btn").addEventListener("click", function() {
  const locationResult = document.getElementById("location-result");
  locationResult.innerHTML = `<p>We need access to your location to show the closest address. Please allow location access in the prompt.</p>`;

  if (navigator.geolocation) {
    console.log("Geolocation is supported.");
    navigator.geolocation.getCurrentPosition(
      position => geocodePosition(position.coords.latitude, position.coords.longitude),
      error => handleGeoError(error)
    );
  } else {
    locationResult.innerHTML = "<p>Geolocation is not supported by this browser.</p>";
  }
});

function geocodePosition(lat, lng) {
  console.log(`Location: Latitude: ${lat}, Longitude: ${lng}`);
  const geocoder = new google.maps.Geocoder();
  const latLng = { lat: parseFloat(lat), lng: parseFloat(lng) };

  geocoder.geocode({ location: latLng }, (results, status) => {
    const addressResult = document.getElementById("address-result");
    if (status === google.maps.GeocoderStatus.OK && results[0]) {
      document.getElementById("floating_address").value = results[0].formatted_address;
    } else {
      addressResult.innerHTML = `<p>${status === google.maps.GeocoderStatus.OK ? 'No address found' : 'Geocoder failed: ' + status}</p>`;
    }
  });
}

function handleGeoError(error) {
  console.error("Error code: " + error.code + " - " + error.message);
  document.getElementById("location-result").innerHTML = "<p>Unable to retrieve location. Please allow access to your location.</p>";
}

function previewImage(event) {
  const file = event.target.files[0];
  const preview = document.getElementById('image-preview');
  preview.classList.toggle('hidden', !file);

  if (file) {
    const reader = new FileReader();
    reader.onload = e => preview.src = e.target.result;
    reader.readAsDataURL(file);
  }
}

function initializeAutocomplete() {
  const input = document.getElementById('floating_address');
  const autocomplete = new google.maps.places.Autocomplete(input, { types: ['geocode'], componentRestrictions: { country: 'ZA' } });

  autocomplete.addListener('place_changed', () => updateAddressFields(autocomplete.getPlace()));
  console.log('Autocomplete initialized');
}

function updateAddressFields(place) {
  document.getElementById('google_location').value = place.formatted_address || '';
  document.getElementById('google_latitude').value = place.geometry?.location.lat() || '';
  document.getElementById('google_longitude').value = place.geometry?.location.lng() || '';
  document.getElementById('google_location_type').value = place.types[0] || '';
  
  const postalCode = place.address_components?.find(component => component.types.includes("postal_code"))?.long_name || '';
  document.getElementById('google_postal_code').value = postalCode;

  const city = place.address_components?.find(component => component.types.includes("locality"))?.long_name || '';
  document.getElementById('google_city').value = city;

  document.getElementById('package_selected').value = "package_value"; // Update as needed
  document.getElementById('web_source').value = "web_source_value"; // Update as needed
  document.getElementById('location_id').value = place.place_id || '';

  const selectedTypes = $('input[name="place-types"]:checked').map((_, el) => el.value).get() || ['restaurant'];
  document.getElementById('floating_sectors').innerHTML = selectedTypes.join(', ');

  searchNearbyPlaces(place.formatted_address, selectedTypes);
}

function searchNearbyPlaces(address, selectedTypes) {
  const geocoder = new google.maps.Geocoder();
  geocoder.geocode({ address }, (results, status) => {
    if (status === 'OK') {
      const { lat, lng } = results[0].geometry.location;
      const request = { location: { lat, lng }, radius: '500', type: selectedTypes };
      const service = new google.maps.places.PlacesService(document.createElement('div'));

      service.nearbySearch(request, (results, status) => displaySearchResults(results, status));
    } else {
      alert("Geocode failed: " + status);
    }
  });
}

function displaySearchResults(results, status) {
  const $results = $("#results").empty();
  if (status === google.maps.places.PlacesServiceStatus.OK) {
    results.forEach(result => {
      const content = `
        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
          <h3 class="text-xl font-semibold text-gray-800">${result.name}</h3>
          ${result.opening_hours?.open_now !== undefined ? `<p class="text-sm ${result.opening_hours.open_now ? 'text-green-500' : 'text-red-500'}">Open Now: ${result.opening_hours.open_now ? 'Yes' : 'No'}</p>` : ''}
          ${result.vicinity ? `<p class="text-sm text-gray-600">Near by: ${result.vicinity}</p>` : ''}
          ${result.rating ? `<p class="text-sm text-yellow-500">Rating: ${result.rating} stars</p>` : ''}
          <div class="flex justify-center items-center">
            <button class="hover:bg-blue-600 p-2 text-sm rounded-full shadow-lg" name="user_selected_place" value="${result.place_id || ''}">Select</button>
          </div>
        </div>`;
      $results.append(content);
    });
  } else {
    $results.append(`<div class="bg-white rounded-lg shadow-md p-4 mb-4"><h3 class="text-xl font-semibold text-gray-800">Nothing Found</h3></div>`);
  }
}

document.addEventListener('DOMContentLoaded', function() {
  if (typeof google !== 'undefined' && google.maps && google.maps.places) {
    initializeAutocomplete();
    const types = ["accounting", "airport", "amusement_park", "aquarium", "art_gallery", "atm", "bakery", "bank", "bar", "beauty_salon", "bicycle_store", "book_store", "bowling_alley", "bus_station", "cafe", "campground", "car_dealer", "car_rental", "cemetery", "church", "clothing_store", "convenience_store", "courthouse", "dentist", "department_store", "doctor", "drugstore", "electrician", "electronics_store", "embassy", "fire_station", "florist", "food", "funeral_home", "furniture_store", "gas_station", "gym", "hair_care", "hardware_store", "health", "hindu_temple", "home_goods_store", "hospital", "insurance_agency", "jewelry_store", "laundry", "lawyer", "library", "light_rail_station", "liquor_store", "local_government_office", "locksmith", "lodging", "meal_delivery", "meal_takeaway", "mosque", "movie_rental", "movie_theater", "moving_company", "museum", "night_club", "painter", "park", "parking", "pet_store", "pharmacy", "physiotherapist", "place_of_worship", "plumber", "police", "post_office", "real_estate_agency", "restaurant", "roofing_contractor", "rural_area", "school", "shoe_store", "shopping_mall", "spa", "stadium", "storage", "store", "subway_station", "supermarket", "synagogue", "taxi_stand", "train_station", "travel_agency", "university", "veterinary_care", "zoo"];

    types.forEach(type => {
      const formattedType = type.replace(/_/g, ' ');
      $("#checkbox-container").append(`
        <div class="flex items-center">
          <input type="checkbox" id="${type}" name="place-types" value="${type}" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
          <label for="${type}" class="ml-2 text-sm text-gray-700 capitalize">${formattedType}</label>
        </div>
      `);
    });
  } else {
    console.error('Google Maps API or Places library is not available.');
  }
});
