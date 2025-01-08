
@extends('welcome')

@section('content')
  
@include('layouts.navbar')  

@if($posts->isEmpty())
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5>No Posts here..</h5>
        </div>
    @else
    <div class="flex justify-end">
        <button id="toggleView" class="px-4 py-2 text-white bg-blue-500 rounded-lg"><i class="fa-regular fa-eye"></i> View</button>
    </div>
    <div id="postContainer" class="grid grid-cols-2 gap-4 mt-4 lg:grid-cols-4">
        @foreach($posts as $post)
            <div class="p-2  bg-white">
                <div class="grid grid-cols-2 gap-4">
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
                        <!-- <p>No images found.</p> -->
                    @endif
                </div>
     
                {{-- Display post description and email --}}
                <div class="mt-4">
                    <p class="text-lg font-bold">{{ $post->title }}</p>
                    @if ($post->description)
                            {{-- Truncated Description --}}
                            <div class="mt-2 text-gray-700 overflow-hidden" 
                                style="max-height: 4.5em; line-clamp: 3; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;" 
                                id="description-{{ $post->id }}">
                                {!! $post->description !!}
                            </div>

                            {{-- "More"/"Less" Button --}}
                            <button class="text-blue-500 text-sm mt-2" 
                                    onclick="toggleText('{{ $post->id }}', this)">
                                More
                            </button>
                        @endif

                    <script>
                            /**
                             * Toggle truncation for a specific description.
                             * @param {string} id - The ID of the description element to toggle.
                             * @param {HTMLElement} button - The button that toggles the truncation.
                             */
                            function toggleText(id, button) {
                                const description = document.getElementById(`description-${id}`);
                                if (description.style.maxHeight === "4.5em") {
                                    description.style.maxHeight = "none"; // Remove truncation
                                    description.style.webkitLineClamp = "unset"; // Remove line clamp
                                    button.innerText = "Less"; // Change button text
                                } else {
                                    description.style.maxHeight = "4.5em"; // Reapply truncation
                                    description.style.webkitLineClamp = "3"; // Reapply line clamp
                                    button.innerText = "More"; // Change button text
                                }
                            }
                        </script>
                    
                    <div class="text-right">
                        <a href="{{ route('science.view.post', ['id' => $post->id]) }}" 
                        class=" p-2 text-sm rounded-full shadow-lg">
                            View
                        </a>
                    </div>
                    
                </div>
            </div>
        @endforeach
    </div>

    <script>
        const toggleButton = document.getElementById('toggleView');
        const postContainer = document.getElementById('postContainer');
        
        let isGrid = true;
        
        toggleButton.addEventListener('click', function() {
            if (isGrid) {
                postContainer.classList.remove('grid', 'grid-cols-2');
                postContainer.classList.add('flex', 'flex-col');
            } else {
                postContainer.classList.remove('flex', 'flex-col');
                postContainer.classList.add('grid', 'grid-cols-2');
            }
            isGrid = !isGrid;
        });
    </script>
    @endif
    
@endsection
