<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script defer async src="https://www.googletagmanager.com/gtag/js?id=G-Y5VZ02ZX88"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-Y5VZ02ZX88');
    </script>

    <!-- Pixel Code - https://social-proof.acalytica.com/ -->
    <script defer src="https://social-proof.acalytica.com/pixel/DE30Dy8HM6mmSeYg91c8qWg9Kbjb9Iy8"></script>
    <!-- END Pixel Code -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Primary Meta Tags -->
    <meta name="title" content="Collabz">
    <meta name="description" content="Collabz">
    <meta name="keywords" content="Collabz">
    <meta name="author" content="Visit My Joburg Team">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Collabz</title>

    <link rel="canonical" href="https://visitmyjoburg.co.za">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">
    <link rel="icon" href="{{ config('services.project.logo_image') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet">
    <script defer src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

    <!-- --------- Does not work with defer -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
     <!-- ---------------- -->

    <script defer src="https://kit.fontawesome.com/06f647569e.js" crossorigin="anonymous"></script>
    <script defer src="{{ asset('js/browser-image-compression.js') }}"></script>
    <!-- <script defer src="{{ asset('js/ckeditor.js') }}"></script> -->
    <script src="{{ asset('js/jQuery.js') }}"></script>
</head>

    <style>
        @media (max-width: 700px) { /* Tailwind's sm breakpoint */
        .Scibono-background {
            /* Background color */
            /* background-color: #f0f0f0; */

            /* Background image 
            background-image: url('{{ asset('storage/sci-bono-content/browser-fill-2.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
             background-position: center; */
            }
           
        }
        

    </style>
    <body class="m-4">

        {{-- <div id="map" style="height: 500px; width: 100%;"></div> --}}
        @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

    </body>
    <script>
    function toggleImageModal(src) {
        let existingModal = document.getElementById("image-modal");
        
        if (existingModal) {
            existingModal.remove(); // Close the modal if it exists
            return;
        }

        // Create modal container with gray background
        let modal = document.createElement("div");
        modal.id = "image-modal";
        modal.classList.add("fixed", "inset-0", "flex", "items-center", "justify-center", "bg-gray-800", "bg-opacity-75", "z-50");

        // Create image element
        let img = document.createElement("img");
        img.src = src;
        img.classList.add("max-w-full", "max-h-screen", "rounded-lg", "shadow-lg");

        // Close modal when clicking outside image
        modal.onclick = () => modal.remove();

        // Close modal on ESC key
        document.addEventListener("keydown", function escListener(event) {
            if (event.key === "Escape") {
                modal.remove();
                document.removeEventListener("keydown", escListener);
            }
        });

        modal.appendChild(img);
        document.body.appendChild(modal);
    }
</script>
<footer class="sticky text-xs bottom-0 w-full text-center py-2 text-gray-600 dark:text-gray-400">
            &copy;
        </footer>
   </html>