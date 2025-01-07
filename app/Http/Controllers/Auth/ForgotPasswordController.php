<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('emails.passwords.email'); // Create this view
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $response = Password::sendResetLink($request->only('email'));
            
        if ($response == Password::RESET_LINK_SENT) {
            session()->flash('status', trans($response));
        } else {
            session()->flash('error', trans($response));
        }
    
        return back();
    }
    
}

