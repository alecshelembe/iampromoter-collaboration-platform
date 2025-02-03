@extends('welcome')

@section('content')


<script defer src="{{ asset('js/jq_app.js') }}"></script>
<script defer src="{{ asset('js/places-search.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places" defer></script>


<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg mt-10">
<h1 class="text-3xl font-bold mb-6">Create a mobile Post</h1>
<div class="flex justify-end mb-4">
  <form id="upload-form" action="{{ route('social.save.post') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Name -->
    <div class="my-4">
      <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Place</label>
      <input type="text" name="place_name" value="{{ old('place_name') }}" id="place_name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Name of the place." />
      @error('name')
      <p class="text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Options -->
    
    <p for="description" class="block text-sm font-medium text-gray-700 mb-2">Select amenities</p>
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <div class="flex items-center space-x-2">
          <input type="checkbox" id="wifi" name="extras[]" value="wifi" class="peer hidden">
          <label for="wifi" class="flex items-center space-x-2 cursor-pointer text-gray-700 peer-checked:text-blue-600">
              <i class="fa-solid fa-wifi"></i>
              <span>WiFi</span>
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
    <div class="my-4">
      <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
      <textarea name="description" id="description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Write your promotion, review, description or other."></textarea>
      @error('description')
      <p class="text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        @for ($i = 1; $i <= 4; $i++)
            <figure class="max-w-lg relative">
                <img id="img-{{ $i }}" class="h-auto max-w-full rounded-lg cursor-pointer" 
                     src="{{ asset('/storage/images/default-camera.jpg') }}" alt="image description">
                <input type="file" id="file-input-{{ $i }}" class="hidden" name="images[]" accept="image/*">
            </figure>
        @endfor
    </div>
    
    <div class="my-4">
    <span class="text-gray-500"> Finish the above then choose sectors to link with your post (Optional) </span>
    
    <div id="checkbox-container" class="my-4 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
      <!-- Checkboxes will be populated dynamically -->
    </div>

    
    <div id="location-result" class="mt-4 text-gray-700"></div>
    <div id="address-result" class="mt-4 text-gray-700"></div>
    
    <div class="flex justify-center items-center">
        <button type="button" id="geo-locate-btn" class="bg-blue-500 text-white btn-sm py-2 px-2 rounded-full hover:bg-blue-600">
          <span><i class="fa-solid fa-location-arrow"></i> Get My Location <i class="fa-solid fa-location-dot"> </i> Tag an address <i class="fa-solid fa-circle-check"></i> address search</span>
        </button>
    </div>

    <div class="relative z-0 w-full mb-5 group">
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

    <div class="text-right h-64">
        <button type="submit" class="bg-blue-500 p-4 text-white rounded-full shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 mt-10">
            Post
        </button>
    </div>
</form>

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
        } catch (error) {
          console.error("Image compression failed:", error);
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

</div>  

@endsection