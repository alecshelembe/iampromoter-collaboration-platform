@extends('welcome')

@section('content')

<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg mt-10">
<h1 class="text-3xl font-bold mb-6">Create an Event</h1>
    <form method="POST" action="{{ route('events.store') }}" class="space-y-6">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
            <input type="text" id="title"  value="{{ old('title') }}" name="title" required 
                class="block w-full mt-1 p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('title')
                <p class="text-red-600  mt-1">{{ $message }}</p>
                @enderror
            </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea id="description" name="description"  value="{{ old('description') }}" rows="3" required 
                    class="block w-full mt-1 p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                @error('description')
                <p class="text-red-600  mt-1">{{ $message }}</p>
                @enderror
        </div>

        <div class="mb-4">
            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date and Time</label>
            <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date') }}" required 
                class="block w-full mt-1 p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @error('start_date')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        

        <div class="mb-4">
            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
            <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date') }}" required 
                class="block w-full mt-1 p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('end_date')
                <p class="text-red-600  mt-1">{{ $message }}</p>
                @enderror
            </div>

        <div class="mb-4">
            <label for="activity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Activity</label>
            <select id="activity" value="{{ old('activity') }}" name="activity" 
                    class="block w-full mt-1 p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="rockclimbing">Rock Climbing</option>
                <option value="venue">Venue Hire</option>
                {{-- <option value="bouldering">Bouldering</option> --}}
            </select>
            @error('activity')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
            <select id="status" value="{{ old('status') }}" name="status" 
                    class="block w-full mt-1 p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
                <option value="upcomming">Upcomming</option>
            </select>
            @error('status')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="audience" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Audience</label>
            <select id="audience" value="{{ old('audience') }}" name="audience" 
                    class="block w-full mt-1 p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="internal">Internal</option>
                <option value="public">Public</option>
            </select>
            @error('audience')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" 
                class="w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
            Create Event
        </button>
        </form>
    </div>



@endsection