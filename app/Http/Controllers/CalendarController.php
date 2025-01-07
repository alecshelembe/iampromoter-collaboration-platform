<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;



class CalendarController extends Controller
{
     // Apply the auth middleware to all methods in this controller
     public function __construct()
     {
         $this->middleware('auth');
         // to specific methods 
         // $this->middleware('auth')->only(['create', 'store']);
     }
     
    public function handleOAuthCallback()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/oauth-credentials.json'));
        $client->setRedirectUri('https://register.finetrades.co.za/oauth2callback');
        $client->addScope(\Google_Service_Calendar::CALENDAR);
        
        if (!request()->has('code')) {
            $authUrl = $client->createAuthUrl();
            return redirect($authUrl);
        }

        $client->authenticate(request('code'));
        $token = $client->getAccessToken();

        // Save token to file
        file_put_contents(storage_path('app/google-calendar/oauth-token.json'), json_encode($token));

        return redirect()->route('calendar.index', ['text' => $token]);

    }

    // Show events
    

    public function index() {
        try {
            // Fetch events for the next 7 days
            $events = Event::get(Carbon::now(), Carbon::now()->addDays(30));
    
            // Format and return the events to the view
            $formattedEvents = $events->map(function ($event) {
                return [
                    'title' => $event->name, // The title of the event (summary)
                    'start_date' => $event->startDate->format('Y-m-d'), // Start date
                    'end_date' => $event->endDate->format('Y-m-d'), // End date
                    'link' => $event->googleEvent->htmlLink, // Link to the Google Calendar event
                    'description' => $event->googleEvent->description, // Description (if available)
                    'status' => $event->googleEvent->status, // Status (e.g., confirmed)
                ];
            });
    
            // Pass the formatted events to the view
            return view('layouts.rockClimbingAllBookings', compact('formattedEvents'));
            
        } catch (\Exception $e) {
            // Log the exception and return a JSON error response
            Log::error('Error fetching events: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch events',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // Store a new booking session
    public function store(Request $request) {
        $event = new Event;

        $event->name = $request->input('title');
        $event->startDateTime = Carbon::parse($request->input('start'));
        $event->endDateTime = Carbon::parse($request->input('end'));
        $event->save();

        return redirect()->back()->with('message', 'Event created successfully!');
    }
}
