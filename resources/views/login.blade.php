
@extends('welcome')

@section('content')

@if(session('image'))
    <img src="{{ asset('storage/images/' . session('image')) }}" alt="Uploaded Image">
@endif

<div class="mx-auto max-w-sm p-4">
            @if (Request::is('QrCodeLogin'))
            
                @if($qrCode)
                    <form method="GET" action="{{ route('qr.login') }}">
                    @csrf
                        <div class="qr-code">
                            <center><div class="rounded-full mx-auto w-60 h-60" >{!! QrCode::size(170)->generate(route('qr.login', ['code' => $qrCode->code])) !!}</div></center>
                        </div>
                    <!-- Hidden input to store the QR code -->
                        <input type="hidden" name="code" value="{{ $qrCode->code }}">
                    <!-- Submit button -->
                    {{-- <button type="submit" class="btn btn-primary">Submit QR Code</button> --}}
                    </form>

                @else
                    <p>No QR code available.</p>
                @endif
                <!-- Do something if the current URL matches -->
            @else
                <img class="rounded-full mx-auto w-60 h-60" src="{{ config('services.project.logo_image') }}" alt="image description">
            @endif
    <form action="{{ route('users.the.login') }}"  method="post" class="space-y-6 animate-fadeIn">

        <h5 class="text-xl text-center font-medium text-gray-900 dark:text-white">
            <a href="{{ route('login') }}">
                <span class="text-bold underline">Sign in</span> to our platform
            </a>
        </h5>
        

        <div class="text-center mx-auto">
            @csrf
            @if(isset($code))
                <input type="text" name="code" value="{{ $code }}" hidden/>
                <p class="mx-auto" style="color: green;">{{$correct_qrcode}}</p>
            @endif

            @if (Request::is('QrCodeLogin'))
                <input type="hidden" name="code" value="{{ $qrCode->code }}">
            @endif

            @if(isset($incorrect_qrcode))
                <p class="mx-auto" style="color: red;">{{$incorrect_qrcode}}</p>
            @endif
            
            @if (session('success'))
                <p class="mx-auto" style="color: green;">{{ session('success') }}</p>
            @endif
            @if ($errors->has('failed'))
                <p class="mx-auto" style="color: red;">{{ $errors->first('failed') }}</p>
            @endif
        </div>
        <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
            @if (session('success'))
                <!-- Input pre-filled with the email from session -->
                <input type="email" value="{{ session('email') }}" name="email" id="email" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 
                    dark:text-white" required />
            @else
                <!-- Default input if there's no success message -->
                <input type="email" name="email" id="email" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 
                    dark:text-white" placeholder="name@company.com" required />
            @endif
        </div>
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
        </div>
        <div class="flex items-start">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                </div>
                <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
            </div>
            <a href="{{ route('password.request') }}" class="ms-auto text-sm text-blue-700 hover:underline dark:text-blue-500">Lost Password?</a>
        </div>
        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign In </button>
        <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
            Not registered? <a href="{{ route('users.create') }}" class="text-blue-700 hover:underline dark:text-blue-500">Create account</a>
        </div>
    </form>
</div>

@endsection
