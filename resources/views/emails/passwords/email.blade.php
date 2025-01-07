@extends('welcome')

@section('content')

<div class="mx-auto max-w-sm p-4">
    <img class="rounded-full mx-auto w-60 h-60" src="{{ config('services.project.logo_image') }}" alt="image description">
    <h5 class="text-xl text-center font-medium text-gray-900 dark:text-white">Reset Your Password</h5>
    
    @if(session('status'))
    <div class="p-4 mb-4 text-sm text-green-600 bg-green-100 rounded-lg" role="alert">{{ session('status') }}</div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-600 bg-red-100 rounded-lg" role="alert">{{ session('error') }}</div>
    @endif

    <form method="POST" class="space-y-6 animate-fadeIn" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Enter your email</label>
            <input type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 
            dark:text-white" name="email" required>
        </div>
        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Send Password Reset Link</button>
    </form>
</div>

@endsection
