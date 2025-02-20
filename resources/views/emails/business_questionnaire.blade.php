@extends('welcome')

@section('content')

<h2>Business Questionnaire Details</h2>

    <p><strong>Business Name:</strong> {{ $questionnaire->business_name }}</p>
    <p><strong>Industry:</strong> {{ $questionnaire->industry }}</p>
    <p><strong>Website:</strong> <a href="{{ $questionnaire->website }}">{{ $questionnaire->website }}</a></p>
    <p><strong>Social Media:</strong> {{ $questionnaire->social_media }}</p>
    <p><strong>Contact Person:</strong> {{ $questionnaire->contact_person }}</p>
    <p><strong>Email:</strong> {{ $questionnaire->email }}</p>
    <p><strong>Phone:</strong> {{ $questionnaire->phone }}</p>
    <p><strong>ref:</strong> {{ $questionnaire->ref }}</p>

    <h3>Campaign Goals:</h3>
    @if(!empty($questionnaire->campaign_goals))
        <ul>
            @foreach ($questionnaire->campaign_goals as $goal)
                <li>{{ ucfirst(str_replace('_', ' ', $goal)) }}</li>
            @endforeach
        </ul>
    @else
        <p>No campaign goals specified.</p>
    @endif


    <h3>Brand Story:</h3>
    <p>{{ $questionnaire->brand_story }}</p>

<p>Thank you!</p>


@endsection