@extends('welcome')

@section('content')

<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places" defer></script>

<div class="max-w-3xl mx-auto bg-white rounded-lg">
<div class="flex justify-center mb-4">
    
  <div>
    
  @if(session('exists'))
        <h5 class="my-4 text-center">
            <a href="{{ route('login') }}" class="bg-blue-500 text-white btn-sm py-2 px-2 rounded-full hover:bg-blue-600">
                <span class="text-bold ">Sign in</span>
            </a>
        </h5>
    @endif
    
    <span class="text-gray-500"> Select topics to search </span>
    
    <div id="checkbox-container" class="my-4 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
      <!-- Checkboxes will be populated dynamically -->
    </div>

    
    <div id="location-result" class="mt-4 text-gray-700"></div>
    <div id="address-result" class="mt-4 text-gray-700"></div>

    <div class="flex justify-center items-center">
        <button type="button" id="geo-locate-btn" class="bg-blue-500 text-white btn-sm py-2 px-2 rounded-full hover:bg-blue-600">
          <span><i class="fa-solid fa-location-arrow"></i> Get My Location <i class="fa-solid fa-location-dot"> </i> search an address <i class="fa-solid fa-circle-check"></i> auto search</span>
        </button>
    </div>

    <div class="relative z-0 w-full mb-5 group " >
      <input type="text" name="floating_address" value="{{ old('floating_address') }}" id="floating_address" class="text-center block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
      <span class="text-sm" id="floating_sectors"></span>
            <!-- <label for="floating_address" class="peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Enter Street name...</label> -->
            @error('floating_address')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
          <div class="hidden">
              <input type="text" name="google_location" id="google_location" value="{{ old('google_location') }}" class=" text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
              <input type="text" name="google_latitude" id="google_latitude" value="{{ old('google_latitude') }}" class=" text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
              <input type="text" name="google_longitude" id="google_longitude" value="{{ old('google_longitude') }}" class=" text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
              <input type="text" name="google_location_type" id="google_location_type" value="{{ old('google_location_type') }}" class=" text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
              <input type="text" name="google_postal_code" id="google_postal_code" value="{{ old('google_postal_code') }}" class=" text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
              <input type="text" name="google_city" id="google_city" value="{{ old('google_city') }}" class=" text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
              <input type="text" name="package_selected" id="package_selected" value="{{ old('package_selected') }}" class=" text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
              <input type="text" name="web_source" id="web_source" value="{{ old('web_source') }}" class=" text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
              <input type="text" name="location_id" id="location_id" value="{{ old('location_id') }}" class=" text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 h-64" id="results"></div>
    </div>

<script>
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

        // Update the content of floating_sectors to reflect the selected types
        floating_sectors.innerHTML = selectedTypes.join(', ');


        var address = $("#floating_address").val();
    
            // Geocode the address to get latitude and longitude
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ address: address }, function(results, status) {
              if (status === 'OK') {
                var lat = results[0].geometry.location.lat();
                var lng = results[0].geometry.location.lng();
    
                // Make Places API request for nearby restaurants
                var request = {
                  location: { lat: lat, lng: lng },
                  radius: '500',
                  type: selectedTypes
                };
    
               var service = new google.maps.places.PlacesService(document.createElement('div'));
               service.nearbySearch(request, function(results, status) {
                 if (status === google.maps.places.PlacesServiceStatus.OK) {
                   $("#results").empty(); // Clear previous results
               
                   for (var i = 0; i < results.length; i++) {
                     var result = results[i];
                      console.log(result);
                     // Create HTML content to display additional details with TailwindCSS styling
                     const content = `
                      <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                          <img src="${result.icon}" alt="Restaurant Icon" class="w-10 h-10 mb-2">
                          <h3 class="text-xl font-semibold text-gray-800">${result.name}</h3>
                          ${result.opening_hours && result.opening_hours.open_now !== undefined ? `
                              <p class="text-sm ${result.opening_hours.open_now ? 'text-green-500' : 'text-red-500'}">
                                  Open Now: ${result.opening_hours.open_now ? 'Yes' : 'No'}
                              </p>` : ''}
                          ${result.vicinity ? `
                              <p class="text-sm text-gray-600">
                                  Near: ${result.vicinity}
                              </p>` : ''}
                          ${result.rating ? `
                              <p class="text-sm text-yellow-500">
                                  Rating: ${result.rating} stars
                              </p>` : ''}
                      </div>
                  `;
               
                     // Add content to the results container
                     $("#results").append(content);
                   }
                 } else {
                    console.log('Nothing found');
                   $("#results").empty(); // Clear previous results
                   var content = `
                     <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                       <h3 class="text-xl font-semibold text-gray-800">Nothing Found</h3>
                     </div>
                   `;
               
                     // Add content to the results container
                     $("#results").append(content);

                 }
               });
               
              } else {
                alert("Geocode was not successful: " + status);
              }
            });
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





</script>

</div>  

@endsection