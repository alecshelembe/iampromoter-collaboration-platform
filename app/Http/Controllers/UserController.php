<?php

namespace App\Http\Controllers;

use App\Mail\SignUpMail; // Correctly import the SignUpMail class
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    // Apply the auth middleware to all methods in this controller
    public function __construct()
    {
        // $this->middleware('auth');
        // to specific methods 
        // $this->middleware('auth')->only(['create', 'store']);
        $this->middleware('auth')->except(['create', 'store','viewPublicprofile']);

    }

    protected function sendEmail(array $validatedData)
    {
        $data = ['name' => $validatedData['floating_first_name']];
        
        Mail::to($validatedData['floating_email'])->queue(new SignUpMail($data));
        // Mail::to($validatedData['floating_email'])->send(new SignUpMail($data));
    }

    // Show the form to create a new user
    public function create(Request $request)
    {
        // Check for 'email' query parameter and decode it
        if ($request->has('email')) {
            $encodedEmail = $request->query('email');
            $decoded_email = base64_decode($encodedEmail, true); // Decode and check for validity

            if ($decoded_email === false) {
                return response()->json(['error' => 'Invalid email encoding'], 400);
            }
      
            // Validate the decoded email if necessary
            if ($decoded_email) {
                $request->validate(['ref' => 'email|max:255']);
            }
            // Get the part of the email before the '@'
            $emailParts = explode('@', $decoded_email); // Assuming you have an 'email' column
            $refPart = $emailParts[0]; // Get the part before the '@'
            $refPart = preg_replace('/[^a-zA-Z]/', '', $emailParts[0]); // Allow only letters

            
            return view('create', [
                'decoded_email' => $refPart, // Pass the decoded email
                'fullemail' => $decoded_email, // Pass the decoded email
            ]);
        } else {
            return view('create', [
                'decoded_email' => '', // Pass the decoded email
            ]);
        }

    }

    public function createRef(){

        // $email = auth()->user()->email;
        $email = base64_encode(auth()->user()->email);
        // Redirect with email as a query parameter
        return redirect()->route('users.create', ['email' => $email]);
    }

    public function profileStore(Request $request){
        
        // Validate the request data
        $validatedData = $request->validate([
            'floating_email' => 'nullable|email|unique:users,email',
            'google_location' => 'nullable|string|max:255',
            'floating_address' => 'nullable|string|max:255',
            'google_latitude' => 'nullable|string|max:255',
            'google_longitude' => 'nullable|string|max:255',
            'google_location_type' => 'nullable|string|max:255',
            'google_postal_code' => 'nullable|string|max:255',
            'google_city' => 'nullable|string|max:255',
            'package_selected' => 'nullable|string|max:255',
            'web_source' => 'nullable|string|max:255',
            'location_id' => 'nullable|string|max:255',
            'floating_first_name' => 'required|string|max:255',
            'floating_last_name' => 'required|string|max:255',
            'floating_phone' => 'required|digits:10',
            'influencer' => 'sometimes|boolean',
            'instagram_handle' => 'nullable|string|max:255',
            'tiktok_handle' => 'nullable|string|max:255',
            'linkedin_handle' => 'nullable|string|max:255',
            'x_handle' => 'nullable|string|max:255',
            'youtube_handle' => 'nullable|string|max:255',
            'other_handle' => 'nullable|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,webp,gif|max:10240',

        ]);

        $user = auth()->user();
        $profile_image_url = auth()->user()->profile_image_url;

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_'.auth()->user()->email.'.'.$image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $imagePath = 'images/' . $imageName;
        } else {
            $imagePath = $profile_image_url; // old image path
        }

        // Update the user with the validated data
        $user->update([
            'google_location' => $validatedData['google_location'] ?? '',
            'google_latitude' => $validatedData['google_latitude'] ?? '',
            'google_longitude' => $validatedData['google_longitude'] ?? '',
            'google_location_type' => $validatedData['google_location_type'] ?? '',
            'google_postal_code' => $validatedData['google_postal_code'] ?? '',
            'google_city' => $validatedData['google_city'] ?? '',
            'web_source' => $validatedData['web_source'] ?? '',
            'location_id' => $validatedData['location_id'] ?? '',
            'first_name' => $validatedData['floating_first_name'],
            'last_name' => $validatedData['floating_last_name'],
            'phone' => $validatedData['floating_phone'],
            'influencer' => $validatedData['influencer'],
            'instagram_handle' => $validatedData['instagram_handle'],
            'tiktok_handle' => $validatedData['tiktok_handle'],
            'linkedin_handle' => $validatedData['linkedin_handle'],
            'x_handle' => $validatedData['x_handle'],
            'youtube_handle' => $validatedData['youtube_handle'],
            'other_handle' => $validatedData['other_handle'],
            'profile_image_url' => $imagePath,
        ]);

        // Redirect with a success message and email
        return redirect()->route('home')->with([
            'success' => 'User updated successfully!',
        ]);

    }


    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'floating_email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'google_location' => 'nullable|string|max:255',
            'floating_address' => 'nullable|string|max:255',
            'google_latitude' => 'nullable|string|max:255',
            'google_longitude' => 'nullable|string|max:255',
            'google_location_type' => 'nullable|string|max:255',
            'google_postal_code' => 'nullable|string|max:255',
            'google_city' => 'nullable|string|max:255',
            'package_selected' => 'nullable|string|max:255',
            'web_source' => 'nullable|string|max:255',
            'location_id' => 'nullable|string|max:255',
            'floating_first_name' => 'required|string|max:255',
            'floating_last_name' => 'required|string|max:255',
            'floating_phone' => 'required|digits:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'position' => 'required|string|max:255',
            'ref' => 'sometimes|email|max:255', // Optional ref field

        ]);

        // Handle image upload if provided
        $imagePath = 'images/default-profile.png'; // Default image path
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $imagePath = 'images/' . $imageName;
        }

        // Create the user with the validated data
        $user = User::create([
            'email' => $validatedData['floating_email'],
            'password' => Hash::make($validatedData['password']),
            'google_location' => $validatedData['google_location'] ?? '',
            'google_latitude' => $validatedData['google_latitude'] ?? '',
            'google_longitude' => $validatedData['google_longitude'] ?? '',
            'google_location_type' => $validatedData['google_location_type'] ?? '',
            'google_postal_code' => $validatedData['google_postal_code'] ?? '',
            'google_city' => $validatedData['google_city'] ?? '',
            'package_selected' => $validatedData['package_selected'] ?? '',
            'web_source' => $validatedData['web_source'] ?? '',
            'location_id' => $validatedData['location_id'] ?? '',
            'first_name' => $validatedData['floating_first_name'],
            'last_name' => $validatedData['floating_last_name'],
            'phone' => $validatedData['floating_phone'],
            'profile_image_url' => $imagePath,
            'position' => $validatedData['position'],
            'ref' => $validatedData['ref'] ?? null, // Use the validated ref or null

        ]);

        // Call the sendEmail function with necessary data
       // $this->sendEmail($validatedData);

        // Redirect with a success message and email
        return redirect()->route('login')->with([
            'success' => 'User created successfully!',
            'email' => $user->email,
            'profile_image_url' => $user->profile_image_url
        ]);
    }

    public function profile(){

        // Check if the user has logged in today
        $user = user::where('email', auth()->user()->email)
        ->first();

        return view('profile', ['user' => $user]);
    }

    public function viewPublicProfile($email)
    {
        // Retrieve user by email
        $user = User::where('email', $email)->firstOrFail();

        return view('public-profile', ['user' => $user]);
    }


}
