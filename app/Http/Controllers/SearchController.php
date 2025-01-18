<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialPost;

class SearchController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
        // to specific methods 
        // $this->middleware('auth')->only(['create', 'store']);
         //$this->middleware('auth')->except(['viewSocialPost','viewSciencePost']);

    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = SocialPost::where('address', 'LIKE', '%' . $query . '%') // Adjust 'name' to your column
            ->where('status', 'show') // Only fetch posts with status 'show'
            ->orderBy('created_at', 'desc')
            ->take(3) // Limit the results to 3
            ->get();
    
        return response()->json(['data' => $results]);
    }
    

    public function searchAddress(Request $request)
    {
        // Validate the incoming query
        $validated = $request->validate([
            'query' => 'required|string|min:3', // Ensure query is at least 3 characters long
        ]);

        // Get the validated query
        $query = $validated['query'];

        // Search the SocialPost model by address and get all matching results
        $results = SocialPost::where('address', 'LIKE', '%' . $query . '%')
            ->where('status', 'show') // Only fetch posts with status 'show'
            ->orderBy('created_at', 'desc')
            ->get();

        // Return the results to a view
        return view('mobile.social-results', ['results' => $results, 'query' => $query]);
    }
    
}
