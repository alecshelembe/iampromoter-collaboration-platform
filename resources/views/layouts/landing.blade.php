@extends('welcome')

@section('content')
<script defer src="{{ asset('js/search.js') }}"></script>

<div class="">
    @if(Auth::check())
        <div class="text-center my-2">
            <a href="{{ route('home') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 dark:text-white">
                <i class="fa-solid fa-check"></i> You're signed in
            </a>
        </div>
    @else
        <div class="text-center my-2">
            <a href="{{ route('login') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 dark:text-white">
                <i class="fa-solid fa-door-open"></i> Sign In
            </a>
        </div>
    @endif

    <div class='flex justify-center text-center'>
        <div class='max-w-3xl mx-auto p-3 bg-white'>
            <h2 class='text-xl font-bold mb-2 text-gray-800'>What is Visitmyjoburg?</h2>
            <h1 class='text-gray-600'>
            Meet awesome business owners, creative promoters, and inspiring influencers while discovering hidden gems across the country. Whether you're traveling for fun or making connections, it's all about great people and unforgettable experiences!                <a href="mailto:refunds@visitmyjoburg.co.za" class="text-grey-600"> <i class="fa-solid fa-envelope"></i> promotions@visitmyjoburg.co.za</a>
            </h1>
            <div class="text-center my-4">
                <a href="{{ route('business_questionnaire') }}" class="bg-blue-500 text-white btn-sm py-2 px-2 rounded-full hover:bg-blue-600">
                    <!-- Plus icon -->
                    Promo my campaign
                </a>
            </div>
            <form id="searchForm">
                <label for="searchQuery" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="searchQuery" class="block w-full my-2 p-2 ps-10 text-gray-900 border rounded-lg" placeholder="Where to? name of place" required />
                </div>
            </form>
        </div>
    </div>

    <div id="searchResults"></div>

    @if ($socialPosts->isEmpty())
        <div class="p-4 text-center">
            <h5>No posts available.</h5>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($socialPosts as $post)
                @php
                    $images = json_decode($post->images, true);
                @endphp
                <div class="p-4 bg-white shadow-md rounded-lg">

                    {{--@if (is_array($images) && count($images) > 0)
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($images as $image)
                                <figure class="relative">
                                    <img class="h-auto max-w-full rounded-lg" src="{{ asset($image) }}" alt="Post image" loading="lazy">
                                </figure>
                            @endforeach
                        </div>
                    @endif --}}
                    <div class="mt-4 flex items-center space-x-3">
                        <img src="{{ $post->profile_image_url ? Storage::url($post->profile_image_url) : asset('default-profile.png') }}" 
                             alt="Profile Image" class="object-cover shadow-md"                                 style="width: 50px; height: 50px; border-radius: 50%;"/>
                        <div class="flex-1">
                            <p class="text-sm font-semibold">{{ $post->place_name }}</p>
                            <p class="text-sm text-gray-700">{{ $post->address }}</p>
                            <p class="text-xs text-gray-400">Posted by {{ $post->author }}</p>
                            <p class="text-xs text-gray-400">{{ $post->formatted_time }}</p>
                        </div>
                        <div>
                            @if(Auth::check())
                            <a href="{{ route('social.view.post', ['id' => $post->id]) }}" class="p-2 text-sm bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600">
                                Open
                            </a>
                            @else
                            <a href="{{ route('social.view.post', ['id' => $post->id]) }}" class="p-2 text-sm bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600">
                                login
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
