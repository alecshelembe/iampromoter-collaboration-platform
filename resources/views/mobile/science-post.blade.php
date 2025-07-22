@extends('welcome')

@section('content')

@include('layouts.navbar')

<div class="max-w-4xl mx-auto bg-white rounded-lg">
    {{-- Post Container --}}
    <div class="p-2 bg-white">

        {{-- Display post description and email --}}
        <div class="mt-4">
            <div>
            {{-- Parse and display images --}}
            @php
                $images = json_decode($Post->image_url, true); // Decode JSON for a single post
            @endphp

            @if (is_array($images) && count($images) > 0)
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($images as $image)
                        <figure class="max-w-lg relative">
                            <img class="h-auto max-w-full rounded-lg cursor-pointer" 
                                 src="{{ asset($image) }}" 
                                 alt="Post image"
                                 onclick="toggleImageModal('{{ asset($image) }}')"
                                 loading="lazy">
                        </figure>
                    @endforeach
                </div>
            @else
                <!-- <p>No images found.</p> -->
            @endif
        </div>
            <p class="text-2xl font-bold my-2">{{ $Post->title }}</p>
            <p class="text-gray-700 my-2">{!! $Post->description !!}</p>
                <form action={{ route('returnSpeech') }} target="_blank" method="POST">
                    @csrf
                    <textarea name="text" rows="4" style="display: none;" placeholder="Enter text here">{{$Post->description}}</textarea>
                    <input type="text" name="audio_id" value="<?php echo(rand());?>" hidden>
                    <button class=" my-4 p-2 text-sm rounded-full shadow-lg" type="submit">Speech (develpment) <i class=" fa-solid fa-volume-high"></i></button>
                </form>
            <p class="text-xs text-gray-500">Posted by {{ $Post->author }}</p>
            <p class="text-xs text-gray-500">{{ $Post->formatted_time }}</p>
        </div>
          
        <div class="text-right">
            <a href="https://wa.me/?text={{ urlencode(route('science.view.post', ['id' => $Post->id])) }}" 
                target="_blank" 
                class="p-2 text-sm rounded-full shadow-lg">
                <i class="fa-brands fa-whatsapp"></i> Share
            </a>
        </div>
       
    </div>
    @if(Auth::check())
    {{-- Toggle post visibility if user is the author --}}
    @if (auth()->user()->email === $Post->email)

    @if ($Post->status === 'show')
        <form action="{{ route('science.posts.hide', $Post->id) }}" method="POST">
            @csrf
            <button class="rounded-full shadow-lg px-2 text-sm py-2 my-2">
                <i class="fa-regular fa-eye-slash"></i> Hide my post
            </button>
        </form>
        @else
        <form action="{{ route('science.posts.show', $Post->id) }}" method="POST">
            @csrf
            <button class="rounded-full shadow-lg px-2 text-sm py-2 my-2">
                <i class="fa-regular fa-eye"></i> Show my post
            </button>
        </form>
    @endif
    
    <form action="{{ route('update.raw.post', $Post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Title -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
            <input type="text" name="title" value="{{$Post->title}}" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Enter the title" >
            @error('title')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>
    
        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Enter a description">{{$Post->description}}</textarea>
            @error('description')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    
    
        <script>
            document.addEventListener("DOMContentLoaded", function() {
            CKEDITOR.replace('description');
        });
        </script> 
    
        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit" class="bg-blue-500 p-4 text-white rounded-full shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                Update
            </button>
        </div>
    </form>
    
    @endif
    @endif
</div>
@endsection