<div class="card-overlay">
    @php $images = json_decode($post->images, true); @endphp
    @if (is_array($images) && count($images) > 0)
        <div class="grid grid-cols-2 gap-2 mb-2">
            @foreach ($images as $image)
                <figure class="relative">
                    <img class="rounded-lg cursor-pointer" src="{{ asset($image) }}" alt="Post image" loading="lazy">
                </figure>
            @endforeach
        </div>
    @endif
    <div class="flex items-center space-x-3">
        <img 
            src="{{ $post->profile_image_url ? Storage::url($post->profile_image_url) : asset('default-profile.png') }}" 
            alt="Profile Image" 
            loading="lazy"
            style="width: 50px; height: 50px; border-radius: 50%;" 
            class="object-cover shadow-md" 
        />
        <div class="flex-1">
            <p class="text-sm font-bold">{{ $post->place_name }}</p>
            <p class="text-sm font-semibold text-grey-500">R {{ $post->fee }}</p>
            <p class="text-sm text-gray-700">{{ $post->address }}</p>
            <p class="text-xs text-gray-400">Posted by {{ $post->author }}</p>
            @if (!empty($post->note))
                <div class="flex flex-col leading-1.5 p-2 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700 mt-1">
                    <p class="text-sm font-normal text-gray-900 dark:text-white" title="{{ $post->note }}"> 
                        {{ Str::limit($post->note, 25) }}
                    </p>
                </div>
            @endif
            <p class="text-xs text-gray-400">{{ $post->formatted_time }}</p>
        </div>
        <div>
            @if(Auth::check())
                <a href="{{ route('social.view.post', ['id' => $post->id]) }}" class="p-2 text-sm rounded-full shadow-lg bg-blue-600 text-white">View</a>
            @elseif(Auth::guard('google_users')->check())
                <a href="{{ route('google.social.view.post', ['id' => $post->id]) }}" class="p-2 text-sm rounded-full shadow-lg bg-blue-600 text-white">View</a>
            @else
                <a href="{{ route('social.view.post', ['id' => $post->id]) }}" class="p-2 text-sm bg-blue-500 text-white rounded-full shadow-lg hover:bg-green-600">Login</a>
            @endif
        </div>
    </div>
</div>
