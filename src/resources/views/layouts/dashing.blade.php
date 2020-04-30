<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @if(View::hasSection('title'))
            @yield('title') - {{ config('app.name') }}
        @else
            {{ config('app.name') }}
        @endif
    </title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
@stack('fonts')
@livewireStyles

<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('css')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.0.1/dist/alpine.js" defer></script>

<div class="min-h-screen bg-gray-100">
    <nav x-data="{ open: false }" class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="lg:block h-8 w-auto" src="{{ asset('img/netcompany.63c83485.svg') }}" alt="Workflow logo" />
                    </div>
                    <div class="hidden sm:ml-6 sm:flex">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'dashboard') border-indigo-500 text-gray-900 @else border-transparent @endif text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:border-gray-300 transition duration-150 ease-in-out">
                                {{ __('navigation.dashboard') }}
                            </a>
                            <a href="{{ route('transfers.index') }}" class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 @if(Illuminate\Support\Facades\Route::currentRouteName() == 'transfers.index') border-indigo-500 text-gray-900 @else border-transparent @endif text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:border-gray-300 transition duration-150 ease-in-out">
                                {{ __('navigation.transfers') }}
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 @if(Illuminate\Support\Facades\Route::currentRouteName() == 'home') border-indigo-500 text-gray-900 @else border-transparent @endif text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:border-gray-300 transition duration-150 ease-in-out">
                                {{ __('navigation.home') }}
                            </a>
                        @endauth
                    </div>
                </div>
                @auth
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">

                        <div @click.away="open = false" class="relative px-4" x-data="{ open: false }">
                            <button @click="open = !open" class="inline-flex items-center px-2 pt-2 text-md font-medium focus:outline-none transition duration-150 ease-in-out">
                                @if(count(Auth::user()->notifications) > 0)
                                    <svg width="30" height="30" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"  class="fill-current text-red-700 hover:text-red-600 " ><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                                @else
                                    <svg width="30" height="30" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"  class="fill-current  text-gray-700 hover:text-gray-600" ><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                                @endif
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-48 mt-2 origin-top-right z-50">
                                <div class="rounded-md bg-white shadow-xs">
                                    <div class="py-1">
                                        @forelse(Auth::user()->notifications as $notification)
                                            <a href="{{route('notification.delete', $notification['transfer_id'])}}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Transfer {{ $notification->status }}, click here to view</a>
                                        @empty
                                            <p class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">You're up to date</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>


                        @isset($balance)
                        <a href="" class="text-gray-700 pr-2">
                            Account Balance £ 
                        </a>
                        @endisset
                        <div @click.away="open = false" class="ml-3 relative border-b-2 @if(in_array(\Illuminate\Support\Facades\Route::currentRouteName(), ['profile.index', 'profile.edit', 'addresses.index', 'addresses.create', 'addresses.edit'])) border-indigo-500 text-gray-900 @else border-transparent @endif text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out" x-data="{ open: false }">
                            <div>
                    <div class="flex items-center">
                        @isset($balance)
                            <div class="ml-2 sm:ml-6 flex items-center">
                                <a href="#" class="text-gray-700 pr-2">
                                    <span class="hidden sm:inline-flex">{{ __('common.balance') }} </span>
                                    £ {{ $balance }}
                                </a>

                            </div>
                        @endisset
                        <div @click.away="open = false" class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="inline-flex items-center px-2 py-2 text-md font-medium text-gray-500 hover:text-gray-600 focus:text-gray-600 transition duration-150 ease-in-out">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" class="w-8 h-8" viewBox="0 0 24 24">
                                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                <span class="sr-only">Menu</span>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-48 mt-2 origin-top-right z-50">
                                <div class="rounded-md bg-white shadow-xs">
                                    <div class="py-1 sm:hidden border-b">
                                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out">{{ __('navigation.dashboard') }}</a>
                                        <a href="{{ route('transfers.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out">{{ __('navigation.transfers') }}</a>
                                    </div>
                                    <div class="py-1">
                                        <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out">{{ __('navigation.profile') }}</a>
                                        <a href="{{ route('addresses.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out">{{ __('navigation.addresses') }}</a>
                                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('navigation.logout') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="py-6 shadow-inner">
        <header>
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                    <div class="max-w-6xl mx-auto">
                        <div class="flex flex-col sm:flex-row sm:py-0 justify-between sm:items-center">
                            <div class="flex-1 min-w-0">
                                <h1 class="ml-4 text-3xl font-bold leading-tight text-gray-900">
                                    @yield('header_title')
                                </h1>
                                <div class="ml-4 flex items-center text-sm leading-5 text-gray-600 sm:mr-6">
                                    @yield('header_sub_title')
                                </div>
                            </div>

                            <div class="mx-2 mt-2 sm:mt-0 sm:mx-4 rounded-md flex flex-row justify-end">
                                @yield('header_buttons')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @yield('content')
                <div class="max-w-6xl mx-auto px-4 mt-4">
                    <div class="rounded-md flex flex-row justify-end">
                        @yield('footer_buttons')
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<div>
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-center text-center text-base leading-6 text-gray-500">
                <div class="flex flex-col sm:flex-row justify-center mt-4">
                    <a href="#" class="mx-4 my-1 text-blue-600 hover:text-blue-800">Accessibility</a>
                    <a href="#" class="mx-4 my-1 text-blue-600 hover:text-blue-800">Cookie Policy</a>
                    <a href="#" class="mx-4 my-1 text-blue-600 hover:text-blue-800">Privacy Policy</a>
                </div>
                <span class="mt-2 mb-4">
                    &copy; 2020 Netcompany, A/S. All rights reserved.
                </span>
            </div>
        </div>
    </footer>
</div>
</body>
@stack('js')
@livewireScripts
</html>
