@extends('welcome')

@section('content')

@include('layouts.navbar')

<div class=" max-w-3xl mx-auto p-6 bg-white rounded-lg"> 
    <h1 class="text-2xl font-bold mb-4">Influencers</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">

    @if ($influencers->isEmpty())
        <p class="text-gray-600">No influencers found.</p>
    @else
        @foreach ($influencers as $influencer)
        <div class="p-2 bg-white border border-gray-200 rounded-lg shadow mb-6 dark:bg-gray-800 dark:border-gray-700">
            <!-- <div class="flex justify-end px-4 pt-4">
                <button id="dropdownButton{{ $loop->index }}" data-dropdown-toggle="dropdown{{ $loop->index }}" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                    <span class="sr-only">Open dropdown</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                        <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                    </svg>
                </button> -->
                <!-- Dropdown menu -->
                <!-- <div id="dropdown{{ $loop->index }}" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2" aria-labelledby="dropdownButton{{ $loop->index }}">
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Export Data</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                        </li>
                    </ul>
                </div>
            </div> -->
            <div class="flex flex-col items-center pb-10">
            
                <img class="w-24 h-24 mb-3 rounded-full shadow-lg"src="{{ Storage::url($influencer->profile_image_url) }}" alt="{{ $influencer->first_name }}'s image"/>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $influencer->first_name }} {{ $influencer->last_name }}</h5>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $influencer->position ?? 'Influencer' }}</span>
                <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm">
                    {{ $influencer->google_location ?? 'No location available' }}
                </p>
                <div class="flex mt-4 md:mt-6">

                    <a href="{{ $influencer->instagram_handle ?? 'None' }}" target="_blank" class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"><i class="fa-brands fa-instagram"></i> Instagram</a>
                    <a href="{{ $influencer->linkedin_handle ?? 'None' }}" target="_blank" class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"><i class="fa-brands fa-linkedin"></i> LinkedIn</a>
                </div>
                <div class="flex mt-4 md:mt-6">
                    <a href="{{ $influencer->tiktok_handle ?? 'None' }}" target="_blank" class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"><i class="fa-brands fa-tiktok"></i> Tiktok</a>
                    <a href="{{ $influencer->Youtube ?? 'None' }}" target="_blank" class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"><i class="fa-brands fa-youtube"></i> Youtube</a>
                </div>
                <div class="flex mt-4 md:mt-6">
                    <a href="{{ $influencer->x_handle ?? 'None' }}" target="_blank" class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"><i class="fa-brands fa-x-twitter"></i> x</a>
                    <a href="{{ $influencer->other_handle ?? 'None' }}" target="_blank" class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">other</a>
                </div>
            </div>
        </div>
        @endforeach
    @endif
    </div>
</div>

@endsection
