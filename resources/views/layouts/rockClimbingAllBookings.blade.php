@extends('welcome')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-6">Upcoming Events</h1>

        @if ($formattedEvents->isEmpty())
            <p class="text-gray-500">No events found for the next 7 days.</p>
        @else
            <ul class="space-y-8">
                
                @foreach ($formattedEvents as $event)
                <div>
                    <a href="{{ $event['link'] }}"  class="bg-blue-500 p-4 text-white rounded-full shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75" target="_blank">
                        View in Google Calendar
                    </a>
                    <br>
                    <br>
                    <a href="#" class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <img class="object-contain w-full h-auto max-h-96 rounded-t-lg" 
                        src="{{ asset('storage/sci-bono-content/rockclimbing.jpg') }}" alt="">
                                    <div class="p-4 leading-normal">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $event['title'] }}</h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $event['description'] ?? 'No description available' }}</p>
                            <p class="text-gray-700 mt-2">
                                <strong>Start Date:</strong> {{ $event['start_date'] }} <br>
                                <strong>End Date:</strong> {{ $event['end_date'] }} <br>
                                <strong>Status:</strong> {{ ucfirst($event['status']) }}
                            </p>    
                        </div>
                    </a>
                </div>
                {{-- <hr class="my-4"> --}}
                @endforeach
            </ul>
        @endif
    </div>
@endsection
