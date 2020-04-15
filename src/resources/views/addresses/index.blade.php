@extends('layouts.dashing')

@section('title', 'Your Addresses')

@section('page_title')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                        Your Addresses
                    </h2>
                    <div class="flex items-center text-sm leading-5 text-gray-500 sm:mr-6">
                        Save addresses to create new transfers with ease
                    </div>
                </div>
                <div class="ml-3 shadow-sm rounded-md">
                    <a href="{{ route('addresses.create') }}" class="w-full inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green active:bg-green-700 transition duration-150 ease-in-out">
                        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                        <span class="hidden md:inline-flex">Create Address</span>
                        <span class="hidden sm:inline-flex md:hidden">Create</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @each('addresses.show', $addresses, 'address', 'addresses.empty')
@endsection
