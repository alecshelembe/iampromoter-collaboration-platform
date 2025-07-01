@extends('welcome')

@include('layouts.navbar')  

@section('content')

    <div class="flex justify-end">
        <button id="toggleView" class="px-4 py-2 text-white bg-blue-500 rounded-lg">
            <i class="fa-regular fa-eye"></i> 
        </button>
    </div>

    <div id="postContainer" class="grid grid-cols-2 gap-4 mt-4 lg:grid-cols-4">
        @foreach ($results as $post)
            <div class="p-2 bg-white">
                <div class="grid grid-cols-2 gap-2">
                    {{-- Parse and display images --}}
                    @php
                        $images = json_decode($post->images, true); // Decode JSON
                    @endphp

                    @if (is_array($images) && count($images) > 0)
                        @foreach ($images as $image)
                            <figure class="max-w-lg relative">
                                <img class="h-auto max-w-full rounded-lg cursor-pointer"
                                    src="{{ asset($image) }}"
                                    alt="Post image"
                                    loading="lazy">
                            </figure>
                        @endforeach
                    @else
                        <p>No images found.</p>
                    @endif
                </div>

                {{-- Display post description and email --}}
                <div class="mt-4">

                    <p class="text-sm text-gray-700 ">{{ $post->place_name }}</p>
                    <p class="text-sm text-grey-500">R {{ $post->fee }}</p>
                    <p class="text-sm text-gray-700">{{ $post->address }}</p>

                    <div>
                        <button type="button"
                                class="remove-from-cart-btn p-2 text-sm rounded-full shadow-lg"
                                data-post-id="{{ $post->id }}">
                            Remove
                        </button>
                    </div>
                </div>
            </div> {{-- End of post card --}}
        @endforeach
    </div> {{-- End of post container --}}

    <script>
        const toggleButton = document.getElementById('toggleView');
        const postContainer = document.getElementById('postContainer');
        let isGrid = true;

        toggleButton.addEventListener('click', function() {
            if (isGrid) {
                postContainer.classList.remove('grid', 'grid-cols-2', 'lg:grid-cols-4');
                postContainer.classList.add('flex', 'flex-col');
            } else {
                postContainer.classList.remove('flex', 'flex-col');
                postContainer.classList.add('grid', 'grid-cols-2', 'lg:grid-cols-4');
            }
            isGrid = !isGrid;
        });

        // JavaScript for handling the remove button
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-from-cart-btn');

            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.dataset.postId;
                    const postCard = this.closest('.p-2.bg-white');

                    if (confirm('Are you sure you want to remove this item?')) {
                        // Construct the URL with the ID
                        const url = `/remove-from-cart/${postId}`;

                        fetch(url, { // Use the constructed URL
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json', // Still good practice, though not strictly needed for the ID
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            // No 'body' needed for the ID now, as it's in the URL
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                alert(data.message);
                                if (postCard) {
                                    postCard.remove();
                                }
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while removing the item.');
                        });
                    }
                });
            });
        });
    </script>

@endsection