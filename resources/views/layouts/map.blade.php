@extends('welcome')

@section('content')
<style>
    #map {
        height: 90vh;
        width: 100%;
    }

    .card-overlay {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: 90vw;
    }

    .card-overlay .grid-cols-2 img {
        height: 100px;
        object-fit: cover;
        width: 100%;
    }

    @media (min-width: 640px) {
        .card-overlay {
            width: 400px;
        }
    }
</style>

<div id="map"></div>

<script>
    function initMap() {
        const johannesburg = { lat: -26.2041, lng: 28.0473 }; // Johannesburg coordinates
        const map = new google.maps.Map(document.getElementById("map"), {
            center: johannesburg,
            zoom: 11, // Adjust zoom level for Johannesburg
            styles: [
                { featureType: "poi", stylers: [{ visibility: "off" }] },
                { featureType: "administrative", stylers: [{ visibility: "off" }] },
                { featureType: "road", elementType: "labels.icon", stylers: [{ visibility: "off" }] },
                { featureType: "transit", stylers: [{ visibility: "off" }] },
                { featureType: "water", stylers: [{ visibility: "off" }] },
                { featureType: "road.highway", elementType: "geometry", stylers: [{ color: "#cccccc" }] },
                { featureType: 'road.local', elementType: 'geometry', stylers: [{ color: '#cccccc' }] },
                { featureType: 'road.arterial', elementType: 'geometry', stylers: [{ color: '#cccccc' }] },
                { featureType: "road", elementType: "labels.text.stroke", stylers: [{ visibility: "off" }] },
                { featureType: "road", elementType: "labels.text.fill", stylers: [{ color: "#000000" }] }
            ]
        });

        // Optional: Add a marker for Johannesburg center
        new google.maps.Marker({
            position: johannesburg,
            map: map,
            title: "Johannesburg",
        });

        @foreach ($socialPosts as $post)
        geocodeAndOverlay(map, "{{ $post->address }}", `
            <div class="card-overlay">
                <?php
                    $images = json_decode($post->images, true);
                ?>
                @if (is_array($images) && count($images) > 0)
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        @foreach ($images as $image)
                            <figure class="relative">
                                <img class="rounded-lg cursor-pointer" src="{{ asset($image) }}" alt="Post image" loading="lazy">
                            </figure>
                        @endforeach
                    </div>
                @endif
                <div class="flex items-center space-x-3">
                    <img 
                        src="{{ $post->profile_image_url ? Storage::url($post->profile_image_url) : asset('default-profile.png') }}" 
                        name="image" 
                        loading="lazy"
                        alt="Profile Image" 
                        style="width: 50px; height: 50px; border-radius: 50%;" 
                        class="object-cover shadow-md" 
                    />
                    <div class="flex-1">
                        <p class="text-sm font-bold">{{ $post->place_name }}</p>
                        <p class="text-sm font-semibold text-grey-500">R {{ $post->fee }}</p>
                        <p class="text-sm text-gray-700">{{ $post->address }}</p>
                        <p class="text-xs text-gray-400">Posted by {{ $post->author }}</p>
                        @if (!empty($post->note))
                            <div class="flex flex-col leading-1.5 p-2 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700 mt-1">
                                <p class="text-sm font-normal text-gray-900 dark:text-white" title="{{ $post->note }}"> {{ Str::limit($post->note, 25) }}</p>
                            </div>
                        @endif
                        <p class="text-xs text-gray-400">{{ $post->formatted_time }}</p>
                    </div>
                    <div>
                        @if(Auth::check())
                            <a href="{{ route('social.view.post', ['id' => $post->id]) }}" class="p-2 text-sm rounded-full shadow-lg bg-blue-600 text-white">
                                View
                            </a>
                        @elseif(Auth::guard('google_users')->check())
                            <a href="{{ route('google.social.view.post', ['id' => $post->id]) }}" class="p-2 text-sm rounded-full shadow-lg bg-blue-600 text-white">
                                View
                            </a>
                        @else
                            <a href="{{ route('social.view.post', ['id' => $post->id]) }}" class="p-2 text-sm bg-blue-500 text-white rounded-full shadow-lg hover:bg-green-600">
                                Login
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        `);
        @endforeach
    }

    function geocodeAndOverlay(map, address, content) {
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'address': address }, function(results, status) {
            if (status === 'OK') {
                const marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
                    title: address
                });

                const infowindow = new google.maps.InfoWindow({
                    content: content,
                });

                marker.addListener("click", () => {
                    infowindow.open(map, marker);
                });

            } else {
                console.error('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&libraries=places">
</script>
@endsection