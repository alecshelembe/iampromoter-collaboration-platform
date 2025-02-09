@extends('welcome')

@section('content')

<h1>Transaction Details</h1>
<p><strong>Transaction ID:</strong> {{ $data['m_payment_id'] }}</p>
<p><strong>Item:</strong> {{ $data['item_name'] }}</p>
<p><strong>Description:</strong> {{ $data['item_description'] }}</p>
<p><strong>Amount:</strong> {{ $data['amount'] }}</p>
<p><strong>Payment Status:</strong> {{ $data['payment_status'] }}</p>
<p><strong>Contact:</strong> {{ $data['cell_number'] }}</p>
<p><strong>Name:</strong> {{ $data['name_first'] }}</p>
<p><strong>Lastname:</strong> {{ $data['name_last'] }}</p>

<p><strong>Recipient:</strong> {{ $data['email_address'] }}</p>
<p><strong>Host:</strong> {{ $data['email'] }}</p>

@endsection
