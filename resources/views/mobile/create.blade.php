@extends('welcome')

@section('content')


<script defer src="{{ asset('js/app.js') }}"></script>
<script defer src="{{ asset('js/get-user-location.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&loading=async&libraries=places" defer></script>


<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg mt-10">
<h1 class="text-3xl font-bold mb-6">Create a post</h1>

<h1 class="text-xl font-bold mb-6">Step 1</h1>

<div class="flex justify-end mb-4">
  <form id="upload-form" action="{{ route('social.save.post') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Name -->
    <div class="my-4">
      <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Place</label>
      <input type="text" name="place_name" value="{{ old('place_name') }}" id="place_name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Name of the Venture" />
      @error('name')
      <p class="text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Options -->
    <h1 class="text-xl font-bold mb-6">Step 2</h1>
    
    <p for="description" class="block text-sm font-medium text-gray-700 mb-2">Select Topics and or amenities </p>
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 my-4">
          <div class="flex items-center space-x-2">
              <input type="checkbox" id="wifi" name="extras[]" value="wifi" class="peer hidden">
              <label for="wifi" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
                  <i class="fa-solid fa-wifi"></i>
                  <span>WiFi</span>
              </label>
          </div>

          <div class="flex items-center space-x-2">
        <input type="checkbox" id="beauty" name="extras[]" value="beauty" class="peer hidden">
        <label for="beauty" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-heart"></i>
          <span>Beauty</span>
        </label>
      </div>

      <!-- Cars -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="cars" name="extras[]" value="cars" class="peer hidden">
        <label for="cars" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-car"></i>
          <span>Cars</span>
        </label>
      </div>

      <!-- Tech -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="tech" name="extras[]" value="tech" class="peer hidden">
        <label for="tech" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-microchip"></i>
          <span>Tech</span>
        </label>
      </div>

      <!-- Fitness -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="fitness" name="extras[]" value="fitness" class="peer hidden">
        <label for="fitness" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-dumbbell"></i>
          <span>Fitness</span>
        </label>
      </div>

      <!-- Travel -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="travel" name="extras[]" value="travel" class="peer hidden">
        <label for="travel" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-plane"></i>
          <span>Travel</span>
        </label>
      </div>

      <!-- Gaming -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="gaming" name="extras[]" value="gaming" class="peer hidden">
        <label for="gaming" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-gamepad"></i>
          <span>Gaming</span>
        </label>
      </div>

      <!-- Fashion -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="fashion" name="extras[]" value="fashion" class="peer hidden">
        <label for="fashion" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-shirt"></i>
          <span>Fashion</span>
        </label>
      </div>

      <!-- Music -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="music" name="extras[]" value="music" class="peer hidden">
        <label for="music" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-music"></i>
          <span>Music</span>
        </label>
      </div>

      <!-- Cooking -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="cooking" name="extras[]" value="cooking" class="peer hidden">
        <label for="cooking" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-utensils"></i>
          <span>Cooking</span>
        </label>
      </div>

      <!-- Education -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="education" name="extras[]" value="education" class="peer hidden">
        <label for="education" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-book"></i>
          <span>Education</span>
        </label>
      </div>

      <!-- Finance -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="finance" name="extras[]" value="finance" class="peer hidden">
        <label for="finance" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-dollar-sign"></i>
          <span>Finance</span>
        </label>
      </div>

      <!-- News -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="news" name="extras[]" value="news" class="peer hidden">
        <label for="news" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-newspaper"></i>
          <span>News</span>
        </label>
      </div>

      <!-- DIY -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="diy" name="extras[]" value="diy" class="peer hidden">
        <label for="diy" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-hammer"></i>
          <span>DIY</span>
        </label>
      </div>

      <!-- Nature -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="nature" name="extras[]" value="nature" class="peer hidden">
        <label for="nature" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-leaf"></i>
          <span>Nature</span>
        </label>
      </div>

      <!-- Comedy -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="comedy" name="extras[]" value="comedy" class="peer hidden">
        <label for="comedy" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-laugh"></i>
          <span>Comedy</span>
        </label>
      </div>

      <!-- Vlogs -->
      <div class="flex items-center space-x-2">
        <input type="checkbox" id="vlogs" name="extras[]" value="vlogs" class="peer hidden">
        <label for="vlogs" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
          <i class="fa-solid fa-video"></i>
          <span>Vlogs</span>
        </label>
      </div>
      
      <div class="flex items-center space-x-2">
          <input type="checkbox" id="play-area" name="extras[]" value="play-area" class="peer hidden">
          <label for="play-area" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-child"></i>
              <span>Play Area</span>
          </label>
      </div>

      <div class="flex items-center space-x-2">
          <input type="checkbox" id="dogs-allowed" name="extras[]" value="dogs-allowed" class="peer hidden">
          <label for="dogs-allowed" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-dog"></i>
              <span>Dogs Allowed</span>
          </label>
      </div>

      <div class="flex items-center space-x-2">
          <input type="checkbox" id="parking" name="extras[]" value="parking" class="peer hidden">
          <label for="parking" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-square-parking"></i>
              <span>Parking</span>
          </label>
      </div>

      <div class="flex items-center space-x-2">
          <input type="checkbox" id="paid-parking" name="extras[]" value="paid-parking" class="peer hidden">
          <label for="paid-parking" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-car-side"></i>
              <span>Paid Parking</span>
          </label>
      </div>

      <div class="flex items-center space-x-2">
          <input type="checkbox" id="outdoor-seating" name="extras[]" value="outdoor-seating" class="peer hidden">
          <label for="outdoor-seating" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-chair"></i>
              <span>Outdoor Seating</span>
          </label>
      </div>

      <div class="flex items-center space-x-2">
          <input type="checkbox" id="wheelchair-accessible" name="extras[]" value="wheelchair-accessible" class="peer hidden">
          <label for="wheelchair-accessible" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-wheelchair"></i>
              <span>Wheelchair Accessible</span>
          </label>
      </div>

      <div class="flex items-center space-x-2">
          <input type="checkbox" id="smoking-area" name="extras[]" value="smoking-area" class="peer hidden">
          <label for="smoking-area" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-smoking"></i>
              <span>Smoking Area</span>
          </label>
      </div>

      <div class="flex items-center space-x-2">
          <input type="checkbox" id="food-available" name="extras[]" value="food-available" class="peer hidden">
          <label for="food-available" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-utensils"></i>
              <span>Food Available</span>
          </label>
      </div>

      <div class="flex items-center space-x-2">
          <input type="checkbox" id="alcohol-served" name="extras[]" value="alcohol-served" class="peer hidden">
          <label for="alcohol-served" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-wine-glass"></i>
              <span>Alcohol Served</span>
          </label>
      </div>

      <div class="flex items-center space-x-2">
          <input type="checkbox" id="bike-racks" name="extras[]" value="bike-racks" class="peer hidden">
          <label for="bike-racks" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-bicycle"></i>
              <span>Bike Racks</span>
          </label>
      </div>

      <div class="flex items-center space-x-2">
          <input type="checkbox" id="charging-stations" name="extras[]" value="charging-stations" class="peer hidden">
          <label for="charging-stations" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-bolt"></i>
              <span>Charging Stations</span>
          </label>
      </div>

      <div class="flex items-center space-x-2">
          <input type="checkbox" id="live-music" name="extras[]" value="live-music" class="peer hidden">
          <label for="live-music" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-music"></i>
              <span>Live Music</span>
          </label>
      </div>

      <div class="flex items-center space-x-2">
          <input type="checkbox" id="sports-screening" name="extras[]" value="sports-screening" class="peer hidden">
          <label for="sports-screening" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-tv"></i>
              <span>Sports Screening</span>
          </label>
      </div>
  </div>
    @error('extras[]')
      <p class="text-red-600 mt-1">{{ $message }}</p>
    @enderror
    
    <!-- Description -->
    <h1 class="text-xl font-bold mb-6">Step 3</h1>

    <div class="my-4">
        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
        <p class="my-3">Here you need to give a description of what people can expect at the venue and how you make the experiance memorable. </p>
      <textarea name="description" id="description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Write your promotion."></textarea>
      @error('description')
      <p class="text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <h1 class="text-xl font-bold mb-6">Step 4</h1>
    
    <div class="my-4">
    <span class="text-gray-500"> Finish the above then choose sectors to link with your post (Optional) </span>
    
    <div id="checkbox-container" class="my-4 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
      <!-- Checkboxes will be populated dynamically -->
    </div>

    <h1 class="text-xl font-bold mb-6">Step 5</h1>

    <div id="location-result" class="mt-4 text-gray-700"></div>
    <div id="address-result" class="mt-4 text-gray-700"></div>
    
    <div class="flex justify-center items-center">
        <button type="button" id="geo-locate-btn" class="bg-blue-500 text-white btn-sm py-2 px-2 rounded-full hover:bg-blue-600">
          <span><i class="fa-solid fa-location-arrow"></i> Get My Location <i class="fa-solid fa-location-dot"> </i> Tag an address <i class="fa-solid fa-circle-check"></i> address search</span>
        </button>
    </div>

    <div class="relative z-0 w-full mb-5 text-center my-2 group">
      <label for="floating_address" class="peer-focus:font-medium text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Enter Street name...</label>
      <input type="text" name="floating_address" value="{{ old('floating_address') }}" id="floating_address" class="text-center block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
          <span class="text-sm" id="floating_sectors"></span>
          <input type="text" class="text-sm hidden" id="floating_sectors_value" name="floating_sectors_value" value=''/>
          @error('floating_sectors_value')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
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
    </div>

    <h1 class="text-xl font-bold mb-6">Step 6 (Images last)</h1>

    <div class="grid grid-cols-2 gap-4">
        @for ($i = 1; $i <= 4; $i++)
            <figure class="max-w-lg relative">
                <img id="img-{{ $i }}" class="h-auto max-w-full rounded-lg cursor-pointer" 
                     src="{{ asset('/storage/images/default-camera.jpg') }}" alt="image description">
                <input type="file" id="file-input-{{ $i }}" class="hidden" name="images[]" accept="image/*">
            </figure>
        @endfor
    </div>

    <div class="text-right h-64">
        <button type="submit" class="bg-blue-500 p-4 text-white rounded-full shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 mt-10">
            Post
        </button>
    </div>
</form>

<script defer src="{{ asset('js/browser-image-compression.js') }}"></script>
<script>
  // Function to compress and preview image before uploading
  async function handleImageUpload(imgId, inputId) {
    const imgElement = document.getElementById(imgId);
    const fileInput = document.getElementById(inputId);

    imgElement.addEventListener('click', () => {
      fileInput.click();
    });

    fileInput.addEventListener('change', async (event) => {
      const file = event.target.files[0];
      if (file) {
        try {
          // Compress the image
          const compressedBlob = await imageCompression(file, {
            maxSizeMB: 1,   // Max size 1MB
            maxWidthOrHeight: 1920,  // Resize to max width/height 1920px
            useWebWorker: true
          });

          // Convert the Blob back to a File object
          const compressedFile = new File([compressedBlob], file.name, { type: file.type });

          // Preview the compressed image
          const reader = new FileReader();
          reader.onload = (e) => {
            imgElement.src = e.target.result;  // Preview the compressed image
          };
          reader.readAsDataURL(compressedFile);  // Use the compressed file

          // Update the file input with the compressed file
          const dataTransfer = new DataTransfer();
          dataTransfer.items.add(compressedFile);
          fileInput.files = dataTransfer.files;
          console.log("Image compression successful");
        } catch (error) {
          console.log("Image compression failed:", error);
        }
      }
    });
  }

  // Apply the function to each image and file input pair
  handleImageUpload('img-1', 'file-input-1');
  handleImageUpload('img-2', 'file-input-2');
  handleImageUpload('img-3', 'file-input-3');
  handleImageUpload('img-4', 'file-input-4');
  
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
const types = [
  "accounting", "airport", "amusement_park", "aquarium", "art_gallery",
  "atm", "bakery", "bank", "bar", "beauty_salon", "bicycle_store", "book_store",
  "bowling_alley", "bus_station", "cafe", "campground", "car_dealer", "car_rental",
  "cemetery", "church", "clothing_store", "convenience_store", "courthouse",
  "dentist", "department_store", "doctor", "drugstore", "electrician", "electronics_store",
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
  "travel_agency", "university", "veterinary_care", "zoo",

  // Extended categories
  "tattoo_parlor", "coffee_shop", "fast_food", "bbq_restaurant", "steakhouse",
  "bakery_dessert", "donut_shop", "ice_cream_shop", "italian_restaurant", "chinese_restaurant",
  "indian_restaurant", "japanese_restaurant", "mexican_restaurant", "greek_restaurant",
  "korean_restaurant", "french_restaurant", "vegan_restaurant", "vegetarian_restaurant",
  "burger_restaurant", "pizza_place", "seafood_restaurant", "sushi_bar", "buffet",
  "hookah_lounge", "brewery", "wine_bar", "cannabis_dispensary", "comedy_club",
  "music_venue", "karaoke_bar", "escape_room", "arcade", "laser_tag_center",
  "trampoline_park", "climbing_gym", "skate_park", "yoga_studio", "pilates_studio",
  "martial_arts_school", "boxing_gym", "crossfit_gym", "dance_studio", "photography_studio",
  "printing_shop", "coworking_space", "web_design_agency", "marketing_agency",
  "consulting_firm", "interior_design_studio", "architecture_firm", "construction_company",
  "solar_energy_company", "wind_energy_company", "landscaping_service", "gardening_store",
  "paint_store", "tile_store", "bathroom_showroom", "kitchen_showroom", "baby_store",
  "toy_store", "gift_shop", "party_store", "stationery_store", "mobile_store",
  "tech_repair", "phone_store", "computer_store", "pawn_shop", "antique_store",
  "thrift_store", "vintage_store", "outdoor_gear_store", "hiking_store", "camping_store",
  "bike_repair", "auto_parts_store", "motorcycle_shop", "car_wash", "auto_repair_shop",
  "oil_change_station", "tire_shop", "notary_service", "translation_service",
  "immigration_lawyer", "family_lawyer", "tax_consultant", "real_estate_lawyer",
  "childcare_center", "preschool", "elementary_school", "high_school", "language_school",
  "driving_school", "test_center", "unemployment_office", "visa_center", "passport_office",
  "municipal_building", "city_hall", "community_center", "food_bank", "homeless_shelter",
  "recycling_center", "waste_management", "animal_shelter", "wildlife_rescue",
  "eco_tourism_center", "heritage_site", "botanical_garden", "nature_reserve",
  "scuba_shop", "surf_shop", "ski_resort", "snowboard_rental", "ice_skating_rink",
  "boat_rental", "marina", "fishing_store", "hunting_store", "gun_shop", "archery_range",
  "paintball_park", "drone_shop", "3d_printing_lab", "makerspace", "tech_startup_office",
  "coding_school", "e_learning_center", "podcasting_studio", "film_studio", "music_school",
  "recording_studio", "tattoo_removal", "med_spa", "dermatology_clinic", "eye_clinic",
  "urgent_care", "nursing_home", "rehabilitation_center", "blood_donation_center"
];

    types.forEach(type => {
      const formattedType = type.replace(/_/g, ' ');
      $("#checkbox-container").append(`
        <div class="flex items-center">
          <input type="checkbox" id="${type}" name="place-types" value="${type}" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
          <label for="${type}" class="ml-2 text-sm text-gray-700 capitalize">${formattedType}</label>
        </div>
      `);
    });


});

document.getElementById('upload-form').addEventListener('submit', function (e) {
    // Collect checked values or default to ['restaurant']
    const selectedTypes = $('input[name="place-types"]:checked').map((_, el) => el.value).get() || ['restaurant'];
    document.getElementById('floating_sectors_value').value = selectedTypes.join(', ');
  });

</script>

</div>  

@endsection