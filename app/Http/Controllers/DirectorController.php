<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DirectorController extends Controller
{
    public function rockClimbing()
    {
        return view('layouts.events.rockclimbing');
    }

    public function generate()
    {
        return view('layouts.openai.test');
    }
    
    public function venueHire()
    {
        return view('layouts.events.venuehire');
    }

    public function landing()
    {
        return view('layouts.landing');
    }

    public function showImages()
    {
        // Get all files in the specified directory
        $images = Storage::files('public/images/gallery'); // Adjust the path as needed
        $images = array_map(fn($path) => str_replace('public/', 'storage/', $path), $images);

        return view('layouts.events.guidedtour', compact('images'));
    }

}
