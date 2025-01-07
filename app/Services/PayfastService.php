<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayfastService
{
    public function validSignature($pfData, $pfParamString)
    {
        $pfPassphrase = env('PAYFAST_PASSPHRASE');

        if ($pfPassphrase === null) {
            $tempParamString = $pfParamString;
        } else {
            $tempParamString = $pfParamString . '&passphrase=' . urlencode($pfPassphrase);
        }

        $signature = md5($tempParamString);
        return ($pfData['signature'] === $signature);
    }

    public function validIP()
    {
        $validHosts = [
            'www.payfast.co.za',
            'sandbox.payfast.co.za',
            'w1w.payfast.co.za',
            'w2w.payfast.co.za',
        ];

        $validIps = [];

        foreach ($validHosts as $pfHostname) {
            $ips = gethostbynamel($pfHostname);
            if ($ips !== false) {
                $validIps = array_merge($validIps, $ips);
            }
        }

        $validIps = array_unique($validIps);
        if (isset($_SERVER['HTTP_REFERER'])) {
            $parsedUrl = parse_url($_SERVER['HTTP_REFERER']);
            
            if (isset($parsedUrl['host'])) {
                $referrerIp = gethostbyname($parsedUrl['host']);
            } else {
                // Handle the case where 'host' is not present
                $referrerIp = null; // or some default value
            }
        } else {
            // Handle the case where 'HTTP_REFERER' is not set
            $referrerIp = null; // or some default value
        }
        return in_array($referrerIp, $validIps, true);
    }

    public function validPaymentData($cartTotal, $pfData)
    {
        return !(abs((float)$cartTotal - (float)$pfData['amount_gross']) > 0.01);
    }

    public function validServerConfirmation($pfParamString, $pfHost = 'sandbox.payfast.co.za', $pfProxy = null)
    {
        $url = 'https://' . $pfHost . '/eng/query/validate';

        $response = Http::withOptions(['verify' => true])->post($url, $pfParamString);

        return $response->body() === 'VALID';
    }
}
