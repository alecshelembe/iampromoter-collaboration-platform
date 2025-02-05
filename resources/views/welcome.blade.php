<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-Y5VZ02ZX88"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-Y5VZ02ZX88');
        </script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="title" content="Street King | Your Platform for Connecting Businesses and Customers">
        <meta name="description" content="Discover Street King – the ultimate platform for promoting businesses and connecting with influencers. Explore, connect, and grow your business today!">
        <meta name="keywords" content="Street King, business promotion, influencer marketing, grow your business, connect with customers">
        <meta name="author" content="alec - Street King">
        
        <title>Street King</title>
        
        <!-- Fonts -->
         <!-- Google tag (gtag.js) -->
          <!-- Meta Title: Keep it concise and keyword-rich -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('css/output.css') }}">
        <link rel="icon" href="{{ config('services.project.logo_image') }}" type="image/x-icon">
        <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
        <script defer src="https://kit.fontawesome.com/06f647569e.js" crossorigin="anonymous"></script>
        <!-- Ensure the script loads properly -->
        <script defer src="{{ asset('js/browser-image-compression.js') }}"></script>

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
        <footer>
        </footer>
    </body>
   </html>
