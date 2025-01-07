@extends('welcome')

@section('content')
{{-- @include('layouts.navbar') --}}

<div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md">
<form id="initialForm" action="{{ route('payment.process') }}" method="POST">
@csrf
    @php
    $registrationData = json_decode($registration);
    @endphp

    @if ($registrationData)
    <div class="hidden">
    @foreach ($registrationData as $key => $value)
        <label for="{{ $key }}">{{ ucfirst($key) }}:</label>
        <input type="text" name="{{ $key }}" id="{{ $key }}" value="{{ $value }}" />
        <br />
        @endforeach
        {{-- <input type="text" name="signature" value=""> --}}
    </div>
    @else
    <p>No registration found.</p>
    @endif

    <a href="#">
        <img class="rounded-full mx-auto w-60 h-60" src="{{ config('services.project.logo_image') }}" alt="image description">
    </a>
    <a href="#">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Entrance</h5>
    </a>

    <label for="adult-input" class="block my-2 text-sm font-medium text-gray-900 dark:text-white">Select Adults:</label>
    <div class="relative flex items-center">
        <button type="button" id="decrement-adults" class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-8 w-10">
            <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
            </svg>
        </button>
        <input type="text" id="adult-input" data-input-counter class="text-gray-900 border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center" value="1" required />
        <button type="button" id="increment-adults" class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-8 w-10">
            <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
            </svg>
        </button>
    </div>

    <label for="children-input" class="block my-2 text-sm font-medium text-gray-900 dark:text-white">Select Children:</label>
    <div class="relative flex items-center">
        <button type="button" id="decrement-children" class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-8 w-10">
            <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
            </svg>
        </button>
        <input type="text" id="children-input" data-input-counter class="text-gray-900 border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center" value="1" required />
        <button type="button" id="increment-children" class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-8 w-10">
            <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
            </svg>
        </button>
    </div>

    <div class="mb-4">
        <label for="item_description">Item Description</label>
        <input id="item_description_notjson" type="text"  value="" required class="block py-2.5 px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600   
dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
    </div>
    <p class="my-3 font-normal text-gray-700 dark:text-gray-400">This ticket grants the holder access to designated areas of Sci-Bono Discovery Science Center. It allows entry for adult or child as per ticket indicates. You may enquire and participate in all available activities and facilities. Each ticket is valid for one day only and is non-transferable.</p>
    <input type="text" id="total_notjson" class="hidden text-center rounded-xl shadow-md w-2/3 text-black my-4 py-2 ">


<button type="submit" id="old_button" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirm </button>

</form>
<div id="paymentFormContainer"></div> <!-- This will hold the payment form -->
</div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const adultInput = document.getElementById('adult-input');
        const childrenInput = document.getElementById('children-input');
        const itemDescriptionInput = document.getElementById('item_description');
        const itemDescriptionInputNotJson = document.getElementById('item_description_notjson');

        const adultPrice = {{ env('ADULT_PRICE', 80) }}; // Default value is 80 if env var is not set
        const childrenPrice = {{ env('CHILDREN_PRICE', 60) }}; // Default value is 60 if env var is not set

        console.log('Adult Price:', adultPrice);
        console.log('Children Price:', childrenPrice);

        function updateDescription() {
            const adults = parseInt(adultInput.value) || 0;
            const children = parseInt(childrenInput.value) || 0;
            const total = (adults * adultPrice) + (children * childrenPrice);

            itemDescriptionInput.value = `Adults: ${adults}, Children: ${children}, Total: R ${total}`;
            itemDescriptionInputNotJson.value = `Adults: ${adults}, Children: ${children}, Total: R ${total}`;

            document.getElementById('amount').value=total;
        }

        // Event listeners for increment and decrement buttons
        document.getElementById('increment-adults').addEventListener('click', function () {
            adultInput.value = parseInt(adultInput.value) + 1;
            updateDescription();
        });

        document.getElementById('decrement-adults').addEventListener('click', function () {
            if (adultInput.value > 1) {
                adultInput.value = parseInt(adultInput.value) - 1;
                updateDescription();
            }
        });

        document.getElementById('increment-children').addEventListener('click', function () {
            childrenInput.value = parseInt(childrenInput.value) + 1;
            updateDescription();
        });

        document.getElementById('decrement-children').addEventListener('click', function () {
            if (childrenInput.value > 0) {
                childrenInput.value = parseInt(childrenInput.value) - 1;
                updateDescription();
            }
        });

        // Initialize description
        updateDescription();
    });
</script>


<script>
    $(document).ready(function() {
        $('#initialForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            console.log($(this).serialize());
            $.ajax({
                url: '{{ route("payment.process") }}', // Your route for handling the form
                type: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Insert the payment form HTML into the container
                    $('#paymentFormContainer').html(response);
                    $('#old_button').hide();
                },
                error: function(xhr) {
                    // Handle errors if necessary
                    alert('There was an error processing your request.');
                }
            });
        });
    });
    </script>


@endsection
