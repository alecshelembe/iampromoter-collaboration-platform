
@extends('welcome')

@section('content')

<script defer src="{{ asset('js/jq_app.js') }}"></script>
<script defer src="{{ asset('js/app.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places" defer></script>


<div class="mx-auto max-w-sm p-4">
    <img  
        src="{{ Storage::url($user->profile_image_url) }}"
        name="image" 
        alt="Image Preview"  
        style="width: 150px; height: 150px; border-radius: 50%;" 
        class="mx-auto object-cover shadow-md m" />
<form class="space-y-6 animate-fadeIn" action="{{ route('profile.store') }}" enctype="multipart/form-data" method="post">
    @csrf
    
    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="floating_first_name" value=" {{ $user->first_name }}" id="floating_first_name" class="block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required placeholder=""  />
            <label for="floating_first_name" class="peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Update first name</label>
            @error('floating_first_name')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="floating_last_name" value="{{ $user->last_name }}" id="floating_last_name" class="block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required placeholder=""  />
            <label for="floating_last_name" class="peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Update last name</label>
            @error('floating_last_name')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
    
<!-- </div> -->
<div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-5 group">
        <input disabled type="email" name="floating_email" value="{{ $user->email }}" id="floating_email" class="cursor-not-allowed block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required placeholder=""  />
        <label for="floating_email" class=" md:text-sm lg:text-sm truncate truncate peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"><i class="fa-regular fa-envelope"></i> : e-mail </label>
        @error('floating_email')
        <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="tel" pattern="^0\d{9}" placeholder="" maxlength="10" name="floating_phone" value="{{ $user->phone }}" id="floating_phone" class="block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required />
            <label for="floating_phone" class=" md:text-sm truncate peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"><i class="fa-solid fa-phone"></i> : Update number</label>
            @error('floating_phone')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="grid w-full">
        <span class=" text-gray-500"> <i class="fa-solid fa-location-dot"> </i> : Enter Address <i class="fa-solid fa-circle-check"></i> address search</span>
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="floating_address" value="{{ $user->google_location }}" id="floating_address" class="block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <!-- <label for="floating_address" class="peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Enter Street name...</label> -->
            @error('floating_address')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
    
    <div class="grid w-full">
        

        <div class="relative z-0 w-full mb-4 group">
            <!-- Image Input Container -->
            <label for="floating_prfile_image" class="mb-5 peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Upload a profile photo</label>
            <input type="file" name="image" id="image-upload" class="mt-4 block w-full  text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept="image/*" onchange="previewImage(event)" />
        </div>
        @error('image')
        <p class="text-red-600  mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <input type="text" name="google_location" id="google_location" value="{{ $user->google_location }}" class="hidden text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
        <input type="text" name="google_latitude" id="google_latitude" value="{{ $user->google_latitude }}" class="hidden text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
            <input type="text" name="google_longitude" id="google_longitude" value="{{ $user->google_longitude }}" class="hidden text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
            <input type="text" name="google_location_type" id="google_location_type" value="{{ $user->google_location_type }}" class="hidden text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
            <input type="text" name="google_postal_code" id="google_postal_code" value="{{ $user->google_postal_code }}" class="hidden text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
            <input type="text" name="google_city" id="google_city" value="{{ $user->google_city }}" class="hidden text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
            <input type="text" name="package_selected" id="package_selected" value="{{ $user->package_selected }}" class="hidden text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
            <input type="text" name="web_source" id="web_source" value="{{ $user->web_source }}" class="hidden text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
            <input type="text" name="location_id" id="location_id" value="{{ $user->location_id }}" class="hidden text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
        </div>


        <div class="max-w-sm rounded overflow-hidden">
            <!-- Image Preview -->
                <div>
                <!-- <img id="image-preview" src="" name="image" alt="Image Preview"  style="width: 50%; height: 50%;" class="mx-auto hidden rounded-full object-cover rounded-md shadow-md" /> -->
                <img id="image-preview" 
                    src="" 
                    name="image" 
                    alt="Image Preview"  
                    style="width: 150px; height: 150px; border-radius: 50%;" 
                    class="mx-auto hidden object-cover shadow-md" />
                </div>
                <p class="mx-auto text-center"><span id="output-card-person-firstname" class="font-bold text-xl mb-2"></span><span id="output-card-person-lastname" class="font-bold text-xl mb-2"></span></p>
            
                <div class="hidden">
                    <p class="text-gray-700 text-base" id="output_web_source">  </p>
                    <p class="text-gray-700 text-base" id="output_location_id">  </p>
                    <p class="text-gray-700 text-base" id="output_package_selected">  </p>
                    <p class="text-gray-700 text-base" id="output_google_latitude">  </p>
                    <p class="text-gray-700 text-base" id="output_google_longitude">  </p>
                </div>
            </div>
         
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg  w-full  px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update my profile</button>
            
            
        </div>
    </form>
    </div>
@endsection
