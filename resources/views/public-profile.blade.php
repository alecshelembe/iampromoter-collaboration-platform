@extends('welcome')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg"> 
    <h1 class="text-xl font-medium mb-4"></h1>
    <div class="">
        
        @if (!$user)
            <p class="text-gray-600 col-span-4 text-center">No user found.</p>
        @else
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-col items-center pb-6">
                    
                <img 
                        loading="lazy"
                        style="width: 150px; height: 150px; border-radius: 50%;" 
                        class="mx-auto object-cover shadow-md m-2"  
                        src="{{ $user->profile_image_url ? Storage::url($user->profile_image_url) : asset('images/default-avatar.png') }}" 
                        alt="{{ $user->first_name }}'s image"
                    />


                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </h5>
                    
                    <h5 class="text-gray-600 text-center dark:text-gray-400 mt-2 text-sm">
                        {{ $user->email }}
                    </h5>

                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $user->position ?? 'User' }}
                    </span>

                    <p class="text-gray-600 text-center dark:text-gray-400 mt-2 text-sm">
                        {{ $user->google_location ?? 'No location available' }}
                    </p>

                    <div class="flex flex-wrap justify-center mt-4 space-x-2">
                        @foreach (['instagram', 'linkedin', 'tiktok', 'youtube', 'x', 'other'] as $platform)
                            @php
                                $handle = $user->{$platform . '_handle'};
                            @endphp
                            @if (!empty($handle))
                                <a href="{{ Str::startsWith($handle, 'http') ? $handle : 'https://' . $handle }}" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="py-2 px-3 text-sm font-medium bg-white hover:bg-blue-100 hover:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    <i class="fa-brands fa-{{ $platform === 'x' ? 'x-twitter' : $platform }}"></i> 
                                    {{ ucfirst($platform) }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
        @endif

    </div>
</div>
@endsection
