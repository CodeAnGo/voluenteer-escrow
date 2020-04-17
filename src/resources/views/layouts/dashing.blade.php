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

<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.0.1/dist/alpine.js" defer></script>

<div class="min-h-screen bg-gray-100">
    <nav x-data="{ open: false }" class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="lg:block h-8 w-auto" src="{{ asset('img/netcompany.63c83485.svg') }}" alt="Workflow logo" />
                    </div>
                    <div class="hidden sm:ml-6 sm:flex">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'dashboard') border-indigo-500 text-gray-900 @else border-transparent @endif text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                                {{ __('navigation.dashboard') }}
                            </a>
                            <a href="{{ route('transfers.index') }}" class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 @if(Illuminate\Support\Facades\Route::currentRouteName() == 'transfers.index') border-indigo-500 text-gray-900 @else border-transparent @endif text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                                {{ __('navigation.transfers') }}
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2">
                                {{ __('navigation.home') }}
                            </a>
                        @endauth
                    </div>
                </div>
                @auth
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
                            <button @click="open = !open" class="inline-flex items-center px-2 pt-2 text-md font-medium focus:outline-none transition duration-150 ease-in-out">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" class="w-8 h-8 text-gray-500 hover:text-gray-600" viewBox="0 0 24 24">
                                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-48 mt-2 origin-top-right">
                                <div class="rounded-md bg-white shadow-xs">
                                    <div class="py-1 sm:hidden border-b">
                                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">{{ __('navigation.dashboard') }}</a>
                                        <a href="{{ route('transfers.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">{{ __('navigation.transfers') }}</a>
                                    </div>
                                    <div class="py-1">
                                        <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">{{ __('navigation.profile') }}</a>
                                        <a href="{{ route('addresses.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">{{ __('navigation.addresses') }}</a>
                                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('navigation.logout') }}</a>
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

    <div class="py-10">
        <header>
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                    <div class="max-w-6xl mx-auto">
                        <div class="flex flex-col sm:flex-row py-2 sm:py-0 justify-between sm:items-center">
                            <div class="flex-1 min-w-0">
                                <h1 class="ml-4 text-3xl font-bold leading-tight text-gray-900">
                                    @yield('header_title')
                                </h1>
                                <div class="ml-4 flex items-center text-sm leading-5 text-gray-600 sm:mr-6">
                                    @yield('header_sub_title')
                                </div>
                            </div>

                            <div class="ml-2 mr-4 rounded-md flex flex-row justify-end">
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
            </div>
        </main>
    </div>
</div>
</body>
@stack('js')
</html>
