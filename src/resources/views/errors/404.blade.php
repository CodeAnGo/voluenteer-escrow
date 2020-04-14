@extends('layouts.dashing')

@section('title', 'Page not found')

@section('page_title')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="max-w-6xl mx-auto">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                        Page not found
                    </h2>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col pt-4">
                <div class="bg-white shadow overflow-hidden  sm:rounded-lg mt-4">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Unable to display the requested information
                        </h3>
                    </div>
                    <div class="px-4 py-5 sm:px-6">
                        <p class="mt-1 text-sm leading-5 text-gray-900">
                            If you have manually typed out the address, please check it is correct.
                        </p>
                        <p class="mt-1 text-sm leading-5 text-gray-900">
                            If you have manually pasted the address, please check you copied the entire address.
                        </p>
                        <br>
                        <p class="mt-1 text-sm leading-5 text-gray-900">
                            @auth
                                <a href="{{ route('dashboard') }}">Click here to return to your dashboard.</a>
                            @else
                                <a href="{{ route('home') }}">Click here to return to home.</a>
                            @endauth
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
