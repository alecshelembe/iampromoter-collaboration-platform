@extends('welcome')

@section('content')

<div class="mx-auto">
<button type="button" class=" text-blue-700 hover:text-white border border-blue-600 bg-white hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:bg-gray-900 dark:focus:ring-blue-800">Image Gallery</button>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($images as $image)
            <div class="flex items-center justify-center">
                <img src="{{ $image }}" alt="Image" class="max-w-full h-auto rounded shadow">
            </div>
        @endforeach
    </div>
</div>

@endsection


