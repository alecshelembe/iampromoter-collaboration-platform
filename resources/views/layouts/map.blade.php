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
        const johannesburg = { lat: -26.205874, lng:  28.037327 };

        const map = new google.maps.Map(document.getElementById("map"), {
            center: johannesburg,
            zoom: 14,
            styles: [
                { featureType: "poi", stylers: [{ visibility: "off" }] },
                { featureType: "administrative", stylers: [{ visibility: "off" }] },
                { featureType: "road", elementType: "labels.icon", stylers: [{ visibility: "off" }] },
                { featureType: "transit", stylers: [{ visibility: "off" }] },
                { featureType: "water", stylers: [{ visibility: "off" }] },
                { featureType: "road.highway", elementType: "geometry", stylers: [{ color: "#cccccc" }] },
                { featureType: "road.local", elementType: "geometry", stylers: [{ color: "#cccccc" }] },
                { featureType: "road.arterial", elementType: "geometry", stylers: [{ color: "#cccccc" }] },
                { featureType: "road", elementType: "labels.text.stroke", stylers: [{ visibility: "off" }] },
                { featureType: "road", elementType: "labels.text.fill", stylers: [{ color: "#000000" }] }
            ]
        });

        new google.maps.Marker({
            position: johannesburg,
            map: map,
            title: "Johannesburg",
        });

        // Markers and overlays from Laravel Blade
        @php $usedCoordinates = []; @endphp

        @foreach ($socialPosts as $post)
            @php
                $lat = floatval($post->lat);
                $lng = floatval($post->lng);
                $coordKey = $lat . ',' . $lng;
                $offset = 0;
                while (in_array($coordKey, $usedCoordinates)) {
                    $offset += 0.00005;
                    $lat += $offset;
                    $lng += $offset;
                    $coordKey = $lat . ',' . $lng;
                }
                $usedCoordinates[] = $coordKey;

                // Escape the content for JS string
                $content = view('partials.social-overlay', compact('post'))->render();
                $jsContent = json_encode($content);
            @endphp

            placeMarkerWithOverlay(map, {{ $lat }}, {{ $lng }}, {!! $jsContent !!});
        @endforeach
    }

    function placeMarkerWithOverlay(map, lat, lng, content) {
        const marker = new google.maps.Marker({
            map: map,
            position: { lat: lat, lng: lng },
        });

        const infowindow = new google.maps.InfoWindow({
            content: content,
            maxWidth: 400
        });

        marker.addListener("click", () => {
            infowindow.open(map, marker);
        });
    }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&libraries=places">
</script>
@endsection
