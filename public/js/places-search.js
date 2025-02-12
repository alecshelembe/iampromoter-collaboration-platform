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
          "accounting", "advertising_agency", "airport", "amusement_park", "animal_shelter", 
          "aquarium", "archery_range", "art_gallery", "atm", "auto_body_shop", 
          "auto_parts_store", "auto_repair_shop", "baby_store", "bakery", "bank", 
          "bar", "barber_shop", "bathroom_supplies_store", "beauty_salon", "bicycle_store", 
          "bike_rental", "book_store", "bowling_alley", "brewery", "bus_station", 
          "butcher_shop", "cafe", "campground", "candy_store", "car_dealer", 
          "car_rental", "car_wash", "carpet_store", "casino", "catering_service", 
          "cemetery", "child_care_center", "church", "cinema", "clothing_store", 
          "comic_book_store", "computer_store", "construction_company", "convenience_store", 
          "copy_shop", "courthouse", "coworking_space", "craft_store", "dance_school", 
          "day_spa", "dentist", "department_store", "diner", "doctor", 
          "dog_park", "dog_training_school", "dollar_store", "drugstore", 
          "dry_cleaner", "electrician", "electronics_store", "embassy", "engineering_firm", 
          "event_venue", "factory", "farming_supply_store", "fast_food", "feed_store", 
          "fire_station", "fish_market", "florist", "food", "funeral_home", 
          "furniture_store", "game_store", "garden_center", "gas_station", 
          "gift_shop", "glass_repair_shop", "government_office", "grocery_store", 
          "gym", "hair_care", "hardware_store", "health", "health_clinic", 
          "hindu_temple", "home_goods_store", "home_remodeling_company", "hospital", 
          "hotel", "insurance_agency", "interior_design_firm", "jewelry_store", 
          "juice_bar", "karaoke_bar", "kindergarten", "kitchen_supply_store", 
          "language_school", "laundry", "law_firm", "library", "light_rail_station", 
          "liquor_store", "local_government_office", "locksmith", "lodging", 
          "luggage_store", "lumber_store", "luxury_car_dealer", "machine_shop", 
          "marina", "market", "martial_arts_school", "massage_therapist", 
          "meal_delivery", "meal_takeaway", "medical_clinic", "mobile_phone_store", 
          "mosque", "movie_rental", "movie_theater", "moving_company", "museum", 
          "music_school", "music_store", "night_club", "notary_public", "nursing_home", 
          "office_supplies_store", "optician", "organic_grocery_store", "paint_store", 
          "painter", "park", "parking", "pawn_shop", "pet_grooming", 
          "pet_store", "pharmacy", "physiotherapist", "place_of_worship", 
          "plumber", "police_station", "post_office", "printing_shop", 
          "real_estate_agency", "recreation_center", "recycling_center", "restaurant", 
          "roofing_contractor", "rural_area", "school", "science_museum", "second_hand_store", 
          "self_storage", "shoe_repair_shop", "shoe_store", "shopping_mall", 
          "skate_park", "ski_resort", "snack_bar", "spa", "sporting_goods_store", 
          "sports_complex", "stadium", "storage", "store", "subway_station", 
          "supermarket", "surf_school", "synagogue", "tattoo_parlor", 
          "taxi_stand", "tea_house", "technology_store", "tennis_court", 
          "theater", "thrift_store", "tool_rental", "toy_store", 
          "train_station", "travel_agency", "university", "used_car_dealer", 
          "utility_company", "veterinary_care", "video_game_store", "wedding_venue", 
          "winery", "yoga_studio", "zoo"
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




