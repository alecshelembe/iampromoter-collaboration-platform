@extends('welcome')

@section('content')

@if(Auth::check() || Auth::guard('google_users')->check())
    <!-- Content for authenticated users -->
    @if(Auth::guard('google_users')->check())
        @include('google.navbar')
    @else
        @include('layouts.navbar')
    @endif
@else
    <!-- If not authenticated, redirect to login -->
    <script>
        window.location.href = "{{ route('login') }}";
    </script>
@endif

    {{-- Posts Section --}}
    @if ($posts->isEmpty() && $socialPosts->isEmpty())
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5>No Posts here..</h5>
        </div>
    @else
        {{-- Combined Grid Layout for Posts --}}

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
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
                    $isSocialPost = isset($post->social_p); // Check if it's a social post
                @endphp

                <div class="bg-white p-2 rounded-lg shadow">
                    {{-- Regular Post --}}
                    @if (!$isSocialPost)

                        <div>
                            {{-- Parse and display images --}}
                            @php
                                $images = json_decode($post->image_url, true); // Decode JSON for a single post
                            @endphp

                            @if (is_array($images) && count($images) > 0)
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach ($images as $image)
                                        <figure class="max-w-lg relative">
                                            <img class="h-auto max-w-full rounded-lg cursor-pointer" 
                                                src="{{ asset($image) }}" 
                                                alt="Post image"
                                                loading="lazy"
                                                onclick="toggleImageModal('{{ asset($image) }}')">
                                        </figure>
                                    @endforeach
                                </div>
                            @else
                                <!-- <p>No images found.</p> -->
                            @endif
                        </div>
                        
                        <h3 class="mb-2">{{ $post->title }}</h3>

                        {{-- Verification Status --}}
                        <p class="text-sm mt-2">
                            @if ($post->verified == 1 || $post->plate == 1)
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

                        {{-- Post Author and Time --}}
                        <div class="mt-2 text-sm text-gray-400">
                            <p>{{ $post->formatted_time }}</p>
                        </div>

                        <div class="text-right">
                            <a href="{{ route('science.view.post', ['id' => $post->id]) }}"
                            class="p-2 text-sm rounded-full shadow-lg">
                                View
                            </a>
                        </div>
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
                                        <img class="h-auto max-w-full rounded-lg cursor-pointer" src="{{ asset($image) }}" alt="Post image" loading="lazy" onclick="toggleImageModal('{{ asset($image) }}')">
                                    </figure>
                                @endforeach
                            </div>
                        @endif

                        {{-- Post Description and Info --}}
                        <div class="mt-4 flex items-center space-x-3">
                            <!-- User Avatar -->
                            <img  
                                src="{{ Storage::url($post->profile_image_url) }}"  
                                name="image" 
                                onclick="toggleImageModal('{{ Storage::url($post->profile_image_url) }}')"
                                loading="lazy"
                                alt="Image Preview"  
                                style="width: 50px; height: 50px; border-radius: 50%;" 
                                class="object-cover shadow-md" 
                            />

                            <!-- Post Details -->
                            <div class="flex-1">
                                <p class="text-sm">{{ $post->place_name }}</p>
                                <!-- <p class="text-sm text-grey-500">R {{ $post->fee }}</p> -->
                                <p class="text-sm text-gray-700">{{ $post->address }}</p>
                                <p class="text-xs text-gray-400">Posted by {{ $post->author }}</p>
                                @if (!empty($post->note))
                                <div class="flex flex-col leading-1.5 p-2 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                    <p class="text-sm font-normal text-gray-900 dark:text-white "  title="{{ $post->note }}">  {{ Str::limit($post->note, 25) }}</p>
                                </div>
                                @endif
                                <p class="text-xs text-gray-400">{{ $post->formatted_time }}</p>
                            </div>

                            <!-- View Button -->
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
                               
                            @endif

                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

@endsection
