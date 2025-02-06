<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyRegistration;
use App\Models\PayfastTransaction;
use Carbon\Carbon;
use App\Models\SocialPost;
use Illuminate\Support\Str;


class PayfastController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // to specific methods 
        // $this->middleware('auth')->only(['create', 'store']);
        // $this->middleware('auth')->except(['create', 'store']);

    }

    public function createPayfastPayment(){
        return view('payfast.here'); 
    }
    
    public function createPayfastPaymentforBookNow(Request $request, $id) {
        // Fetch the SocialPost object by ID
        $socialPost = SocialPost::findOrFail($id);

        try {
            PayfastTransaction::create([
                'email' => auth()->user()->email,
                'login_time' => now(),
                'name_first' => auth()->user()->first_name,
                'name_last' => auth()->user()->last_name,
                'email_address' => auth()->user()->email,
                'cell_number' => auth()->user()->phone,
                'm_payment_id' => Str::uuid()->toString(),
                'item_description' => $socialPost->place_name, // Use the PHP variable here
                'item_name' => $socialPost->place_name, // Use the PHP variable here
                'amount' => $socialPost->fee, // Use the PHP variable here
                'custom_int1' => rand(),
                'custom_str1' => bin2hex(random_bytes(5)), // Random string of 10 characters
                'payment_method' => '',
            ]);

            } catch (\Exception $e) {
                \Log::error('Error inserting: ' . $e->getMessage());
                // return redirect()->back()->withErrors(['error' => 'Unable to record login.']);
            }

            // Check if the email exists in the past 24 hours
            $exists = PayfastTransaction::where('email', auth()->user()->email)
            ->where('created_at', '>=', Carbon::now()->subDay()) // Past 24 hours
            ->first();

            $transaction = $exists ? $exists->toJson() : json_encode(null);

            // Pass both $socialPost and $transaction to the view
            return view('payfast.book-now', compact('socialPost', 'transaction'));
            
    }
    
    public function payfastPaymentTransations(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'amount' => 'required|numeric',
            'item_description' => 'required|string',
            'email' => 'required|email',
            // Add more validation rules as necessary
        ]);

        // Collect all form data from the request
        $data = $request->except('_token','email','id','created_at','updated_at','payment_status'); // Exclude the CSRF token from data
        
        // Fetch the transaction record
        $transaction = PayfastTransaction::where('email', $data['email_address'])
        ->where('created_at', '>=', Carbon::now()->subDay())
        ->first();
        
        // Update fields
        $transaction->amount = $data['amount']; // Set newAmount to the desired value
        $transaction->item_description = $data['item_description']; // Set newAmount to the desired value
        $transaction->save(); // Save the changes to the database

        // Passphrase and testing mode from environment variables
        $passPhrase = env('PAYFAST_PASSPHRASE', 'default_passphrase');
        $testingMode = env('PAYFAST_TESTING_MODE', true);
        // Generate the signature
        $signature = $this->generateSignature($data, $passPhrase);

        // Add the signature to the data
        $data['signature'] = $signature;

        // Determine PayFast host
        $pfHost = 'www.payfast.co.za';

        // Return the payment form partial as HTML
        return view('payfast.form', compact('data', 'pfHost'))->render();

    }


    public function payfastPayment(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'amount' => 'required|numeric',
            'item_description' => 'required|string',
            'email' => 'required|email',
            // Add more validation rules as necessary
        ]);

        // Collect all form data from the request
        $data = $request->except('_token','email','id','login_time','created_at','updated_at','payment_status'); // Exclude the CSRF token from data
        
        // Fetch the registration record
        $registration = DailyRegistration::where('email', $data['email_address'])
        ->where('login_time', '>=', Carbon::now()->subDay())
        ->first();
        
        // Update fields
        $registration->amount = $data['amount']; // Set newAmount to the desired value
        $registration->item_description = $data['item_description']; // Set newAmount to the desired value
        $registration->save(); // Save the changes to the database

        // Passphrase and testing mode from environment variables
        $passPhrase = env('PAYFAST_PASSPHRASE', 'default_passphrase');
        $testingMode = env('PAYFAST_TESTING_MODE', true);
        // Generate the signature
        $signature = $this->generateSignature($data, $passPhrase);

        // Add the signature to the data
        $data['signature'] = $signature;

        // Determine PayFast host
        $pfHost = 'www.payfast.co.za';

        // Return the payment form partial as HTML
        return view('payfast.form', compact('data', 'pfHost'))->render();

    }


    public function generateSignature($data, $passPhrase)
    {
         // Print the data for debugging
        // print_r($data);
        // Create parameter string
        $pfOutput = '';
        foreach( $data as $key => $val ) {
            if($val !== '') {
                $pfOutput .= $key .'='. urlencode( trim( $val ) ) .'&';
            }
        }
        // Remove last ampersand
        $getString = substr( $pfOutput, 0, -1 );
        if( $passPhrase !== null ) {
            $getString .= '&passphrase='. urlencode( trim( $passPhrase ) );
        }
        return md5( $getString );
    }

    public function return_url_transactions() {
        // Set PayFast host based on the environment
        $testingMode = env('PAYFAST_TESTING_MODE', true);
        $pfHost = 'www.payfast.co.za';
    
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referrerHost = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    
            if ($referrerHost === $pfHost) {
                // Get the email of the currently logged-in user
                $email = auth()->user()->email;
    
                // Fetch the transaction record
                $transaction = PayfastTransaction::where('email', $data['email_address'])
                ->where('created_at', '>=', Carbon::now()->subDay())
                ->first();

                $campaign_number = rand(100,9999);
    
                if ($transaction) {
                    // Update fields
                    $transaction->payment_status = $campaign_number;

                    session(['payment_status' => $transaction->payment_status]);

                    $transaction->save();
    
                    // return response()->json(['notify' => 'success'], 200);
                    return redirect()->route('home'); 

                } else {
                    return response()->json(['error' => 'No transaction found'], 404);
                }
    
            } else {
                // Referrer does not match the expected host
                return response()->json(['error' => 'Invalid referrer 0001 '], 403);
            }
        } else {
            // No referrer set, redirect to cancel URL
            return response()->json(['error' => 'Invalid referrer 0002 '], 403);
            // return redirect()->route('cancel_url');
        }
    }

    public function return_url() {
        // Set PayFast host based on the environment
        $testingMode = env('PAYFAST_TESTING_MODE', true);
        $pfHost = 'www.payfast.co.za';
    
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referrerHost = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    
            if ($referrerHost === $pfHost) {
                // Get the email of the currently logged-in user
                $email = auth()->user()->email;
    
                $registration = DailyRegistration::where('email', $email)
                    ->where('login_time', '>=', Carbon::now()->subDay())
                    ->first();

                $campaign_number = rand(100,9999);
    
                if ($registration) {
                    // Update fields
                    $registration->payment_status = $campaign_number;

                    session(['payment_status' => $registration->payment_status]);

                    $registration->save();
    
                    // return response()->json(['notify' => 'success'], 200);
                    return redirect()->route('home'); 

                } else {
                    return response()->json(['error' => 'No registration found'], 404);
                }
    
            } else {
                // Referrer does not match the expected host
                return response()->json(['error' => 'Invalid referrer 0001 '], 403);
            }
        } else {
            // No referrer set, redirect to cancel URL
            return response()->json(['error' => 'Invalid referrer 0002 '], 403);
            // return redirect()->route('cancel_url');
        }
    }

    public function cancel_url_transactions() {
        $email = auth()->user()->email;
    
        // Fetch the transaction record
        $transaction = PayfastTransaction::where('email', $data['email_address'])
        ->where('created_at', '>=', Carbon::now()->subDay())
        ->first();

        if ($transaction) {
            // Update fields
            $transaction->payment_status = 'Cancelled';

            session(['payment_status' => $transaction->payment_status]);

            $transaction->save();
        }
    
        return redirect()->route('home'); // Redirect to 'home' route with $exists
    }
    
    public function cancel_url() {
        $email = auth()->user()->email;
    
        $registration = DailyRegistration::where('email', $email)
            ->where('login_time', '>=', Carbon::now()->subDay())
            ->first();
    
        if ($registration) {
            // Update fields
            $registration->payment_status = 'Cancelled';

            session(['payment_status' => $registration->payment_status]);

            $registration->save();
        }
    
        return redirect()->route('home'); // Redirect to 'home' route with $exists
    }

    
    function generateApiSignature($pfData, $passPhrase) {

        if ($passPhrase !== null) {
            $pfData['passphrase'] = $passPhrase;
        }

        // Sort the array by key, alphabetically
        ksort($pfData);

        //create parameter string
        $pfParamString = http_build_query($pfData);
        return md5($pfParamString);
    }
}
