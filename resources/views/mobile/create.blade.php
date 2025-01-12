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
    <div class="grid grid-cols-2 gap-4">
        @for ($i = 1; $i <= 4; $i++)
            <figure class="max-w-lg relative">
                <img id="img-{{ $i }}" class="h-auto max-w-full rounded-lg cursor-pointer" 
                     src="{{ asset('/storage/images/default-camera.jpg') }}" alt="image description">
                <input type="file" id="file-input-{{ $i }}" class="hidden" name="images[]" accept="image/*">
            </figure>
        @endfor
    </div>

     <!-- Description -->
     <div class="my-4">
        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
        <textarea name="description" id="description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Write your review, description or other."></textarea>
        @error('description')
        <p class="text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="my-4">
    <span class="text-gray-500"> Choose sectors to search </span>
    
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
        <div  class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4" id="results"></div>
    </div>

    <div class="text-right h-64">
        <button type="submit" class="bg-blue-500 p-4 text-white rounded-full shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 mt-10">
            Post
        </button>
    </div>
</form>

<script src="https://unpkg.com/browser-image-compression@latest/dist/browser-image-compression.js"></script>
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