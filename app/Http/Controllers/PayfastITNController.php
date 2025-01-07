<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayfastTransaction;
use App\Services\PayfastService;
use App\Models\DailyRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class PayfastITNController extends Controller
{
    protected $pfHost;

    public function __construct()
    {
        $this->pfHost = env('PAYFAST_TESTING_MODE', true) ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
    }

    public function handleITN(Request $request, PayfastService $payfastService)
    {
        // Send a 200 OK response
        
        return response()->json($this->processITN($request, $payfastService), 200);
    }

    private function processITN(Request $request, PayfastService $payfastService)
    {
        
        $pfData = $request->all();

        // Strip any slashes in data
        array_walk($pfData, function (&$val) {
            $val = stripslashes($val);
        });

        // Prepare the parameter string for verification
        $pfParamString = http_build_query(array_diff_key($pfData, ['signature' => '']));
        
        // Fetch the registration record
        $registration = DailyRegistration::where('email', $pfData['email_address'])
            ->where('login_time', '>=', Carbon::now()->subDay())
            ->first();

        $cartTotal = $registration ? $registration->amount : null;

        // Validate all checks
        $checks = [
            'signature' => $payfastService->validSignature($pfData, $pfParamString),
            'ip' => $payfastService->validIP(),
            'payment_data' => $payfastService->validPaymentData($cartTotal, $pfData),
            'server_confirmation' => $payfastService->validServerConfirmation($pfParamString, $this->pfHost),
        ];
        
        if (array_product($checks)) {
            // All checks have passed, the payment is successful
            return $this->createTransaction($pfData, 'success');
        } else {
            // Log the failed checks
            Log::error('Payment validation failed', ['checks' => $checks, 'pfData' => $pfData]);
            return $this->createTransaction($pfData, 'error', 'Payment validation failed');
        }
    }

    private function createTransaction(array $pfData, string $status, string $message = null)
    {
        $transactionData = array_intersect_key($pfData, array_flip([
            'm_payment_id', 
            'pf_payment_id',  
            'payment_status', 
            'item_name',
            'item_description',  
            'amount_gross',
            'amount_fee',
            'amount_net',
            'custom_str1',
            'custom_str2',
            'custom_str3',
            'custom_str4',
            'custom_str5',
            'custom_int1',
            'custom_int2',
            'custom_int3',
            'custom_int4',
            'custom_int5',
            'name_first',
            'email_address',
            'merchant_id',
            'signature',
        ]));

        PayfastTransaction::create($transactionData);

        return [
         'status' => $status,
         'message' => $message,
        ];
    }
}
