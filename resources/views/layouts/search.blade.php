@extends('welcome')

@section('content')

<!-- Load Google Maps API with Places library -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places" defer></script>

<div class="max-w-3xl mx-auto bg-white rounded-lg p-6">
<div class="text-center mb-6">
    <a href="{{ route('landing') }}" class="bg-blue-500 text-white btn-sm py-2 px-2 rounded-full hover:bg-blue-600">
    <!-- Plus icon -->
    Search with address
    <i class="fa-solid fa-arrow-left-long"></i>
    </a>
</div>
    <h5 class="text-xl my-4 text-center font-medium text-gray-900 dark:text-white">
        <a href="{{ route('login') }}">
            <span class="text-bold underline">Sign in</span> to our platform
        </a>
    </h5>
    <h1 class="text-2xl font-bold text-center mb-6">Find Places</h1>

    <!-- Search Bar -->
    <div class="flex justify-center items-center">
        <input type="text" id="floating_address" name="floating_address" value="{{ old('floating_address') }}" id="floating_address" class="mb-2 block py-2.5 px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                   
        <button type="button" placeholder="Search for places (e.g., restaurants, cafes)" id="searchButton" class="bg-blue-500 text-white btn-sm py-2 px-2 rounded-full hover:bg-blue-600">
          <span> <i class="fa-solid fa-magnifying-glass"></i> Search</span>
        </button>
    </div>
    <div id="results"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        console.log("Document ready. Initializing PlacesService...");

        // Initialize the PlacesService after the Google Maps API is loaded
        const initializePlacesService = () => {
            console.log("Google Maps API loaded. Setting up PlacesService...");

            const resultsDiv = document.getElementById('results');
            const searchButton = document.getElementById('searchButton');

            const map = new google.maps.Map(document.createElement('div')); // Invisible map container
            const service = new google.maps.places.PlacesService(map);

            // Function to handle search
            const performSearch = (query) => {
                if (!query) {
                    alert("Please enter a search query.");
                    return;
                }

                console.log("Performing search for query:", query);

                const request = {
                    query,
                    fields: ['name', 'formatted_address', 'rating', 'geometry'],
                };

                // Perform a text search using PlacesService
                service.textSearch(request, (results, status) => {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        // console.log("Search successful. Results:", results);

                        // Clear existing results
                        resultsDiv.innerHTML = '';

                        // Display results
                        results.forEach((place, index) => {
                            // console.log(`Processing result #${index + 1}:`, place);

                            const placeDiv = document.createElement('div');
                            placeDiv.classList.add('rounded', 'transition');

                            placeDiv.innerHTML = `
                            <div class="bg-white rounded-lg h-54 shadow-md p-2 mb-4">
                                <img src="${place.icon}" alt="Restaurant Icon" class="w-10 h-10 mb-2">
                                <h3 class="text-xl font-semibold text-gray-800">${place.name}</h3>
                                ${place.opening_hours && place.opening_hours.open_now !== undefined ? `
                                    <p class="text-sm ${place.opening_hours.open_now ? 'text-green-500' : 'text-red-500'}">
                                        Open Now: ${place.opening_hours.open_now ? 'Yes' : 'No'}
                                    </p>` : ''}
                                ${place.formatted_address ? `
                                    <p class="text-sm text-gray-600">
                                        Near: ${place.formatted_address}
                                    </p>` : ''}
                                ${place.rating ? `
                                    <p class="text-sm text-yellow-500">
                                        Rating: ${place.rating} stars
                                    </p>` : ''}
                            </div>
                            `;

                            resultsDiv.appendChild(placeDiv);
                        });
                    } else {
                        console.error("Search failed with status:", status);
                        resultsDiv.innerHTML = `<p class="text-red-500">No results found or an error occurred.</p>`;
                    }
                });
            };

            // Copy text to clipboard
            window.copyToClipboard = (text) => {
                navigator.clipboard.writeText(text)
                    .then(() => alert('Address copied to clipboard!'))
                    .catch(err => console.error('Failed to copy text:', err));
            };

            // Attach event listener to the search button
            searchButton.addEventListener('click', () => {
                const query = document.getElementById('floating_address').value.trim();
                performSearch(query);
            });
        };

        // Wait for the Google Maps API to load
        if (typeof google !== 'undefined' && google.maps && google.maps.places) {
            initializePlacesService();
        } else {
            console.error("Google Maps API is not available.");
        }
    });
</script>

@endsection
