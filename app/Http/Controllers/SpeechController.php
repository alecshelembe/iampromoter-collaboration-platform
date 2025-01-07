<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class SpeechController extends Controller

{
    // Apply the auth middleware to all methods in this controller
    public function __construct()
    {
        $this->middleware('auth');
        // to specific methods 
        // $this->middleware('auth')->only(['create', 'store']);
    }
    
    public function generateSpeech(Request $request)
    {
        // Get the current date
        $today = Carbon::today();
        
        $text = $request->input('text'); // Get the text from the request
        $audio_id = $request->input('audio_id'); // Get the text from the request
        $outputFile = public_path('audio/' . $audio_id . '.wav'); // Absolute path to store the audio file

        // Ensure the directory exists
        if (!file_exists(public_path('audio'))) {
            mkdir(public_path('audio'), 0777, true);
        }
        
        // Use eSpeak to convert text to speech and save it as a WAV file
        // $command = 'espeak "' . escapeshellcmd($text) . '" --stdout > ' . escapeshellcmd($outputFile);
        //  new settings
        // $command = 'espeak -v en-us "' . escapeshellcmd($text) . '" --stdout > ' . escapeshellcmd($outputFile);
        $command = 'espeak -s 140 -p 50 -v en-us "' . escapeshellcmd($text) . '" --stdout > ' . escapeshellcmd($outputFile);

        exec($command);
        
        // Create the relative URL for the audio file
        $audioUrl = asset('audio/' . $audio_id . '.wav'); // Relative path for asset helper
        
        return view('layouts.showAudio', ['audioUrl' => $audioUrl]);
        
    }

    public function showForm(){
        return view('layouts.textToSpeech');

    }
    
}
