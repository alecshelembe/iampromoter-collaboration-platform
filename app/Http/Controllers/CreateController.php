<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Log;
use App\Models\SocialPost;
use App\Models\Post;
use Carbon\Carbon;


class CreateController extends Controller
{
    // Apply the auth middleware to all methods in this controller
    public function __construct()
    {
         $this->middleware('auth');
        // to specific methods 
        // $this->middleware('auth')->only(['create', 'store']);
         //$this->middleware('auth')->except(['viewSocialPost','viewSciencePost']);

    }

    public function showPostForm()
    {
        return view('ocr_result');
    }

    public function showMobilePostForm()
    {
        return view('mobile.create');
    }

    public function viewSocialPost($id)
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

        // Pass the post and comments to the view
        return view('mobile.social-post', compact('socialPost', 'comments'));
    }

    public function viewSciencePost($id)
    {
        // Fetch the social post by ID with status 'show'
        $Post = Post::where('id', $id)
            ->firstOrFail();

        // Convert the timestamp to a readable format
        $Post->formatted_time = Carbon::parse($Post->created_at)->diffForHumans();

        // Format the email to extract the author
        $Post->email = $Post->author; 
        $emailParts = explode('@', $Post->author); // Assuming you have an 'email' column
        $Post->author = $emailParts[0]; // Get the part before the '@'

        // Pass the post and comments to the view
        return view('mobile.science-post', compact('Post'));
    }

    
    public function viewSocialPosts()
    {
            // Fetch all social posts with status 'show'
            $socialPosts = SocialPost::where('status', 'show')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Convert the timestamps to a readable format
        foreach ($socialPosts as $post) {
            $post->formatted_time = Carbon::parse($post->created_at)->diffForHumans();
            $emailParts = explode('@', $post->email); // Assuming you have an 'email' column
            $post->author = $emailParts[0]; // Get the part before the '@'
            $post->email = $post->email;// Get the part before the '@'
        }
        

        // Pass posts to the view
        return view('mobile.home', compact('socialPosts'));
    }

    public function viewboth(){

    // Fetch all social posts with status 'show'
    $socialPosts = SocialPost::where('status', 'show')
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();

    // Convert the timestamps to a readable format
    foreach ($socialPosts as $post) {
        $post->formatted_time = Carbon::parse($post->created_at)->diffForHumans();
        $emailParts = explode('@', $post->email); // Assuming you have an 'email' column
        $post->author = $emailParts[0]; // Get the part before the '@'
        $post->email = $post->email;// Get the part before the '@'
    }

    // Fetch data from the 'posts' table
    $posts = Post::where('status', 'show')
    ->limit(10)
    ->get();

    foreach ($posts as $post) {
        $post->formatted_time = Carbon::parse($post->created_at)->diffForHumans();
        // Extract the author's name from the email
        $post->email = $post->author; // Get the part before the '@'
        $emailParts = explode('@', $post->author); // Assuming you have an 'email' column
        $post->author = $emailParts[0]; // Get the part before the '@'
    }

        return view('layouts.viewboth', [
            'posts' => $posts,
            'socialPosts' => $socialPosts
        ]);
        
    }

    public function sciencePosts()
    {
        // Fetch data from the 'posts' table
        $posts = Post::where('status', 'show')
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();

        foreach ($posts as $post) {
            $post->formatted_time = Carbon::parse($post->created_at)->diffForHumans();
            // Extract the author's name from the email
            $post->email = $post->author; // Get the part before the '@'
            $emailParts = explode('@', $post->author); // Assuming you have an 'email' column
            $post->author = $emailParts[0]; // Get the part before the '@'
        }
    
        // Pass the data to the view
        return view('layouts.science', ['posts' => $posts]);

    }

    public function scienceHide($id)
    {
        // Find the post by ID
        $post = Post::findOrFail($id);
        
        // Check if the logged-in user's author matches the post's email
        if (auth()->user()->email === $post->author) {
            // Update the status to 'hide' (or however you want to handle hiding)
            $post->status = 'hide';
            $post->save();
            
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Post hidden successfully.');
        }

        // Redirect back with an error message if the user doesn't match
        return redirect()->back()->with('error', 'You are not authorized to hide this post.');
    }

    public function hide($id)
    {
        // Find the post by ID
        $post = SocialPost::findOrFail($id);
        
        // Check if the logged-in user's email matches the post's email
        if (auth()->user()->email === $post->email) {
            // Update the status to 'hide' (or however you want to handle hiding)
            $post->status = 'hide';
            $post->save();
            
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Post hidden successfully.');
        }

        // Redirect back with an error message if the user doesn't match
        return redirect()->back()->with('error', 'You are not authorized to hide this post.');
    }

    public function show($id)
    {
        // Find the post by ID
        $post = SocialPost::findOrFail($id);
        
        // Check if the logged-in user's email matches the post's email
        if (auth()->user()->email === $post->email) {
            // Update the status to 'hide' (or however you want to handle hiding)
            $post->status = 'show';
            $post->save();
            
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Post is now public .');
        }

        // Redirect back with an error message if the user doesn't match
        return redirect()->back()->with('error', 'You are not authorized to show this post.');
    }


    public function saveSocialPost(Request $request)
    {
        // Validate inputs
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'required|string',
            'user_selected_place' => 'sometimes|string|max:255',
            'floating_address' => 'required|string|max:255',
            'place_name' => 'required|string|max:255',
            'extras' => 'nullable|array', // Ensure it's an array if present
            'extras.*' => 'string|max:255', // Validate each selected checkbox value
        ]);
        
        dd($validatedData);

        $imagePaths = [];
    
        // Handle each image
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file) {
                    $imageName = time() . '_'.rand().auth()->user()->email.'.'.$file->getClientOriginalExtension();
                    // Save the image in storage/app/public/images/social/
                    $file->storeAs('public/images/social/', $imageName);
                    // Update image path to be stored in the database
                    $imagePath = 'storage/images/social/' . $imageName; // Use 'storage' here for generating public-facing URL
                    $imagePaths[] = $imagePath;
                }
            }
        }
    
        // Save the description and image paths to the database

        $postData = [
            'place_id' => $validatedData['user_selected_place'] ?? null,
            'address' => $validatedData['floating_address'],
            'description' => $validatedData['description'],
            'email' => auth()->user()->email, // Add the logged-in user's email
        ];
        
        if (isset($imagePaths) && !empty($imagePaths)) {
            $postData['images'] = json_encode($imagePaths);
        }

        $post = SocialPost::create($postData);
    
        return redirect()->route('home')->with([
            'success' => 'Post Created Successfully'
        ]);
    }
    

    public function savePost(Request $request)
    {
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $imagePaths = [];

         // Handle each image
         if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file) {
                    $imageName = time() . '_'.rand().auth()->user()->email.'.'.$file->getClientOriginalExtension();
                    // Save the image in storage/app/public/images/social/
                    $file->storeAs('public/images/science/', $imageName);
                    // Update image path to be stored in the database
                    $imagePath = 'storage/images/science/' . $imageName; // Use 'storage' here for generating public-facing URL
                    $imagePaths[] = $imagePath;
                }
            }
        }
        
        $postData = [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'author' => auth()->user()->email, // Add the logged-in user's email
        ];
        
        if (isset($imagePaths) && !empty($imagePaths)) {
            $postData['image_url'] = json_encode($imagePaths);
        }
        
        // dd(json_encode($imagePaths)); // Check the actual size of the JSON data

        $post = Post::create($postData);
        
        return redirect()->route('home')->with([
            'success' => 'Post Created Successfully'
        ]);
        
    }

    public function create()
    {
        return view('layouts.create');
    }

        public function viewPublicUserPosts($email)
    {
        // Fetch all social posts for the specified user with status 'show'
        $socialPosts = SocialPost::where('email', $email)
            ->where('status', 'show') // Only fetch posts with status 'show'
            ->orderBy('created_at', 'desc')
            ->get();

        // Convert timestamps to readable format and extract author name
        foreach ($socialPosts as $post) {
            $post->formatted_time = Carbon::parse($post->created_at)->diffForHumans();
            $emailParts = explode('@', $post->email);
            $post->author = $emailParts[0]; // Get the part before the '@'
        }

        // Return a view that shows the public posts
        return view('mobile.home', compact('socialPosts'));
    }

    public function myposts(){

    // Fetch all social posts 
        $socialPosts = SocialPost::where('email', auth()->user()->email)
        ->orderBy('created_at', 'desc')
        ->get();

            // Convert the timestamps to a readable format
        foreach ($socialPosts as $post) {
            $post->formatted_time = Carbon::parse($post->created_at)->diffForHumans();
            $emailParts = explode('@', $post->email); // Assuming you have an 'email' column
            $post->author = $emailParts[0]; // Get the part before the '@'
            $post->email = $post->email;// Get the part before the '@'
        }
            
        return view('mobile.home', compact('socialPosts'));
    }
    
    public function clearComments(Request $request, $postId)
    {
        // Validate comment_id is present and an integer
        $request->validate(['comment_id' => 'required|integer']);

        // Find the post
        $post = SocialPost::findOrFail($postId);

        // Get the commentId from the request
        $commentId = (int) $request->comment_id;  // Cast commentId to integer to avoid type mismatch

        // Ensure that the post has comments, or initialize an empty array
        $comments = $post->comments ?? [];

        // Debug: Check if the commentId exists in the array
        // dd($comments, $commentId);  // This will dump the comments array and the commentId being passed

        // Filter out the comment with the matching id
        $comments = array_filter($comments, function ($comment) use ($commentId) {
            return (int) $comment['id'] !== $commentId;  // Cast to integer for comparison
        });

        // Reindex the array after filtering
        $comments = array_values($comments);

        // Debug: Check the filtered comments
        // dd($comments);  // This will display the list of comments after filtering

        // Save the updated comments back to the post
        $post->update(['comments' => $comments]);

        // Return success message
        return back()->with('success', 'Comment removed successfully!');

    }

    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);
        // echo"hello world";
        // exit();

        $post = SocialPost::findOrFail($postId);

        // Get existing comments or initialize an empty array
        $comments = $post->comments ?? [];

        // Add the new comment to the array
        $comments[] = [
            'id' => rand(),  // Automatically use the logged-in user's email
            'author' => auth()->user()->email,  // Automatically use the logged-in user's email
            'content' => $request->content,
            'created_at' => now(),
        ];

        // Save the updated comments to the post
        $post->update(['comments' => $comments]);

        return back()->with('success', 'Comment added successfully!');
    }

   
    public function processImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $imagePath = $request->file('image')->store('public/images/demo-images');

        // Run OCR
        try {
            $text = (new TesseractOCR(storage_path('app/' . $imagePath)))
                ->lang('eng')
                ->run();
            
                return redirect()->route('create.raw.post', ['text' => $text]);

        } catch (\Exception $e) {
            Log::error('OCR processing failed: ' . $e->getMessage());
            return redirect()->route('create.post')->with([
                'failed' => 'An error occurred while processing the image.!'
            ]);
        }
    }
}