<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SocialPost;
use App\Models\Post;
use App\Models\UserLocation;
use App\Models\MobileAppBooking;
use Illuminate\Http\JsonResponse; //import JsonResponse
use Illuminate\Support\Facades\Log; //import Log
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\NotificationPreference;


// use Illuminate\Support\Facades\Mail;
// use App\Mail\SignUpMail; // Correctly import the SignUpMail class


class ApiController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = SocialPost::where('place_name', 'LIKE', '%' . $query . '%') // Adjust 'name' to your column
            ->where('status', 'show') // Only fetch posts with status 'show'
            ->orderBy('created_at', 'desc')
            ->take(5) // Limit the results to 3
            ->get()
            ->unique('place_name'); // Filter duplicates using collection method
            
            // log::info('Search results:', [
            //     'query' => $query,
            //     'results' => $results,
            // ]);
        return response()->json($results);
    }
    
    public function storeNotificationsP(Request $request)
    {
        $request->validate([
            'deviceId' => 'required|string',
            'expoPushToken' => 'required|string',
            'notificationPreferences' => 'required|array',
        ]);

        $preference = NotificationPreference::updateOrCreate(
            ['device_id' => $request->deviceId],
            [
                'expo_push_token' => $request->expoPushToken,
                'preferences' => $request->notificationPreferences,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Preferences saved successfully.',
        ]);
    }

    public function store(Request $request)
    {
                    function getNearestAddress($lat, $lng, $addresses)
            {
                $nearestAddress = null;
                $shortestDistance = PHP_FLOAT_MAX;

                foreach ($addresses as $address) {
                    if (!$address->lat || !$address->lng) continue;

                    $distance = haversineGreatCircleDistance($lat, $lng, $address->lat, $address->lng);

                    if ($distance < $shortestDistance) {
                        $shortestDistance = $distance;
                        $nearestAddress = $address;
                    }
                }

                return $nearestAddress;
            }

            function haversineGreatCircleDistance($lat1, $lon1, $lat2, $lon2, $earthRadius = 6371)
            {
                $latFrom = deg2rad($lat1);
                $lonFrom = deg2rad($lon1);
                $latTo = deg2rad($lat2);
                $lonTo = deg2rad($lon2);

                $latDelta = $latTo - $latFrom;
                $lonDelta = $lonTo - $lonFrom;

                $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

                return $earthRadius * $angle;
            }

        try {
            // Validate the incoming request
            $validated = $request->validate([
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'timestamp' => 'nullable|date',
                'device_id' => 'nullable|string|max:255',
                'device_name' => 'nullable|string|max:255',
                'platform' => 'nullable|string|max:255',
                'app_version' => 'nullable|string|max:50',
                'expo_push_token' => 'nullable|string|max:255',
            ]);

            // \Log::info('Request Data:', $request->all());


            // Store the location data
            $location = UserLocation::create([
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'location_recorded_at' => $validated['timestamp'] ?? now(),
                'device_id' => $validated['device_id'] ?? null,
                'device_name' => $validated['device_name'] ?? null,
                'platform' => $validated['platform'] ?? null,
                'app_version' => $validated['app_version'] ?? null,
                'expo_push_token' => $validated['expo_push_token'] ?? null,
                'last_active_at' => now(),
            ]);

            $latitude = $validated['latitude'] ?? null;
            $longitude = $validated['longitude'] ?? null;

            $addresses = SocialPost::where('status', 'show')
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->select('address', 'lat', 'lng')
                ->get();

            $nearest = getNearestAddress($latitude, $longitude, $addresses);

            // Log the success message
            // Log::info('Location data saved: ' . auth()->id());

            unset($nearest['lat'], $nearest['lng']);

            $post = SocialPost::where('status', 'show')
                ->where('address', 'like', $nearest['address'])
                ->orderBy('created_at', 'desc')
                ->first();

            
            Log::info('Location data saved successfully for user: ', [
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'device_id' => $validated['device_id'],
                'device_name' => $validated['device_name'],
                'platform' => $validated['platform'],
                'app_version' => $validated['app_version'],
                'expo_push_token' => $validated['expo_push_token'],
            ]);

            return response()->json([
                'near_address' => $post
            ], 201);


        } catch (\Exception $e) {
            // Log the error
            Log::error('Error storing location data: ' . $e->getMessage(), [
                'user_id' => auth()->id(), // Include user ID for context
                'error' => $e->getTraceAsString() // Log the full stack trace
            ]);

            // Return a user-friendly error message
            return response()->json([
                'message' => 'Failed to save location data. Please try again later.',
            ], 500);
        }
    }

    public function getData(Request $request): JsonResponse
    {
         $data = [
            'message' => 'API response successful!',
            'data' => [
                'name' => 'hello world',
                'value' => 123,
            ],
        ];

        return response()->json($data);
    }

    public function main_notification(){
        return response()->json([
            'status' => 'main-notification',
            'data' => [
                'title' => 'What is the call about?',
                'message' => "Our Staff will reserve your booking and provide you with all relevent information. We will ensure your visit is memorable." 
            ]
        ]);
    }

    public function mobileAppbookings(Request $request): JsonResponse
    {
        try {
            \Log::info('Request Data:', $request->all());
    
            $emailExists = User::where('email', $request->email)->exists();
    
            if (!$emailExists) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Please create your account first.',
                    'message' => 'Email does not exist.',
                    'help' => 'Send an email to alec@visitmyjoburg.co.za',
                ], 500);
            }
    
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'notes' => 'sometimes|max:255',
                'datetime' => 'required|date',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            $validated = $validator->validated();
    
            $booking = MobileAppBooking::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'notes' => $validated['notes'] ?? null,
                'datetime' => Carbon::parse($validated['datetime']),
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Booking successful!',
                'booking' => [
                    'name' => $booking->name,
                    'email' => $booking->email,
                    'notes' => $booking->notes,
                    'Date and Time' => $booking->datetime->format('l, j F Y \a\t g:i A'),
                ],
            ], 200);
    
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage(), [
                'error' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'message' => 'Failed, try again later.',
            ], 500);
        }
    }
    
    public function mobileAppCreateAccount(Request $request): JsonResponse
    {
        try {
            \Log::info('Request Data:', $request->all());
            
            $validator = Validator::make($request->all(), [
                'floating_email' => 'required|email|unique:users,email',
                'floating_first_name' => 'required|string|max:255',
                'floating_last_name' => 'required|string|max:255',
                'floating_phone' => 'required|digits:10',
                'password' => 'required|string|min:8|confirmed',
                'ref' => 'nullable|email|max:255', // Optional ref field
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096', // ✅ image validation

            ]);
            
            // Handle image upload if provided
            $imagePath = 'images/default-profile.png'; // Default image path
            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images', $imageName);
                $imagePath = 'images/' . $imageName;
            }
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $validated = $validator->validated();
            
            $user = User::create([
                'email' => $validated['floating_email'],
                'password' => Hash::make($validated['password']),
                'google_location' => $validated['google_location'] ?? '',
                'phone' => $validated['floating_phone'],
                'last_name' => $validated['floating_last_name'],
                'first_name' => $validated['floating_first_name'],
                'position' => $validated['position'] ?? 'mobile-app-user',
                'ref' => $validated['ref'] ?? null,
                'profile_image_url' => $imagePath, // ✅ Use uploaded path
            ]);
            

            // remove the password from the response
            unset($validated['password']);

            return response()->json([
                'email' => $validated,
                'message' => 'Data saved successfully!',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage(), [
                'error' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Failed try again later.',
            ], 500);
        }
    }


    public function getusers()
    {
        try {
            // Fetch all users ordered by creation date (latest first)
            $users = User::orderBy('created_at', 'desc')->get();

            // Return the user data as JSON
            return response()->json([
                'status' => 'success',
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getSciencePosts()
    {
        try {
           // Fetch data from the 'posts' table
            $posts = Post::where('status', 'show')
            ->orderBy('created_at', 'desc')
            ->get();
        
            // Return the user data as JSON
            return response()->json([
                'status' => 'success',
                'data' => $posts
            ]);
        
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
        
    }

    public function getSocialPosts()
    {
        try {
            // Fetch all social posts with status 'show'
            $socialPosts = SocialPost::where('status', 'show')
                ->orderBy('created_at', 'desc')
                ->get();
        
            // Collect all emails from the posts
            $emails = $socialPosts->pluck('email')->unique();
        
            // Get users by those emails
            $users = User::whereIn('email', $emails)->get()->keyBy('email');
        
            // Attach profile images to posts
            foreach ($socialPosts as $post) {
                $user = $users[$post->email] ?? null;
                $post->profile_image_url = $user->profile_image_url ?? asset('default-profile.png');
                $post->first_name = $user->first_name ?? 'Anonymous'; // Fallback if no user found
                
                $rawPhone = $user->phone ?? null;
                if ($rawPhone && preg_match('/^0\d{9}$/', $rawPhone)) {
                    $post->phone = substr($rawPhone, 0, 3) . ' ' . substr($rawPhone, 3, 3) . ' ' . substr($rawPhone, 6);
                } else {
                    $post->phone = 'Anonymous';
                }            
            }
            
            // Return the user data as JSON
            return response()->json([
                'status' => 'success',
                'data' => $socialPosts
            ]);
        
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
        
    }
}

// curl -X GET https://visitmyjoburg.co.za/api/users
// curl -X GET https://visitmyjoburg.co.za/api/get-social-posts
