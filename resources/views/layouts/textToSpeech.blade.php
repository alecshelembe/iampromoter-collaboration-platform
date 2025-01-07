@extends('welcome')

@section('content')
    <div class="container mx-auto mt-8">
        <form action={{ route('returnSpeech') }} method="POST">
            @csrf
            <input type="text" name="audio_id" value="<?php echo(rand());?>" hidden>
            <textarea name="text" rows="4" placeholder="Enter text here"></textarea>
            <button type="submit">Generate Speech</button>
        </form>
        
        <audio controls id="audioPlayer" style="display:none;">
            <source id="audioSource" type="audio/wav">
        </audio>
    </div>
@endsection
