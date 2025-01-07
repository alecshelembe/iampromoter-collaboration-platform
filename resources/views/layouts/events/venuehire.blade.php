@extends('welcome')

@include('layouts.navbar')

@section('content')
<p class="mb-3 mt-2 text-2xl">
    Sci-Bono Discovery Centre, Southern Africa’s largest and most visited science centre has also become one of its most sought after venues and destination of choice for unique corporate launches, events and conferences.
</p>
<h1 class="text-2xl my-4 font-bold dark:text-white">CONFERENCES, BANQUETES AND COCKTAIL PARTIES</h1>
<p class="mb-3">Situated in the arts and culture precinct of Newtown in one of Joburg’s historic buildings (originally intended as a power station), the centre has the capacity to host conferences of up to 500 people, banquets of up to 600 people and cocktail parties  for up to 1 000.
Ample and secure, parking is available at the venue itself but the Gautrain Station and bus stops are also nearby.</p>
<h1 class="text-2xl my-4 font-bold dark:text-white">TEAM BUILDING</h1>
<p class="mb-3">
    Our exciting team building program  offers the client both a full day and a half day option, with lunch. Team skill development activities such as Problem Solving (Puzzles - T or Tree, Handcuffs, Pack-A-Box, Nice Die), Communication (Me-Games/ Science of Soccer), Creative Thinking (Me-Games/ Science of Soccer), Teamwork & Delivering Under Pressure (Treasure Hunt) and Creative Thinking (Africa Map/ Me-Games) help to develop  attention to detail; logical Thinking; solution-focused deliverables; accountability & Responsibility; work-ethic; taking Initiative; working under pressure; people skills: confidence, relationships building and negotiation skills.
    All our programmes can be tailor made to suit the clients requirements and are guaranteed to energise and motivate
    your Team.
</p>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <div>
        <h1 class="text-3xl font-bold mb-6"></h1>
        <ul class="space-y-8">
            <a href="#" class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img class="object-contain w-full h-auto max-h-96 rounded-lg" src="{{ asset('storage/sci-bono-content/venue-hire.jpg') }}" >
                    <div class="p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Venue Hire</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> <strong>Description</strong> {{--description here --}}</p>
                    <p class="text-gray-700 mt-2">
                        {{-- <strong>Start Date</strong> {{ $event->start_date }} <br>
                        <strong>End Date</strong> {{ $event->end_date }} <br>
                        <strong>Activity</strong> {{ ucfirst($event->activity) }} <br>
                        <strong>Status</strong> {{ ucfirst($event->status) }} <br>
                        <strong>Audience</strong> {{ ucfirst($event->audience) }} --}}
                    </p>    
                </div>
            </a>
        </ul>
    </div>

    <div>
        <h1 class="text-3xl font-bold mb-6"></h1>
        <ul class="space-y-8">
            <a href="#" class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img class="object-contain w-full h-auto max-h-96 rounded-lg" src="{{ asset('storage/sci-bono-content/scibono-venues/classrooms-1.jpg') }}" >
                    <div class="p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Venue Hire</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> <strong>Description</strong> {{--description here --}}</p>
                    <p class="text-gray-700 mt-2">
                        {{-- <strong>Start Date</strong> {{ $event->start_date }} <br>
                        <strong>Audience</strong> {{ ucfirst($event->audience) }} --}}
                    </p>    
                </div>
            </a>
        </ul>
    </div>


    <div>
        <h1 class="text-3xl font-bold mb-6"></h1>
        <ul class="space-y-8">
            <a href="#" class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img class="object-contain w-full h-auto max-h-96 rounded-lg" src="{{ asset('storage/sci-bono-content/scibono-venues/events-3.jpg') }}" >
                    <div class="p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Venue Hire</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> <strong>Description</strong> {{--description here --}}</p>
                    <p class="text-gray-700 mt-2">
                        {{-- <strong>Start Date</strong> {{ $event->start_date }} <br>
                        <strong>Audience</strong> {{ ucfirst($event->audience) }} --}}
                    </p>    
                </div>
            </a>
        </ul>
    </div>

    <div>
        <h1 class="text-3xl font-bold mb-6"></h1>
        <ul class="space-y-8">
            <a href="#" class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img class="object-contain w-full h-auto max-h-96 rounded-lg" src="{{ asset('storage/sci-bono-content/scibono-venues/events-4.jpg') }}" >
                    <div class="p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Venue Hire</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> <strong>Description</strong> {{--description here --}}</p>
                    <p class="text-gray-700 mt-2">
                        {{-- <strong>Start Date</strong> {{ $event->start_date }} <br>
                        <strong>Audience</strong> {{ ucfirst($event->audience) }} --}}
                    </p>    
                </div>
            </a>
        </ul>
    </div>


    <div>
        <h1 class="text-3xl font-bold mb-6"></h1>
        <ul class="space-y-8">
            <a href="#" class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img class="object-contain w-full h-auto max-h-96 rounded-lg" src="{{ asset('storage/sci-bono-content/scibono-venues/ict.jpg') }}" >
                    <div class="p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Venue Hire</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> <strong>Description</strong> {{--description here --}}</p>
                    <p class="text-gray-700 mt-2">
                        {{-- <strong>Start Date</strong> {{ $event->start_date }} <br>
                        <strong>Audience</strong> {{ ucfirst($event->audience) }} --}}
                    </p>    
                </div>
            </a>
        </ul>
    </div>


    <div>
        <h1 class="text-3xl font-bold mb-6"></h1>
        <ul class="space-y-8">
            <a href="#" class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img class="object-contain w-full h-auto max-h-96 rounded-lg" src="{{ asset('storage/sci-bono-content/scibono-venues/venue-hire-1.jpg') }}" >
                    <div class="p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Venue Hire</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> <strong>Description</strong> {{--description here --}}</p>
                    <p class="text-gray-700 mt-2">
                        {{-- <strong>Start Date</strong> {{ $event->start_date }} <br>
                        <strong>Audience</strong> {{ ucfirst($event->audience) }} --}}
                    </p>    
                </div>
            </a>
        </ul>
    </div>

    <div>
        <h1 class="text-3xl font-bold mb-6"></h1>
        <ul class="space-y-8">
            <a href="#" class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img class="object-contain w-full h-auto max-h-96 rounded-lg" src="{{ asset('storage/sci-bono-content/scibono-venues/venue-hire-2.jpg') }}" >
                    <div class="p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Venue Hire</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> <strong>Description</strong> {{--description here --}}</p>
                    <p class="text-gray-700 mt-2">
                        {{-- <strong>Start Date</strong> {{ $event->start_date }} <br>
                        <strong>Audience</strong> {{ ucfirst($event->audience) }} --}}
                    </p>    
                </div>
            </a>
        </ul>
    </div>

    <div>
        <h1 class="text-3xl font-bold mb-6"></h1>
        <ul class="space-y-8">
            <a href="#" class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img class="object-contain w-full h-auto max-h-96 rounded-lg" src="{{ asset('storage/sci-bono-content/scibono-venues/venue-hire-3.jpg') }}" >
                    <div class="p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Venue Hire</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> <strong>Description</strong> {{--description here --}}</p>
                    <p class="text-gray-700 mt-2">
                        {{-- <strong>Start Date</strong> {{ $event->start_date }} <br>
                        <strong>Audience</strong> {{ ucfirst($event->audience) }} --}}
                    </p>    
                </div>
            </a>
        </ul>
    </div>
</div>
<h5 class="text-xl mt-4 font-semibold tracking-tight text-gray-900 dark:text-white">Experience world class corporate and education venues</h5>

@endsection


