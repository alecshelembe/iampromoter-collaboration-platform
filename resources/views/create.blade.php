
@extends('welcome')

@section('content')

<script defer src="{{ asset('js/jq_app.js') }}"></script>
<script defer src="{{ asset('js/app.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places" defer></script>

<script>
     // For first name
     document.getElementById('floating_first_name').addEventListener('input', function() {
        var inputVal = this.value; // Get the value from input field
        document.getElementById('output-card-person-firstname').textContent = inputVal; // Set the value of output field
    });

    // For last name
    document.getElementById('floating_last_name').addEventListener('input', function() {
        var inputVal = this.value; // Get the value from input field
        document.getElementById('output-card-person-lastname').textContent = ' ' + inputVal; // Set the value of output field with space
    });
</script>


<div class="mx-auto max-w-sm p-4">
<form class="space-y-6 animate-fadeIn" action="{{ route('users.store') }}" enctype="multipart/form-data" method="post">
    @csrf
    @if($decoded_email)
        <p class="text-gray-500 text-sm">Reference: {{ $decoded_email }}</p>
        @error('ref')
        <p class="text-red-600  mt-1">{{ $message }}</p>
        @enderror
        <input type="text" name="ref" value="{{ $fullemail }}" class="hidden text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
    @else
        {{-- <p>No reference email provided.</p> --}}
    @endif
    
    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="floating_first_name" value="{{ old('floating_first_name') }}" id="floating_first_name" class="block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required placeholder=""  />
            <label for="floating_first_name" class="peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Enter your first name</label>
            @error('floating_first_name')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="floating_last_name" value="{{ old('floating_last_name') }}" id="floating_last_name" class="block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required placeholder=""  />
            <label for="floating_last_name" class="peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Enter your last name</label>
            @error('floating_last_name')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
    
<!-- </div> -->
<div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-5 group">
        <input type="email" name="floating_email" value="{{ old('floating_email') }}" id="floating_email" class="block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required placeholder=""  />
        <label for="floating_email" class=" md:text-sm lg:text-sm truncate truncate peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"><i class="fa-regular fa-envelope"></i> : Enter e-mail address</label>
        @error('floating_email')
        <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="tel" pattern="^0\d{9}" placeholder="" maxlength="10" name="floating_phone" value="{{ old('floating_phone') }}" id="floating_phone" class="block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required />
            <label for="floating_phone" class=" md:text-sm truncate peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"><i class="fa-solid fa-phone"></i> : Enter phone number</label>
            @error('floating_phone')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="grid w-full">
        <span class=" text-gray-500"> <i class="fa-solid fa-location-dot"> </i> : Enter Address <i class="fa-solid fa-circle-check"></i> address search (optional)</span>
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="floating_address" value="{{ old('floating_address') }}" id="floating_address" class="block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <!-- <label for="floating_address" class="peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Enter Street name...</label> -->
            @error('floating_address')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
    
    <div class="grid w-full">
        <div class="relative z-0 w-full mb-5 group">
            <!-- Image Input Container -->
            <label for="floating_prfile_image" class="mb-5 peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Upload a profile photo (optional)</label>
            <input type="file" name="image" id="image-upload" class="mt-4 block w-full  text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept="image/*" onchange="previewImage(event)" />
        </div>
        @error('image')
        <p class="text-red-600  mt-1">{{ $message }}</p>
        @enderror
    </div>
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

          <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-5 group">
                <input type="password" autocomplete="new-password" name="password" id="floating_password" class="block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required />
                <label for="floating_password" class="peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Enter a password</label>
                @error('password')
                    <p class="text-red-600  mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="password" name="password_confirmation" autocomplete="new-password" id="floating_repeat_password" class="block py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required />
                <label for="floating_repeat_password" class="peer-focus:font-medium absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Re-enter password</label>
                @error('password_confirmation')
                    <p class="text-red-600  mt-1">{{ $message }}</p>
                @enderror
            </div>            
        </div>
        <div class="grid w-full">
            <div class="relative z-0 w-full mb-5 group">
            <label for="options" class="block text-gray-700 mb-2">select an option:</label>
                <select id="options" name="position" class=" focus:ring-blue-300 font-medium rounded-lg  w-full px-5 py-2.5 text-left dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 block border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:">
                    <option value="Visitor" {{ old('position') == 'Visitor' ? 'selected' : '' }}>Visitor</option>
                    <option value="Student" {{ old('position') == 'Student' ? 'selected' : '' }}>Student</option>
                    <option value="Business-owner" {{ old('position') == 'Business-owner' ? 'selected' : '' }}>Business-owner</option>
                    <option value="Promoter" {{ old('position') == 'Promoter' ? 'selected' : '' }}>Promoter</option>
                    <!-- <option value="content-moderator" {{ old('position') == 'content-moderator' ? 'selected' : '' }}>Content moderator</option> -->
                    </select>
                @error('position')
                <p class="text-red-600  mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="w-full">
            <div class=" ">
                <input type="checkbox" name="terms_and_conditions" id="terms_and_conditions" class="mr-2 leading-tight" required/>
                <label for="terms_and_conditions" class=" text-gray-900 dark:text-white">
                    I agree to the <a  href="{{ route('termsandconditions') }}" class="text-blue-600 dark:text-blue-500 hover:underline">Terms and Conditions</a>
                </label>
            </div>
        </div>
    
        <!-- ///////////////////// -->
         
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
            
            </div>
                <!-- <div class="px-6 pt-4 pb-2"> -->
                    <!-- <span class="inline-block bg-gray-200 rounded-full px-3 py-1  font-semibold text-gray-700 mr-2 mb-2">#photography</span> -->
                    <!-- <span class="inline-block bg-gray-200 rounded-full px-3 py-1  font-semibold text-gray-700 mr-2 mb-2">#travel</span> -->
                    <!-- <span class="inline-block bg-gray-200 rounded-full px-3 py-1  font-semibold text-gray-700 mr-2 mb-2">#winter</span> -->
                <!-- </div> -->
        <!-- ///////////////////////////// -->
         
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg  w-full  px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create account</button>
        <div class=" font-medium text-gray-500 dark:text-gray-300">
            Already registered? <a href="{{ route('login') }}" class="text-blue-700 hover:underline dark:text-blue-500">Login</a>
        </div>
    </div>
    </form>
    </div>
@endsection
