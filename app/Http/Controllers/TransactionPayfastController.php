<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SocialPost;
use Illuminate\Support\Str;
use App\Mail\PayfastTransactionNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\PayfastTransaction;

class TransactionPayfastController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // to specific methods 
        // $this->middleware('auth')->only(['create', 'store']);
        // $this->middleware('auth')->except(['create', 'store']);

    }
    
    public function createPayfastPaymentforBookNow(Request $request, $id) {

        $email = auth()->user()->email;

        // Fetch the SocialPost object by ID
        $socialPost = SocialPost::findOrFail($id);
        
        try {
            PayfastTransaction::create([
                'email' => $socialPost->email,
                'login_time' => now(),
                'name_first' => auth()->user()->first_name,
                'name_last' => auth()->user()->last_name,
                'email_address' => auth()->user()->email,
                'cell_number' => auth()->user()->phone,
                'm_payment_id' => Str::uuid()->toString(),
                'item_description' => $socialPost->address, // Use the PHP variable here
                'item_name' => $socialPost->place_name, // Use the PHP variable here
                'amount' => $socialPost->fee, // Use the PHP variable here
                'custom_int1' => rand(),
                'custom_str1' => bin2hex(random_bytes(5)), // Random string of 10 characters
                'payment_method' => env('PAYMENT_METHOD', true),
            ]);

            } catch (\Exception $e) {
                \Log::error('Error inserting: ' . $e->getMessage());
                // return redirect()->back()->withErrors(['error' => 'Unable to record login.']);
            }

            $exists = PayfastTransaction::where('email_address', $email)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->orderBy('created_at', 'desc') // Sort by newest first
            ->first();

            $transaction = $exists ? $exists->toJson() : json_encode(null);

            // Pass both $socialPost and $transaction to the view
            return view('payfast.book-now', compact('socialPost', 'transaction'));
            
    }
    
    public function payfastPaymentTransations(Request $request)
    {
        $email = auth()->user()->email;

        // Validate incoming request data
        $request->validate([
            'amount' => 'required|numeric',
            'item_description' => 'required|string',
            'email_address' => 'required|email',
            // Add more validation rules as necessary
        ]);

        // Collect all form data from the request
        $data = $request->except('_token','email','id','created_at','updated_at','payment_status'); // Exclude the CSRF token from data
        
        $transaction = PayfastTransaction::where('email_address', $data['email_address'])
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->orderBy('created_at', 'desc') // Sort by newest first
            ->first();
        
        $transaction->update([
            'amount' => $data['amount'],
            'item_description' => $data['item_description'],
        ]);

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

    public function return_url() {
        // Set PayFast host based on the environment
        $testingMode = env('PAYFAST_TESTING_MODE', true);
        $pfHost = 'www.payfast.co.za';
    
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referrerHost = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    
                // Get the email of the currently logged-in user
                $email = auth()->user()->email;
    
                // Fetch the transaction record
                $transaction = PayfastTransaction::where('email_address', $email)
                ->where('created_at', '>=', Carbon::now()->subDay())
                ->orderBy('created_at', 'desc') // Sort by newest first
                ->first();

                $campaign_number = rand(100,9999);
    
                if ($transaction) {
                    // Update fields
                    $transaction->payment_status = $campaign_number.' '.$referrerHost;

                    session(['payment_status' => $transaction->payment_status]);

                    $transaction->save();

                    // Manually call the notifyTransaction method to send emails
                    app(\App\Http\Controllers\TransactionPayfastController::class)->notifyTransaction($transaction->id);
    
                    // return response()->json(['notify' => 'success'], 200);
                    return redirect()->route('home'); 

                } else {
                    return response()->json(['error' => 'No transaction found'], 404);
                }
    
            
        } else {
            // No referrer set, redirect to cancel URL
            return response()->json(['error' => 'Did you run email send? Invalid referrer 0002 '], 403);
            // return redirect()->route('cancel_url');
        }
    }

    public function cancel_url() {
        $email = auth()->user()->email;
    
        $transaction = PayfastTransaction::where('email', $email)
        ->orderBy('created_at', 'desc') // Sort by newest first
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
    
    public function history()
    {
       // Get the authenticated user's email
        $email = auth()->user()->email;

        // Fetch all posts from `PayfastTransaction` created in the last month for the authenticated user
        $transactions = PayfastTransaction::where('email_address', $email)
            ->where('created_at', '>=', now()->subMonth()) // Changed to 1 month
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Check if there are transactions
        if ($transactions->isEmpty()) {
            return view('payfast.history', ['transactions' => [], 'message' => 'No transactions found in the last 30 days']);
        }
    
        // Return the transactions to the view
        return view('payfast.history', ['transactions' => $transactions]);
    }

    public function notifyTransaction($transactionId)
    {
        // Fetch the transaction details
        $transaction = PayfastTransaction::findOrFail($transactionId);

        // Prepare data for the email
        $data = $transaction->toArray();

        // Send email to the recipient
        Mail::to($transaction->email_address)->send(new PayfastTransactionNotification($data));

        // Send email to the host
        Mail::to($transaction->email)->send(new PayfastTransactionNotification($data));

        // Send email to the confirmation address
        Mail::to(env('CONFIRMATION_ADDRESS'))->send(new PayfastTransactionNotification($data));

        // return 'Emails sent successfully!';
        // return view('payfast.history', ['transactions' => $transactions]);
        return redirect()->route('return_url_transaction'); // Redirect to 'home' route with $exists

        
    }
    
}
