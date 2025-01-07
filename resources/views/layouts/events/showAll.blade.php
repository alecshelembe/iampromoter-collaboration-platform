@extends('welcome')

@section('content')
@include('layouts.navbar')

    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-6">All Events</h1>

        @if ($events->isEmpty())
            <p class="text-gray-500">No events found.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($events as $event)
                    <div>
                        <a href="#" class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <img class="object-contain w-full h-auto max-h-96 rounded-lg" src="{{ asset($event->image_url) }}" alt="{{ $event->activity }}">
                            <div class="p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $event->title }}</h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> <strong>Description</strong> {{ $event->description }}</p>
                                <p class="text-gray-700 mt-2">
                                    <strong>Start Date</strong> {{ $event->start_date }} <br>
                                    <strong>End Date</strong> {{ $event->end_date }} <br>
                                    <strong>Activity</strong> {{ ucfirst($event->activity) }} <br>
                                    <strong>Status</strong> {{ ucfirst($event->status) }} <br>
                                    <strong>Audience</strong> {{ ucfirst($event->audience) }}
                                </p>     
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
