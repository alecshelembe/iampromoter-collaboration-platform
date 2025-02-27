<?php 

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\DailyRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use AuthenticatesUsers;


class LoginController extends Controller
{
    public function __construct()
    {
        // to specific methods 
        $this->middleware('auth')->only(['home']);
        // to specific methods 
        // $this->middleware('auth')->only(['create', 'store']);
        //$this->middleware('auth')->except(['viewSocialPost','viewSciencePost']);
    }

    
    public function showLoginFormQrCode()
    {
        // Get today's QR code
        $qrCode = \DB::table('qrcodes')
        ->where('expires_at', '>', Carbon::now())
        ->latest('expires_at')
        ->first();

        return view('login', compact('qrCode'));    
    }

    public function showLoginForm()
    {
        return view('login');  // Assuming your blade is in the "auth" folder
    }

    
    public function login(Request $request)
    {

        // Validate the input for email and password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:2',
        ]);
        
        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'), true)) {
            // Authentication successful
            // if (Auth::user()->role === 'admin') {
            $user = Auth::user();
            // Retrieve the user's name
            $first_name = $user->first_name; // Adjust if your name field is different
            $email = $user->email; // Adjust if your name field is different
            $profile_image_url = $user->profile_image_url; // Adjust if your name field is different
            $last_name = $user->last_name; // Adjust if your name field is different
            $phone = $user->phone; // Adjust if your name field is different
            $ref = $user->ref; // Adjust if your name field is different

            // Optionally, store the user's name in the session
            session(['email' => $email]);
            session(['last_name' => $last_name]);
            session(['phone' => $phone]);
            session(['ref' => $ref]);

            $currentDateTime = Carbon::now();

           // Update the updated_at column only
            auth()->user()->touch();

            // Get the current date
            $today = Carbon::today();

            $visit_my_joburg_bio = "<div class='flex justify-center text-center'>
                                    <div class='max-w-3xl mx-auto p-4 bg-white'>
                                        <p class='text-gray-600'>
                                            Welcome back, " . auth()->user()->first_name . "
                                        </p>
                                    </div>
                                </div>";

            
            return redirect()->route('home')->with([ 'visit_my_joburg_bio' => $visit_my_joburg_bio]);
            
        } 
    
        // Authentication failed, redirect back with an error
        return back()->withErrors([
            'failed' => 'The provided credentials do not match our records.',
        ]);
    }
    

    public function logout(){
        Auth::logout();
        // Redirect with a success message
        return redirect()->route('login')->with('success', 'User logged out successfully!');

    }


    public function qrLogin(Request $request)
    {
        // Validate the input (expecting a 'code' field from the scanned QR code)
        $request->validate([
            'code' => 'required|string',
        ]);
        
        // Check if the code matches today's QR code
        $qrCode = \DB::table('qrcodes')
        ->where('code', $request->code)
        ->where('expires_at', '>', Carbon::now())
        ->first();
        
        $currentDateTime = Carbon::now();
        
        if ($qrCode) {

            $code = $qrCode->code;
            $correct_qrcode = "Register log @ ".$currentDateTime. ' Please continue';
            return view('login')->with(compact('code', 'correct_qrcode'));

            // Record the login in the daily registration table
            \DB::table('daily_registration')->insert([
                'user_id' => auth()->id(),
                'login_time' => now(),
            ]);

        } else {
            // return back()->withErrors(['code' => 'Invalid or expired QR code.']);
            $incorrect_qrcode = "Error log @ ".$currentDateTime;
            return view('login')->with('incorrect_qrcode', $incorrect_qrcode);

        }
    }
}



// // Public route
// Route::get('/', function () {
//     return view('welcome');  // This is accessible by everyone
// });

// // Protected routes
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');  // Only authenticated users can access this
//     });

//     Route::get('/profile', function () {
//         return view('profile');  // Only authenticated users can access this
//     });
// });
