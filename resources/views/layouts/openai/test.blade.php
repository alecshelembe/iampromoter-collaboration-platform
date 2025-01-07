
@extends('welcome')

@section('content')
  
@include('layouts.navbar')  

<h1>Ask OpenAI</h1>
    <textarea id="prompt" rows="5" cols="50" placeholder="Type your prompt here..."></textarea>
    <br>
    <button id="generate">Generate</button>
    <h2>Response:</h2>
    <div id="response"></div>

    <script>
        $(document).ready(function () {
            $('#generate').on('click', function () {
                const prompt = $('#prompt').val();

                if (!prompt) {
                    alert('Please enter a prompt.');
                    return;
                }

                // Send AJAX request
                $.ajax({
                    url: '/generate', // Laravel route
                    type: 'POST',
                    data: {
                        prompt: prompt,
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function (response) {
                        $('#response').text(response.response);
                    },
                    error: function (xhr, status, error) {
                        $('#response').text('An error occurred: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>

@endsection
