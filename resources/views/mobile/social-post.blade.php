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

<div class="max-w-4xl mx-auto bg-white rounded-lg">

    <div class="flex justify-center my-2">
        <p class="text-gray-700 rounded-full text-xs shadow-lg px-3 py-3 flex flex-wrap items-center gap-2">
            @foreach($socialPost->extras as $extra)
                <span class="flex items-center space-x-1">
                    <i class="fa-solid {{ getSectorIcon($extra) }} text-gray-700 text-xs"></i>
                    <span>{{ ucwords(str_replace('-', ' ', $extra)) }}</span>@if(!$loop->last), @endif
                </span>
            @endforeach
        </p>
    </div>
    
    {{-- Post Container --}}
    <div class="p-2 bg-white">
        <div>
            {{-- Parse and display images --}}
            @php
                $images = json_decode($socialPost->images, true); // Decode JSON for a single post
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

        {{-- Display post description and email --}}
        <div class="flex justify-center my-4">
            <a 
                href="https://www.google.com/maps/search/?api=1&query={{ urlencode($socialPost->address) }}" 
                target="_blank" 
                class="w-4/5 text-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                <i class="fa-solid fa-location-dot"></i> {{ $socialPost->address }}
            </a>
        </div>
        
        @if ($socialPost->status === 'show')
        <div class="flex justify-center my-4">
            <form action="{{ route('payfast.book-now', $socialPost->id) }}" method="POST">
                @csrf
                <button id="dynamicButton" class="bg-gradient-to-r from-purple-600 to-pink-500 hover:from-pink-500 hover:to-purple-600 text-white font-bold py-2 px-4 rounded-full shadow-lg transform transition-all duration-300 hover:scale-105 flex items-center gap-2">
                    <i class="fa-solid fa-fire-flame-curved"></i> Unlock the Magic!
                </button>
            </form>
            <button id="add-to-cart" value="{{($socialPost->id)}}" class="py-2 mx-4 px-4 rounded-full bg-blue-100 shadow-lg hover:scale-105 flex items-center gap-2">
                <i class="fa-solid fa-cart-plus"></i>
            </button>

             <!-- Message box for displaying success or error messages -->
             
            </div>
        <div class="flex justify-center">
            <div id="message-box" class="rounded-full shadow-lg px-2 text-sm py-2 message-box"></div>
        </div>
        
        <div class="flex justify-center">
            <p class="text-sm font-bold rounded-full shadow-lg px-2 text-sm py-2">R {{ $socialPost->fee }}</p>
        </div>

        @endif

        <div class="mt-4">
        @if (!empty($socialPost->note))
            <div class="flex flex-col leading-1.5 p-2 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                <p class="text-sm font-normal text-gray-900 dark:text-white"> {{ $socialPost->note }}</p>
            </div>
        @endif

            <p class="text-lg font-medium my-2">{{ $socialPost->place_name }}</p>
            <p class="text-gray-700 my-2">{{ $socialPost->description }}</p>
            <p class="text-xs text-gray-500">Posted by {{ $socialPost->author }} {{ $socialPost->formatted_time }}</p>
        </div>

        <div class="flex justify-center p-2">
        @if (!empty($socialPost->video_link))
            <iframe class="video-stream html5-main-video border-4 border-gray-300 rounded-lg" 
                src="{{ $socialPost->video_link }}" 
                frameborder="0" 
                style="width: 100%; height: 500px;" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
        @else
            <!-- <p>No video available</p> -->
        @endif
    </div>

        <div class="flex justify-center my-2 items-center space-x-2">
            <p class="text-gray-700 rounded shadow-lg px-2 text-sm py-2">{{ $socialPost->floating_sectors_value }}</p>
        </div>

        {{-- Comments Section --}}
        
        <div class="mt-4">
            <div class="text-right my-4">
                    <a href="https://wa.me/?text={{ urlencode(route('social.view.post', ['id' => $socialPost->id])) }}" 
                        target="_blank" 
                        class="p-2 text-sm rounded-full shadow-lg">
                        <i class="fa-brands fa-whatsapp"></i> Share
                    </a>
                </div>
                @if ($influencer && $influencer->influencer && $socialPost->status == 'show')
                    <div class="p-2 bg-white border border-gray-200 rounded-lg shadow mb-6 dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex flex-col items-center pb-10">
                            
                            <img style="width: 150px; height: 150px; border-radius: 50%;" 
                                class="mx-auto object-cover shadow-md m-2"  
                                src="{{ optional($influencer)->profile_image_url ? Storage::url($influencer->profile_image_url) : asset('images/default-avatar.png') }}" 
                                alt="{{ $influencer->first_name }}'s image"/>

                            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                                {{ $influencer->first_name }} 
                            </h5>
                            <h5 class="text-gray-600 text-center dark:text-gray-400 mt-2 text-sm">
                                {{ $influencer->email }}
                            </h5>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $influencer->position ?? 'Influencer' }}
                            </span>
                            <p class="text-gray-600 text-center dark:text-gray-400 mt-2 text-sm">
                                {{ $influencer->google_location ?? 'No location available' }}
                            </p>

                            @php
                                $socialLinks = [
                                    'instagram' => ['url' => $influencer->instagram_handle, 'icon' => 'fa-instagram', 'name' => 'Instagram'],
                                    'linkedin' => ['url' => $influencer->linkedin_handle, 'icon' => 'fa-linkedin', 'name' => 'LinkedIn'],
                                    'tiktok' => ['url' => $influencer->tiktok_handle, 'icon' => 'fa-tiktok', 'name' => 'TikTok'],
                                    'youtube' => ['url' => $influencer->youtube_handle, 'icon' => 'fa-youtube', 'name' => 'YouTube'],
                                    'x' => ['url' => $influencer->x_handle, 'icon' => 'fa-x-twitter', 'name' => 'X'],
                                    'other' => ['url' => $influencer->other_handle, 'icon' => '', 'name' => 'Other']
                                ];
                            @endphp

                            <div class="flex flex-wrap justify-center mt-4 space-x-2">
                                @foreach ($socialLinks as $link)
                                    @if (!empty($link['url']))
                                        <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" 
                                            class="py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                            <i class="fa-brands {{ $link['icon'] }}"></i> {{ $link['name'] }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                            
                        </div>
                    </div>
                @endif

                <div>
                    @if(Auth::check())

                        {{-- Toggle post visibility if user is the author --}}
                        @if (auth()->user()->email === $socialPost->email)
                            @if ($socialPost->status === 'show')
                                <form action="{{ route('posts.hide', $socialPost->id) }}" method="POST">
                                    @csrf
                                    <button class=" rounded-full shadow-lg px-2 text-sm py-2"><i class="fa-regular fa-eye-slash"></i> Hide my post</button>
                                </form>
                            @else
                                <form action="{{ route('posts.show', $socialPost->id) }}" method="POST">
                                    @csrf
                                    <button class="rounded-full shadow-lg px-2 text-sm py-2"><i class="fa-regular fa-eye"></i> Show my post</button>
                                </form>
                            @endif

                            <form id="update-post-name" action="{{ route('social.save.post.name', $socialPost->id) }}" method="POST">
                                @csrf
                                <!-- Name -->
                                <div class="my-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Post Name</label>
                                    <input type="text" name="place_name" value="{{ old('place_name') }}" id="place_name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Name of your venture" />
                                    @error('name')
                                    <p class="text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                    <button class="text-right rounded-full text-right shadow-lg px-2 text-sm py-2"> Update</button>
                                </div>
                            </form>

                            <form id="update-post-description" action="{{ route('social.save.post.description', $socialPost->id) }}" method="POST">
                                <div class="my-4">
                                    @csrf
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <p class="my-3">Here you can update your post description how you make the experiance memorable. </p>
                                    <textarea name="description" id="description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Write your promotion."></textarea>
                                    @error('description')
                                    <p class="text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                    <button class="text-right rounded-full text-right shadow-lg px-2 text-sm py-2"> Update</button>
                                </div>
                            </form>

                            <form id="upload-post-note" action="{{ route('social.save.post.note', $socialPost->id) }}" method="POST">
                                @csrf
                                <!-- Name -->
                                <div class="my-4">
                                    <label for="Note" class="block text-sm font-medium text-gray-700 mb-2">Add a note (250)</label>
                                    <input type="text" maxlength="250" name="note" value="{{ old('note') }}" id="note" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="05 March 2025" />
                                    @error('note')
                                    <p class="text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                    <button class="text-right rounded-full text-right shadow-lg px-2 text-sm py-2"> Update</button>
                                </div>

                            </form>

                            <form id="upload-post-video-link" action="{{ route('social.save.post.link', $socialPost->id) }}" method="POST">
                                @csrf
                                <!-- Name -->
                                <div class="my-4">
                                    <label for="Video" class="block text-sm font-medium text-gray-700 mb-2">Link extranal video (Convert to Embeded (Youtube) link before upload)</label>
                                    <input type="text" maxlength="250" name="video-link" value="{{ old('video-link') }}" id="video-link" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Click Share on Youtube video for the embeded link" />
                                    @error('video-link')
                                    <p class="text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                    <button class="text-right rounded-full text-right shadow-lg px-2 text-sm py-2"> Upload link</button>
                                </div>

                            </form>
                        
                        @endif
                    @endif
                    </div>
                        <h3 class=" text-sm ">Comments:</h3>

                            {{-- Check if comments are not null and not empty --}}
                            @if ($socialPost->comments && count($socialPost->comments) > 0)
                                @foreach ($socialPost->comments as $comment)
                                <div>
                                    {{-- Extract the author from the email part before '@' --}}
                                    @php
                                        $emailParts = explode('@', $comment['author']);
                                        $author = $emailParts[0];  // Get the part before the '@'
                                    @endphp

                                    <p><strong>{{ $author }}</strong> {{ $comment['content'] }}</p>
                                    <p class="text-xs text-gray-500">
                                        Posted {{ \Carbon\Carbon::parse($comment['updated_at'])->diffForHumans() }}
                                    </p>
                        @if(Auth::check())

                                    @if (auth()->user()->email === $socialPost->email)
                                        <form class="text-right mt-4" action="{{ route('comments.clear', [$socialPost->id]) }}" method="POST">
                                            <input type="text" class="hidden" name="comment_id" value="{{ ($comment['id']) }}"/>
                                            @csrf
                                            <button type="submit" class="p-2 text-sm rounded-full shadow-lg">  <i class="fa-solid fa-xmark"></i> Clear </button>
                                        </form>
                                    @endif
                        @endif
                                </div>
                                @endforeach
                            @else
                                <p>Be the first to leave a comment.</p>
                            @endif

                            {{-- Comment form --}}
                            <span  class="text-sm my-2 text-red-500 font-bold">*Note only the author of this post can manage the comment section</span>

                            <form action="{{ route('comments.store', $socialPost->id) }}" method="POST" class="mt-4">
                                @csrf
                                <div class="mb-2">
                                    <textarea name="content" placeholder="Your comment" class="w-full p-2 border rounded" required></textarea>
                                </div>
                                @error('content')
                                <p class="text-red-600  mt-1">{{ $message }}</p>
                                @enderror
                                <button type="submit" class="p-2 text-sm rounded-full shadow-lg">  <i class="fa-regular fa-comment"></i> Post my comment</button>
                            </form>
                        </div> 
                    </div>
                </div>


                <script>
                    const phrases = [
                        "Buy Now!",
                        // "Shop Now!",
                        // "Get Yours!",
                        // "Grab It!",
                        // "Claim Yours!",
                        // "Limited Time Offer!",
                        // "Act Fast!",
                    ];

                    // Function to update the button text randomly
                    function updateButtonText() {
                        const randomPhrase = phrases[Math.floor(Math.random() * phrases.length)];
                        document.getElementById("dynamicButton").innerHTML = `<i class="fa-solid fa-fire-flame-curved"></i> ${randomPhrase}`;
                    }
                    
                    // Call the function to set a random phrase on load
                    window.onload = updateButtonText;
                </script>
                <script>
                    $(document).ready(function() {
                            // Get a reference to the message box element
                            const messageBox = $('#message-box');

                            // Function to display messages
                            function showMessage(message, type) {
                                messageBox.text(message);
                                messageBox.removeClass('success error').addClass(type);
                                messageBox.fadeIn(400).delay(2000).fadeOut(400); // Fade in, show for 2s, then fade out
                            }

                            // Attach a click event listener to the button with the ID 'add-to-cart'
                            $('#add-to-cart').on('click', function() {
                                // Get the 'value' attribute of the clicked button
                                const postId = $(this).val();

                                // Retrieve the CSRF token from the meta tag
                                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                                // Log the value to the console to verify it's captured correctly
                                console.log('Button clicked! Post ID:', postId);

                                // Perform an AJAX POST request
                                $.ajax({
                                    // The URL where you want to send the data.
                                    // Replace 'your-backend-endpoint.php' with the actual path to your server-side script.
                                    url: '{{ route('add_to_cart', ['id' => ':postId']) }}'.replace(':postId', postId),

                                    // The HTTP method to use (POST is common for sending data)
                                    method: 'POST',
                                    // The data to be sent to the server, now including the CSRF token.
                                    data: {
                                        postId: postId,
                                        _token: csrfToken // Include the CSRF token here
                                    },
                                    // Set dataType to 'json' if your backend is expected to return JSON.
                                    // If your backend returns plain text or HTML, adjust this accordingly or omit it.
                                    dataType: 'json',
                                    // Function to be called if the AJAX request is successful
                                    success: function(response) {
                                        console.log('AJAX request successful:', response);
                                        // You can handle the response from the server here.
                                        // For example, display a success message to the user.
                                        if (response.status === 'success') {
                                            showMessage('Item added to cart successfully!', 'success');
                                            // Optionally, update UI here, like disabling the button or changing its text
                                            setTimeout(function() {window.history.back();}, 5000);

                                        } else {
                                            showMessage('' + (response.message || 'Unknown error'), 'error');
                                        }
                                    },
                                    // Function to be called if the AJAX request fails (e.g., network error, server error)
                                    error: function(xhr, status, error) {
                                        console.error('AJAX request failed:', status, error);
                                        console.error('Response Text:', xhr.responseText);
                                        // Display an error message to the user
                                        showMessage('Error adding item to cart. Please try again.', 'error');
                                    }
                                });
                            });
                        });
                </script>
                @endsection
