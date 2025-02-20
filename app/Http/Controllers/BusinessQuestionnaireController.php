<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\BusinessQuestionnaire;
use App\Mail\BusinessQuestionnaireMail;

class BusinessQuestionnaireController extends Controller
{
    // Apply the auth middleware to all methods in this controller
    public function __construct()
    {
        // $this->middleware('auth');
        // to specific methods 
        $this->middleware('auth')->only(['createRef']);
        // $this->middleware('auth')->except(['create', 'store']);

    }

    public function createRef(){

        // $email = auth()->user()->email;
        $email = base64_encode(auth()->user()->email);
        // Redirect with email as a query parameter
        return redirect()->route('business_questionnaire', ['email' => $email]);
    }

    public function businessQuestionnaire(Request $request)
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

            
            return view('layouts.businessQuestionnaire', [
                'decoded_email' => $refPart, // Pass the decoded email
                'fullemail' => $decoded_email, // Pass the decoded email
            ]);
        } else {
            return view('layouts.businessQuestionnaire', [
                'decoded_email' => '', // Pass the decoded email
            ]);
        }
 
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|url',
            'social_media' => 'nullable|string|max:500',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'campaign_goals' => 'nullable|array',
            'brand_story' => 'nullable|string',
            'influencer_size' => 'nullable|string',
            'budget' => 'nullable|string|max:255',
            'campaign_type' => 'nullable|string',
            'brand_guidelines' => 'nullable|string',
            'success_metrics' => 'nullable|string',
            'ref' => 'sometimes|email|max:255', // Optional ref field
            
        ]);
            // Save to database
            $questionnaire = BusinessQuestionnaire::create($validated);

            // Send the email
            Mail::to('promotions@visitmyjoburg.co.za')->send(new BusinessQuestionnaireMail($questionnaire));

            // Redirect with a success message and email
           // Redirect logic
            if (!Auth::check()) {
                return redirect()->back()->with('success', 'Questionnaire submitted successfully!');
            }

            return redirect()->route('home')->with('success', 'Questionnaire submitted successfully!');
    }
}
