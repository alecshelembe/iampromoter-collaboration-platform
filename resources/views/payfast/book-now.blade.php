@extends('welcome')

@section('content')

<div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold text-center text-gray-800">
         {{ $socialPost->place_name ?? 'N/A' }}
    </h2>
    <p class="text-center text-gray-600 mt-2">
         {{ $socialPost->address ?? 'No address provided' }}
    </p>


    <div class="mt-6 border rounded-lg p-4 bg-gray-100">
        <h3 class="text-lg font-semibold text-gray-700">Booking Summary</h3>
      
        <div class="flex justify-between mt-2 text-gray-600">
            <span>Host</span>
            <span>{{ $socialPost->email ?? 'N/A' }}</span>
        </div>
    </div>

    <form action="{{ route('payment.process') }}" method="POST" class="mt-6">
        @csrf
        <input type="hidden" name="post_id" value="{{ $socialPost->id }}">

        <button class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg shadow-md transition-all duration-300 flex items-center justify-center gap-2">
            <i class="fa-solid fa-lock"></i> Pay Now
        </button>
    </form>

    <p class="text-center text-gray-500 mt-4 text-sm">Your payment is 100% secure with PayFast.</p>
</div>

@endsection
