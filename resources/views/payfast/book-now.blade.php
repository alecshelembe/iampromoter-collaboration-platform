@extends('welcome')

@section('content')
{{-- @include('layouts.navbar') --}} 

<div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold text-center text-gray-800">
        {{ $socialPost->place_name ?? 'N/A' }}
    </h2>
    <p class="text-center text-gray-600 mt-2">
        {{ $socialPost->address ?? 'No address provided' }}
    </p>

    <div class="mt-6 border rounded-lg p-4 bg-gray-100">
        <h3 class="text-lg font-semibold text-gray-700">Booking Fee</h3>
      
        <div class="  mt-2 text-gray-600">
            <p>Contact </p>
            <p>{{ $socialPost->email ?? 'N/A' }}</p>
        </div>
        <div class="  mt-2 text-gray-600">
            <p>Total</p>
            <p>R {{ $socialPost->fee ?? 'N/A' }}</p>
        </div>
    </div>
    
    <form id="initialForm" action="{{ route('payment.process') }}" method="POST">
    @csrf
    @php
        $transaction = json_decode($transaction);
    @endphp

    @if ($transaction)
    <div class="hidden">

            @foreach ($transaction as $key => $value)
                <label for="{{ $key }}">{{ ucfirst($key) }}:</label>
                <input type="text" name="{{ $key }}" id="{{ $key }}" value="{{ $value }}" />
                <br />
            @endforeach
        </div>
    @else
        <p>No User found.</p>
    @endif

        <button type="submit" id="old_button" class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirm</button>
    </form>

    <div id="paymentFormContainer"></div> <!-- This will hold the payment form -->
</div>
<p class="text-center text-gray-500 mt-4 text-sm">Your payment is 100% secure with PayFast.</p>

<script>
document.addEventListener("DOMContentLoaded", function() {
    $(document).ready(function() {
        $('#initialForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            // console.log($(this).serialize());

            // Include CSRF token in the request headers
            $.ajax({
                url: '{{ route("payment.transaction.process") }}', // Your route for handling the form submission
                type: 'POST',
                data: $(this).serialize(), // Serialize form data
               
                success: function(response) {
                    // Assuming response contains the PayFast payment form HTML or redirection info
                    $('#paymentFormContainer').html(response).addClass('mt-2');
                    $('#old_button').hide(); // Hide the button after form submission
                    $('#old_button').prop('disabled', true).text('Processing...');

                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Log the response for debugging
                    alert('There was an error processing your request. Please try again.');
                }
            });
        });
    });
});
</script>

@endsection
