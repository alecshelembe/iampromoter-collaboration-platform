@extends('welcome')

@include('layouts.navbar')  

@section('content')
    
    <div class="flex justify-end my-2">
        <button id="toggleView" class="px-4 py-2 text-white bg-blue-500 rounded-lg">
            <i class="fa-regular fa-eye"></i> 
        </button>
    </div>
    {{-- Total Fee and Checkout Button --}}
    @if (count($results) > 0)
        <div class="flex justify-center">
            <button class="bg-gradient-to-r from-purple-600 to-pink-500 hover:from-pink-500 hover:to-purple-600 text-white py-2 px-4 rounded-full shadow-lg transform transition-all duration-300 hover:scale-105 flex items-center gap-2">
                <h2>
                    R <span id="totalFee">{{ number_format($totalFee, 2) }}</span>
                </h2>
                <i class="fa-solid fa-fire-flame-curved"></i> Proceed to Checkout!
            </button>
        </div>
    @endif

    <div id="postContainer" class="grid grid-cols-2 gap-4 mt-4 lg:grid-cols-4">
        @foreach ($results as $post)
            <div class="p-2 bg-white" data-fee="{{ $post->fee }}">
                <div class="grid grid-cols-2 gap-2">
                    {{-- Parse and display images --}}
                    @php
                        $images = json_decode($post->images, true); // Decode JSON
                    @endphp

                    @if (is_array($images) && count($images) > 0)
                        @foreach ($images as $image)
                            <figure class="max-w-lg relative">
                                <img class="h-auto max-w-full rounded-lg cursor-pointer"
                                    src="{{ asset($image) }}"
                                    alt="Post image"
                                    loading="lazy">
                            </figure>
                        @endforeach
                    @else
                        <p>No images found.</p>
                    @endif
                </div>

                {{-- Display post description and email --}}
                <div class="mt-4">

                    <p class="text-sm text-gray-700 ">{{ $post->place_name }}</p>
                    <p class="text-sm text-grey-500">R {{ $post->fee }}</p>
                    <!-- <p class="text-sm text-gray-700">{{ $post->address }}</p> -->

                    <div>
                        <button type="button"
                                class="remove-from-cart-btn p-2 text-sm rounded-full shadow-lg"
                                data-post-id="{{ $post->id }}">
                            Remove
                        </button>
                    </div>
                </div>
            </div> {{-- End of post card --}}
        @endforeach
    </div> {{-- End of post container --}}

   <script>
    const toggleButton = document.getElementById('toggleView');
    const postContainer = document.getElementById('postContainer');
    let isGrid = true;

    toggleButton.addEventListener('click', function() {
        if (isGrid) {
            postContainer.classList.remove('grid', 'grid-cols-2', 'lg:grid-cols-4');
            postContainer.classList.add('flex', 'flex-col');
        } else {
            postContainer.classList.remove('flex', 'flex-col');
            postContainer.classList.add('grid', 'grid-cols-2', 'lg:grid-cols-4');
        }
        isGrid = !isGrid;
    });

    document.addEventListener('DOMContentLoaded', function() {
        const removeButtons = document.querySelectorAll('.remove-from-cart-btn');
        const totalFeeSpan = document.getElementById('totalFee');

        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.dataset.postId;
                const postCard = this.closest('.p-2.bg-white');
                const url = `/remove-from-cart/${postId}`;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (postCard) {
                            const fee = parseFloat(postCard.dataset.fee) || 0;
                            const currentTotal = parseFloat(totalFeeSpan.textContent.replace(/,/g, '')) || 0;
                            const newTotal = Math.max(currentTotal - fee, 0).toFixed(2);

                            totalFeeSpan.textContent = newTotal;

                            postCard.remove();
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while removing the item.');
                });
            });
        });
    });
</script>



@endsection