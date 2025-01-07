@extends('welcome')

@section('content')
<audio controls>
    <source src="{{ $audioUrl }}" type="audio/wav">
    Your browser does not support the audio tag.
</audio>

@endsection
