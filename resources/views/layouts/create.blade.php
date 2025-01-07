
@extends('welcome')

@section('content')

<!-- Blade Template Button -->

<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg mt-10">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Create a New Post</h1>

<div class="text-right">
    <a href="{{ route('create.mobile.post') }}" class="bg-blue-500 p-4 text-white rounded-full shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
        <!-- Plus icon -->
        Create Social Post
    </a>
</div>
<!--     
<p class="mb-3 mt-8 text-gray-500 dark:text-gray-400 first-line:uppercase first-line:tracking-widest first-letter:text-7xl first-letter:font-bold first-letter:text-gray-900 dark:first-letter:text-gray-100 first-letter:me-3 first-letter:float-start">somthing</p>
<p class="text-gray-500 dark:text-gray-400">Before uploading, please take a moment to review your content to ensure it is safe, appropriate, and relevant for educational purposes. Your attention to detail helps us create a positive and enriching learning environment for all. Thank you for contributing to inspiring the next generation!</p> -->

    <div class="mt-4">
    <form action="{{ route('process.image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Title -->
        {{-- <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
            <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Enter the title" >
        </div> --}}
        
        <!-- Image Upload -->
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload Image to text output</label>
            <p class="text-gray-500">
                Our image-to-text feature allows you to easily convert images with text—such as signs, documents, or labels—into readable and editable text. Simply upload an image, and the tool will extract the text for you, saving time and making it easier to use the content on the next page!<br>
            </p>
            <ol>
                <li class=" text-black">1. Capture content with your camera </li>
                <li class=" text-black">2. Crop the image to read text only </li>
                <li class=" text-black">3. On the following page edit the output to read as the text. </li>
            </ol>
            <h2 class="text-bold text-2xl">Example of What your image should look like?</h2>
            <img class="mx-auto m-4 w-2/3" src="{{ asset('/storage/sci-bono-content/example-image-to-text.jpg') }}" alt="Uploaded Image">
            <p class="text-gray-500">
                Your output will be generated on the following page.<br>
            </p>
            <img class="mx-auto m-4 w-3/4" src="{{ asset('/storage/sci-bono-content/Development.png') }}" alt="Uploaded Image">
            
            <h1 class="text-xl mb-6 text-gray-800">Upload your image to convert below </h1>
            
            <img id="file-image" class="h-auto max-w-full rounded-lg cursor-pointer" 
                     src="{{ asset('/storage/images/default-camera.jpg') }}" alt="image description">
                
            <input type="file" name="image" id="image" class="w-full px-4 py-2 my-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            @error('image')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        {{-- <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Enter a description" ></textarea>
        </div> --}}
        
        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit" class="bg-blue-500 p-4 text-white rounded-full shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                Convert Image
            </button>
            <a href="{{ route('create.raw.post') }}" class="bg-blue-500 p-4 text-white rounded-full shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                <!-- Plus icon -->
                Create Raw Post
            </a>
        </div>

    </form>
    </div>
    
        
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
    handleImageUpload('file-image', 'image');
    </script>

</div>

@endsection
