

<nav class="sticky top-0 z-50 
bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
    <div class="w-full flex flex-wrap items-center justify-between mx-auto p-4">
      <a  href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
          <img src={{ config('services.project.logo_image') }} class="h-14" alt="Flowbite Logo" />
          <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Development</span>
      </a>
      <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-dropdown" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
      </button>
      <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
        <ul class="Scibono-background flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
          {{-- <li>
            <a href="#" c>Services</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Pricing</a>
          </li>--}}
          <li>
            <!-- Payment Status Banner -->
            @if(session()->has('payment_status') && session('payment_status') )
                <div class="bg-green-300 text-center p-2">
                    C # {{ session('payment_status') }} <a href='https://discord.gg/BRqsTrza' class="underline" target="_blank">Join our discord</a>
                </div>
            @else
                
            @endif

            @if (session('success'))
                <div class="bg-green-300 text-center p-2">
                    <p class="mx-auto" style="background-coloer:#f5f5f5; color: green;"> {!! session('success') !!}</p>
                </div>
            @endif
            @if(session('exists'))
                <div class="bg-green-300 text-center p-2">
                    <p class="mx-auto" style="background-coloer:#f5f5f5; color: green;"> {!! session('exists') !!}</p>
                </div>
                @endif
          </li> 
          <li>
            <li>
              <button id="dropdownNavbarLink_social" data-dropdown-toggle="dropdownNavbar_social" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">Media  <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
              </button>
              <!-- Dropdown menu -->
              <div id="dropdownNavbar_social" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                  <ul class="py-2 text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                    <li>
                      <a href="{{ route('social.view.posts') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        <!-- Plus icon -->
                        <span class="">Media posts</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('science.posts') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        <!-- Plus icon -->
                        <span class="">Info posts</span>
                      </a>
                      <a href="{{ route('layouts.search') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        <!-- Plus icon -->
                        <span class="">Search with text</span>
                      </a>
                       <a href="{{ route('landing') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        <!-- Plus icon -->
                        <span class="">Search address</span>
                      </a>
                    </li>
                  </ul>
              </div>
        
          <li>
              <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">Create <a href="{{ route('create.mobile.post') }}" class="fixed bottom-5 right-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </a>
              </button>
              <!-- Dropdown menu -->
              <div id="dropdownNavbar" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                  <ul class="py-2 text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                    <li>
                      <a href="{{ route('create.mobile.post') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        <!-- Plus icon -->
                        <span class="">Create a post</span>
                    </a>
                    </li>
                    <li>
                      <a href="{{ route('login.qrcode') }}" class="  block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        <!-- Plus icon -->
                        Influencer campaign 
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('my.profile') }}" class="  block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        <!-- Plus icon -->
                        Become an influencer 
                      </a>
                    </li> 
                  </ul>
                  <div class="py-1">
                    {{-- <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a> --}}
                  </div>
              </div>
          </li>

          <li>
            <!-- Dropdown menu -->
            <div id="dropdownNavbar_Bookings" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
              <ul class="py-2 text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                
                </ul>
                <div class="py-1">
                  {{-- <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a> --}}
                </div>
            </div>
        </li>
          <li>
          </li>
          <li>
          <button id="dropdownNavbarLink_Settings" data-dropdown-toggle="dropdownNavbar_Settings" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">Settings  <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
            </button>
            <!-- Dropdown menu -->
            <div id="dropdownNavbar_Settings" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                   
                  <li>
                    <a href="{{ route('public.user.posts', ['email' => auth()->user()->email]) }}" class=" block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        <!-- Plus icon -->
                        My posts
                    </a>
                </li>
                  <li>
                    <a href="{{ route('my.profile') }}" class=" block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        <!-- Plus icon -->
                        My profile
                    </a>
                </li>
                <li>
                  <a href="{{ route('my.posts') }}" class=" block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                      <!-- Plus icon -->
                     My uploads
                  </a>
              </li>
                  <li>
                      <a href="{{ route('users.create.ref') }}" class=" block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                          <!-- Plus icon -->
                          Create ref
                      </a>
                  </li>
                    <li>
                      <a href="{{ route('users.logout') }}" class=" block py-2 px-3 text-gray-900 rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                          <!-- Plus icon -->
                          <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                      </a>
                  </li>
                </ul>
                <div class="py-1">
                  {{-- <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a> --}}
                </div>
            </div>
            
          </li>
          
        </ul>
      </div>
    </div>
   
  </nav>
  
  