@extends('welcome')

@section('content')

@if($qrCode)
    <form method="GET" action="{{ route('qr.login') }}">
        @csrf
        <div class="qr-code">
            {!! QrCode::size(200)->generate(route('qr.login', ['code' => $qrCode->code])) !!}
        </div>
        <!-- Hidden input to store the QR code -->
        <input type="hidden" name="code" value="{{ $qrCode->code }}">
        <!-- Submit button -->
        {{-- <button type="submit" class="btn btn-primary">Submit QR Code</button> --}}
    </form>
@else
    <p>No QR code available.</p>
@endif

@endsection



