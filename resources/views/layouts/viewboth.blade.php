@extends('welcome')

@section('content')
    @include('layouts.navbar')

    {{-- Posts Section --}}
    @if ($posts->isEmpty() && $socialPosts->isEmpty())
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5>No Posts here..</h5>
        </div>
    @else
        {{-- Combined Grid Layout for Posts --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {{-- Merge $posts and $socialPosts --}}
            @php
                $combinedPosts = collect();

                // Merge $posts and $socialPosts into one collection
                $combinedPosts = $combinedPosts->merge($posts)->merge($socialPosts);

                // Sort the combined posts by created_at in descending order
                $combinedPosts = $combinedPosts->sortByDesc('created_at');
            @endphp

            {{-- Loop through merged and sorted posts --}}
            @foreach ($combinedPosts as $post)
                @php
                    $isSocialPost = isset($post->images); // Check if it's a social post
                @endphp

                <div class="bg-white p-4 rounded-lg shadow mb-4">
                    {{-- Regular Post --}}
                    @if (!$isSocialPost)
                        <h3 class="font-bold text-2xl mb-2">{{ $post->title }}</h3>

                        {{-- Verification Status --}}
                        <p class="text-sm mt-2">
                            @if ($post->verified === 1)
                                <i class="fa-solid fa-circle-check"></i> Verified
                            @else
                                <i class="fa-regular fa-circle-question"></i> Not Verified
                            @endif
                        </p>

                                                {{-- Post Description --}}
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

                        {{-- Post Image --}}
                        @if ($post->plate === 1)
                            <div class="mt-4">
                                <img class="w-full h-auto rounded" src="{{ $post->image_url }}" alt="">
                            </div>
                        @endif

                        {{-- Generate Speech Form --}}
                        <div class="mt-4">
                            <form action="{{ route('returnSpeech') }}" target="_blank" method="POST">
                                @csrf
                                <textarea name="text" rows="4" style="display: none;" placeholder="Enter text here">{{ $post->description }}</textarea>
                                <input type="hidden" name="audio_id" value="{{ rand() }}">
                                <button type="submit" class="text-sm">
                                    Generate Speech <i class="fa-solid fa-volume-high"></i>
                                </button>
                            </form>
                        </div>

                        {{-- Post Author and Time --}}
                        <div class="mt-2 text-sm text-gray-500">
                            <p>By: {{ $post->author }}</p>
                            <p>{{ $post->formatted_time }}</p>
                        </div>
                        <div class="text-right">
                            <a href="https://wa.me/?text={{ urlencode(route('science.view.post', ['id' => $post->id])) }}" 
                                target="_blank" 
                                class="p-2 text-sm rounded-full shadow-lg">
                                <i class="fa-brands fa-whatsapp"></i> Share
                            </a>
                        </div>

                        <a href="{{ route('science.view.post', ['id' => $post->id]) }}" 
                        class="p-2 text-sm rounded-full shadow-lg">
                            View
                        </a>
                        
                    @endif

                    {{-- Social Post --}}
                    @if ($isSocialPost)
                        @php
                            $images = json_decode($post->images, true); // Decode JSON
                        @endphp

                        @if (is_array($images) && count($images) > 0)
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($images as $image)
                                    <figure class="relative">
                                        <img class="h-auto max-w-full rounded-lg cursor-pointer" src="{{ asset($image) }}" alt="Post image" loading="lazy">
                                    </figure>
                                @endforeach
                            </div>
                        @else
                            <p>No images found.</p>
                        @endif

                        {{-- Post Description and Info --}}
                        <div class="mt-4">
                            <p class="text-sm text-gray-700">{{ $post->description }}</p>
                            <p class="text-xs text-gray-500">Posted by {{ $post->author }}</p>
                            <p class="text-xs text-gray-500">{{ $post->formatted_time }}</p>
                            <div class="text-right">
                                <a href="{{ route('social.view.post', ['id' => $post->id]) }}" class="p-2 text-sm rounded-full shadow-lg">
                                    View
                                </a>
                            </div>                        
                        </div>

                    @endif
                </div>
            @endforeach
        </div>
    @endif

@endsection
