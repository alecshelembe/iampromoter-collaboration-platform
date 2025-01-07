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

    public function home()
    {
               
    }
    
    public function login(Request $request)
    {

        if ($request->has('code')) {
            // The request contains the 'code' field
            $request->validate([
                'code' => 'required|string',
            ]);
            $code_is_present = true;
        }
        // Validate the input for email and password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:2',
        ]);
        
        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            // if (Auth::user()->role === 'admin') {
            $user = Auth::user();
            // Retrieve the user's name
            $first_name = $user->first_name; // Adjust if your name field is different
            $last_name = $user->last_name; // Adjust if your name field is different
            $phone = $user->phone; // Adjust if your name field is different
            $ref = $user->ref; // Adjust if your name field is different

            // Optionally, store the user's name in the session
            session(['first_name' => $first_name]);
            session(['last_name' => $last_name]);
            session(['phone' => $phone]);
            session(['ref' => $ref]);

            $currentDateTime = Carbon::now();

           // Update the updated_at column only
            auth()->user()->touch();
            // Authentication passed, redirect to the intended page
            if (isset($code_is_present)) {
                // Check if the email exists in the past 24 hours
                $exists = DailyRegistration::where('email', auth()->user()->email)
                            ->where('login_time', '>=', Carbon::now()->subDay()) // Past 24 hours
                            ->exists();
            
                if (!$exists) {
                    try {
                        DailyRegistration::create([
                            'email' => auth()->user()->email,
                            'login_time' => now(),
                            'name_first' => auth()->user()->first_name,
                            'name_last' => auth()->user()->last_name,
                            'email_address' => auth()->user()->email,
                            'cell_number' => auth()->user()->phone,
                            'm_payment_id' => Str::uuid()->toString(),
                            'item_name' => 'Entry',
                            'custom_int1' => rand(),
                            'custom_str1' => bin2hex(random_bytes(5)), // Random string of 10 characters
                            'payment_method' => '',
                        ]);

                        } catch (\Exception $e) {
                            \Log::error('Error inserting DailyRegistration: ' . $e->getMessage());
                            // return redirect()->back()->withErrors(['error' => 'Unable to record login.']);
                        }

                        $registration = DailyRegistration::where('email', auth()->user()->email)
                        ->where('login_time', '>=', Carbon::now()->subDay())
                        ->first();

                        $jsonRegistration = $registration ? $registration->toJson() : json_encode(null);

                        // $exists = "Entry log @ ".$currentDateTime. ' Successful';
                        // Pass missing values to the view
                        return view('payfast.here', ['registration' => $jsonRegistration]);

                } else {
                    // Handle the case where the email has already been recorded in the last 24 hours
                    // For example, you could return an error message
                    // $exists = "Entry log exists.";
                    // return redirect()->route('home')->with('exists', $exists);
                    $registration = DailyRegistration::where('email', auth()->user()->email)
                    ->where('login_time', '>=', Carbon::now()->subDay())
                    ->first();

                    $jsonRegistration = $registration ? $registration->toJson() : json_encode(null);

                    // $exists = "Entry log @ ".$currentDateTime. ' Successful';
                    // Pass missing values to the view
                    return view('payfast.here', ['registration' => $jsonRegistration]);

                }   
            }

            // Get the current date
            $today = Carbon::today();

            // Check if the user has logged in today
            $exists = DailyRegistration::where('email', auth()->user()->email)
                ->where('login_time', '>=', Carbon::now()->subDay()) // Past 24 hours
                ->first();

            if ($exists) {
            // Store payment_status in the session
            session(['payment_status' => $exists->payment_status]);
            } else {
            // Optionally, clear the session if no registration exists or set a default
            session()->forget('payment_status'); // or session(['payment_status' => 'default_value']);
            }


            if (!$exists) {
                $exists = '<a href="' . route('login.qrcode') . '" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded bg-gray-100 hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                                <!-- Plus icon -->
                               Daily Entry
                            </a>';
            } else {
                
                $exists = "";
            }
            
            return redirect()->route('home')->with('exists', $exists); // Redirect to 'home' route with $exists

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
