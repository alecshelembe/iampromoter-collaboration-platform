<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialPost;
use App\Models\Post;
use Carbon\Carbon;
use App\Models\User;

class GoogleController extends Controller
{
     // Apply the auth middleware to all methods in this controller
     public function __construct()
     {
         // Only allow Google authentication for the 'googleviewboth' method
         $this->middleware(function ($request, $next) {
             // Check if the user is accessing the 'googleviewboth' route and is not authenticated with Google
             if ($request->routeIs('googleviewboth') && !Auth::guard('google_users')->check()) {
                 return redirect()->route('google.login'); // Redirect to Google login if not authenticated with Google
             }
     
             return $next($request); // Proceed with the request if authenticated via Google
         })->only(['googleviewboth','googleviewSocialPost']);
     }

     public function googleviewSocialPost($id)
    {
        // Fetch the social post by ID with status 'show'
        $socialPost = SocialPost::where('id', $id)
            ->firstOrFail();

        // Convert the timestamp to a readable format
        $socialPost->formatted_time = Carbon::parse($socialPost->created_at)->diffForHumans();

        // Format the email to extract the author
        $emailParts = explode('@', $socialPost->email); // Assuming you have an 'email' column
        $socialPost->author = $emailParts[0]; // Get the part before the '@'
        $socialPost->email = $socialPost->email;

        // Get the comments (assuming 'comments' is a JSON field in the 'social_posts' table)
        $comments = $socialPost->comments ?? []; // If there are no comments, use an empty array

       // Fetch the user where the 'email' matches the social post email and 'influencer' is true
        $influencer = User::where('email', $socialPost->email)
        ->where('influencer', true)
        ->first();

        // Check if the influencer exists
        if (!$influencer) {
            $influencer = false;
        // Handle the case where there is no influencer
         // Pass the post, comments, and influencer data to the view
         return view('mobile.social-post', compact('socialPost', 'comments', 'influencer'));

        }

        // Pass the post, comments, and influencer data to the view
        return view('mobile.social-post', compact('socialPost', 'comments', 'influencer'));

    }
     
     
    public function googleviewboth()
    {
        // Fetch social posts
        $socialPosts = SocialPost::where('status', 'show')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        foreach ($socialPosts as $post) {
            $post->formatted_time = Carbon::parse($post->created_at)->diffForHumans();
            $emailParts = explode('@', $post->email); // Extract username from email
            $post->author = $emailParts[0];

            // Fetch the user by email and get profile_image_url
            $user = User::where('email', $post->email)->first();
            $post->profile_image_url = $user->profile_image_url ?? asset('default-profile.png');
        }

        // Fetch normal posts
        $posts = Post::where('status', 'show')
            ->limit(10)
            ->get();

        foreach ($posts as $post) {
            $post->formatted_time = Carbon::parse($post->created_at)->diffForHumans();
            $emailParts = explode('@', $post->email); // Extract username from email
            $post->author = $emailParts[0];
        }

        return view('layouts.viewboth', [
            'posts' => $posts,
            'socialPosts' => $socialPosts
        ]);
    }
}
