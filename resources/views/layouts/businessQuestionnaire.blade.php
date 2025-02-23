@extends('welcome')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6"> Promotion questionnaire</h2>
    @if (session('success'))
        <div class="text-center p-1 mb-1">
            <p class="mx-auto" style="background-color:#f5f5f5; color: green;"> {!! session('success') !!}</p>
        </div>
    @endif
    <form action="{{ route('business.questionnaire.submit') }}" method="POST" class="space-y-4">
        @csrf
        @if($decoded_email)
            <p class="text-gray-500 text-sm">Reference: {{ $decoded_email }}</p>
            @error('ref')
            <p class="text-red-600  mt-1">{{ $message }}</p>
            @enderror
            <input type="text" name="ref" value="{{ $fullemail }}" class="hidden text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">
        @else
            {{-- <p>No reference email provided.</p> --}}
        @endif
        
        <h4 class="text-lg font-semibold">Business Information</h4>
        <div>
            <label class="block text-gray-700">Business Name</label>
            <input type="text" class="w-full border rounded p-2" name="business_name" required>
        </div>
        
        <div>
            <label class="block text-gray-700">Industry/Category</label>
            <input type="text" class="w-full border rounded p-2" name="industry" required>
        </div>
        
        <div>
            <label class="block text-gray-700">Business Website (if applicable)</label>
            <input type="url" class="w-full border rounded p-2" name="website">
        </div>
        
        <div>
            <label class="block text-gray-700">Social Media Handles</label>
            <input type="text" class="w-full border rounded p-2" name="social_media">
        </div>
        
        <div>
            <label class="block text-gray-700">Contact Person</label>
            <input type="text" class="w-full border rounded p-2" name="contact_person" required>
        </div>
        
        <div>
            <label class="block text-gray-700">Email</label>
            <input type="email" class="w-full border rounded p-2" name="email" required>
        </div>
        
        <div>
            <label class="block text-gray-700">Phone Number</label>
            <input type="tel" class="w-full border rounded p-2" name="phone" required>
        </div>
        
        <h4 class="text-lg font-semibold">Campaign Goals</h4>
        <div>
            <label class="block text-gray-700">Primary Goals</label>
            <select class="w-full border rounded p-2" name="campaign_goals[]" multiple>
                <option value="brand_awareness">Increase brand awareness</option>
                <option value="sales">Drive sales/conversions</option>
                <option value="engagement">Boost social media engagement</option>
                <option value="new_product">Promote a new product/service</option>
                <option value="event_promotion">Promote an event</option>
            </select>
        </div>
        
        <div>
            <label class="block text-gray-700">Key Message or Brand Story</label>
            <textarea class="w-full border rounded p-2" name="brand_story" rows="3"></textarea>
        </div>
        
        <h4 class="text-lg font-semibold">Influencer Collaboration</h4>
        <div>
            <label class="block text-gray-700">Preferred Influencer Size</label>
            <select class="w-full border rounded p-2" name="influencer_size">
                <option value="nano">Nano (1K-10K followers)</option>
                <option value="micro">Micro (10K-50K followers)</option>
                <option value="macro">Macro (50K-500K followers)</option>
                <option value="mega">Mega (500K+ followers)</option>
                <option value="any">Any size</option>
            </select>
        </div>
        
        <h4 class="text-lg font-semibold">Campaign Logistics</h4>
        <div>
            <label class="block text-gray-700">Budget Range (Optional)</label>
            <input type="text" class="w-full border rounded p-2" name="budget">
        </div>
        
        <div>
            <label class="block text-gray-700">Campaign Type</label>
            <select class="w-full border rounded p-2" name="campaign_type">
                <option value="sponsored_posts">Sponsored posts</option>
                <option value="giveaways">Giveaways/contests</option>
                <option value="product_reviews">Product reviews</option>
                <option value="event_promotion">Event promotion</option>
                <option value="influencer_takeover">Influencer account takeover</option>
            </select>
        </div>
        
        <h4 class="text-lg font-semibold">Additional Information</h4>
        <div>
            <label class="block text-gray-700">Brand Guidelines/Restrictions</label>
            <textarea class="w-full border rounded p-2" name="brand_guidelines" rows="3"></textarea>
        </div>
        
        <div>
            <label class="block text-gray-700">Success Metrics</label>
            <textarea class="w-full border rounded p-2" name="success_metrics" rows="3"></textarea>
        </div>
        
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Submit</button>
    </form>
</div>
@endsection
