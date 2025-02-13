<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;


class DirectorController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // to specific methods 
        // $this->middleware('auth')->except(['create', 'store']);
        $this->middleware('auth')->only(['generate', 'viewInfluencers']);
    }
    public function generate()
    {
        return view('layouts.openai.test');
    }
    
    public function landing()
    {
        return view('layouts.landing');
    }

    public function searchPlaces()
    {
        return view('layouts.search');
    }

    public function refunds()
    {
        return view('layouts.refund');
    }
    
    public function support()
    {
        return view('layouts.support');
    }

    public function termsandconditions()
    {
        return view('layouts.termsandconditions');
    }

    public function promotions()
    {
        return view('layouts.promotions');
    }

    public function viewInfluencers()
    {
        // Fetch users where the 'influencer' column is true
        $influencers = User::where('influencer', true)->get();

        // Pass the influencers to the view
        return view('layouts.influencers', ['influencers' => $influencers]);
            
    }
}

    // public function showImages()
    // {
    //     // Get all files in the specified directory
    //     $images = Storage::files('public/images/gallery'); // Adjust the path as needed
    //     $images = array_map(fn($path) => str_replace('public/', 'storage/', $path), $images);

    //     return view('layouts.events.guidedtour', compact('images'));
    // }
