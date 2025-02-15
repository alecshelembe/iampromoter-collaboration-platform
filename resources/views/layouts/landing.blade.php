@extends('welcome')

@section('content')
<script defer src="{{ asset('js/search.js') }}"></script>

<div class="max-w-3xl mx-auto">
    @if(Auth::check())
        <div class="text-center my-2">
            <p class="block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                <i class="fa-solid fa-check"></i> You're signed in
            </p>
        </div>
    @else
        <div class="text-center my-2">
            <a href="{{ route('login') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                <i class="fa-solid fa-door-open"></i> Sign In
            </a>
        </div>
    @endif

    <div class='flex justify-center text-center'>
      <div class='max-w-3xl mx-auto p-3 bg-white'>
          <h2 class='text-xl font-bold mb-2 text-gray-800'>What is Streetking?</h2>
          <p class='text-gray-600'>
              Streetking is the unofficial name for the new innovative platform connecting influencers and businesses for dynamic campaigns. It empowers influencers to grow their reach while helping businesses amplify their message through impactful collaborations.
          </p>
      </div>
    </div>
    <form id="searchForm">
          <label for="default-search" class="text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="searchQuery" class="block w-full my-2 p-2 ps-10 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" Where to? name of place" required />
                <!-- <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button> -->
            </div>
        </form>
        <div id="searchResults"></div>
    </div>

@endsection
