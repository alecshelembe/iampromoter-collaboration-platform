@extends('welcome')

@section('content')

<h1>Transaction Details</h1>
<p><strong>Transaction ID:</strong> {{ $data['m_payment_id'] }}</p>
<p><strong>Item:</strong> {{ $data['item_name'] }}</p>
<p><strong>Address:</strong> {{ $data['item_description'] }}</p>
<p><strong>Amount:</strong> {{ $data['amount'] }}</p>
<p><strong>Payment Status:</strong> {{ $data['payment_status'] }}</p>
<p><strong>Phone:</strong> {{ $data['cell_number'] }}</p>
<p><strong>Name:</strong> {{ $data['name_first'] }}</p>
<p><strong>Lastname:</strong> {{ $data['name_last'] }}</p>
<p><strong>Recipient:</strong> {{ $data['email_address'] }}</p>
<p>
    <strong>Profile:</strong> 
    <a href="{{ url('/my-public-profile/' . $data['email_address']) }}" target="_blank">
        View Public Profile
    </a>
</p>
<p><strong>Contact:</strong> {{ $data['email'] }}</p>


@endsection
