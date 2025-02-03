// import './bootstrap';



document.getElementById("geo-locate-btn").addEventListener("click", function() {
  // Show a custom message to explain the need for geolocation
  document.getElementById("location-result").innerHTML = `
    <p>We need access to your location to show the closest address. Please allow location access in the prompt.</p>
  `;

  if (navigator.geolocation) {
    console.log("Geolocation is supported.");

    navigator.geolocation.getCurrentPosition(function(position) {
      var lat = position.coords.latitude;
      var lng = position.coords.longitude;
      
      console.log(`Location: Latitude: ${lat}, Longitude: ${lng}`);
      
      // Initialize the Geocoder
      var geocoder = new google.maps.Geocoder();
      var latLng = { lat: parseFloat(lat), lng: parseFloat(lng) };
      
      // Get the address from the coordinates
      geocoder.geocode({ location: latLng }, function(results, status) {
        console.log("Geocode Status:", status);
        if (status === google.maps.GeocoderStatus.OK) {
          if (results[0]) {
            // Display the closest address
            document.getElementById("floating_address").value = `${results[0].formatted_address}`;

          } else {
            document.getElementById("address-result").innerHTML = "<p>No address found for this location.</p>";
          }
        } else {
          document.getElementById("address-result").innerHTML = "<p>Geocoder failed due to: " + status + "</p>";
        }
      });

    }, function(error) {
      console.error("Error code: " + error.code + " - " + error.message);
      // Handle errors (e.g., user denies location request)
      document.getElementById("location-result").innerHTML = "<p>Unable to retrieve location. Please allow access to your location.</p>";
    });
  } else {
    console.log("Geolocation is not supported by this browser.");
    document.getElementById("location-result").innerHTML = "<p>Geolocation is not supported by this browser.</p>";
  }
});

  
  
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('image-preview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    } 
}
 // Function to initialize the Google Maps Places Autocomplete
 function initializeAutocomplete() {
    var input = document.getElementById('floating_address');

    var autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['geocode'],
        componentRestrictions: { country: 'ZA' }
    });

    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();

        // Update address
        if (place.formatted_address) {
            document.getElementById('google_location').value = place.formatted_address;
        }

        // Update latitude and longitude
        if (place.geometry) {
            document.getElementById('google_latitude').value = place.geometry.location.lat();
            document.getElementById('google_longitude').value = place.geometry.location.lng();
        }

        // Update location type
        if (place.types.length > 0) {
            document.getElementById('google_location_type').value = place.types[0];
        }

        // Update postal code
        var postalCode = place.address_components.find(component => component.types.includes("postal_code"));
        if (postalCode) {
            document.getElementById('google_postal_code').value = postalCode.long_name;
        }

        // Update city
        var city = place.address_components.find(component => component.types.includes("locality"));
        if (city) {
            document.getElementById('google_city').value = city.long_name;
        }

        // Update additional fields
        document.getElementById('package_selected').value = "package_value"; // Update as needed
        document.getElementById('web_source').value = "web_source_value";   // Update as needed

        // Update location ID
        if (place.place_id) {
            document.getElementById('location_id').value = place.place_id;
        }

        var selectedTypes = [];

        $('input[name="place-types"]:checked').each(function () {
          selectedTypes.push($(this).val());
        });

        var selectedTypes = selectedTypes.length > 0 ? selectedTypes : ['restaurant'];

        var floating_sectors = document.getElementById('floating_sectors');
        var floating_sectors_value = document.getElementById('floating_sectors_value');

        // Update the content of floating_sectors to reflect the selected types
        floating_sectors.innerHTML = selectedTypes.join(', ');

        floating_sectors_value.value = selectedTypes.join(', ');
          
    });

    console.log('Autocomplete initialized');
}

// Ensure the script runs after the Google Maps API is loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Check if the Google Maps API and Places library are available
    if (typeof google !== 'undefined' && google.maps && google.maps.places) {

        const types = [
            "accounting", "airport", "amusement_park", "aquarium", "art_gallery", "atm", 
            "bakery", "bank", "bar", "beauty_salon", "bicycle_store", "book_store", 
            "bowling_alley", "bus_station", "cafe", "campground", "car_dealer", "car_rental", 
            "cemetery", "church", "clothing_store", "convenience_store", "courthouse", "dentist", 
            "department_store", "doctor", "drugstore", "electrician", "electronics_store", 
            "embassy", "fire_station", "florist", "food", "funeral_home", "furniture_store", 
            "gas_station", "gym", "hair_care", "hardware_store", "health", "hindu_temple", 
            "home_goods_store", "hospital", "insurance_agency", "jewelry_store", "laundry", 
            "lawyer", "library", "light_rail_station", "liquor_store", "local_government_office", 
            "locksmith", "lodging", "meal_delivery", "meal_takeaway", "mosque", "movie_rental", 
            "movie_theater", "moving_company", "museum", "night_club", "painter", "park", 
            "parking", "pet_store", "pharmacy", "physiotherapist", "place_of_worship", "plumber", 
            "police", "post_office", "real_estate_agency", "restaurant", "roofing_contractor", 
            "rural_area", "school", "shoe_store", "shopping_mall", "spa", "stadium", "storage", 
            "store", "subway_station", "supermarket", "synagogue", "taxi_stand", "train_station", 
            "travel_agency", "university", "veterinary_care", "zoo"
          ];
            
          const $container = $("#checkbox-container");

          // Populate the container with checkboxes
          types.forEach(type => {
            const formattedType = type.replace(/_/g, ' ');
            $container.append(`
              <div class="flex items-center">
                <input type="checkbox" id="${type}" name="place-types" value="${type}" 
                  class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="${type}" class="ml-2 text-sm text-gray-700 capitalize">${formattedType}</label>
              </div>
            `);
          });

          

        initializeAutocomplete(); // Initialize the autocomplete functionality


    } else {
        console.error('Google Maps API or Places library is not available.'); // Debugging: Error if API is not loaded
    }
    
});

// // Function to initialize the map
// function initMap() {
//     var map = new google.maps.Map(document.getElementById('map'), {
//         center: { lat: -34.397, lng: 150.644 }, // Default location
//         zoom: 8
//     });
// }

// // Initialize the map after the API script is loaded
// document.addEventListener('DOMContentLoaded', function() {
//     if (typeof google !== 'undefined') {
//         initMap();
//     } else {
//         console.error('Google Maps API is not loaded.');
//     }
// });




