<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;


class EventController extends Controller

{
    // Apply the auth middleware to all methods in this controller
    public function __construct()
    {
        $this->middleware('auth');
        // to specific methods 
        // $this->middleware('auth')->only(['create', 'store']);
    }

    public function create()
    {
        return view('layouts.events.create');
    }

        public function store(Request $request)
    {
        // Validate input fields
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'activity' => 'required|in:rockclimbing,hiking,ziplining,bouldering', // Added validation for activity field
            'status' => 'required|in:pending,upcoming,completed,cancelled', // Add the correct validation for status
            'audience' => 'required|in:internal,public', // Validate audience

        ]);

        // Map each activity to its corresponding image URL
       // Assuming you have an array that maps activities to their relative image paths
        $activityImages = [
            'rockclimbing' => 'storage/sci-bono-content/rockclimbing.jpg',
            'hiking' => 'storage/sci-bono-content/hiking.jpg',
            'ziplining' => 'storage/sci-bono-content/ziplining.jpg',
            'bouldering' => 'storage/sci-bono-content/bouldering.jpg',
        ];

        // Attach the correct relative image URL to the validated data
        $validatedData['image_url'] = $activityImages[$validatedData['activity']];

        // Create and store the new event
        $event = Event::create($validatedData);

        // Pass the image and event data to the view
        return redirect()->route('events.show', $event->id)
            ->with('success', 'Event created successfully!')
            ->with('image_url', $validatedData['image_url']);
    }

    public function show($id)
    {
        // Fetch the event by its ID, or fail with a 404 error if not found
        $event = Event::findOrFail($id);

        // Format the start and end dates
        $event->start_date = Carbon::parse($event->start_date)->format('F j, Y h:i A'); // Example: October 3, 2024
        $event->end_date = Carbon::parse($event->end_date)->format('F j, Y h:i A');

        // Return the view with the fetched event
        return view('layouts.events.show', compact('event'));
    }

    public function showAll()
    {
        // Fetch all events from the database and format the dates
        $events = Event::all()->map(function ($event) {
            $event->start_date = Carbon::parse($event->start_date)->format('F j, Y h:i A'); // Example: October 3, 2024
            $event->end_date = Carbon::parse($event->end_date)->format('F j, Y h:i A');
            return $event;
        });

        // Return the view with the fetched events
        return view('layouts.events.showAll', compact('events'));
    }

}
