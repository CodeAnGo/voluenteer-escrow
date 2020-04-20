@extends('layouts.dashing')

@section('title', __('addresses.index.title'))
@section('header_title', __('addresses.index.title'))
@section('header_sub_title', __('addresses.index.sub_title'))
@section('header_buttons')
    <a href="{{ route('addresses.create') }}" class="ml-2 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-green-500 hover:border-green-700 bg-white hover:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
        <span class="mr-2 hidden md:inline-flex">{{ __('addresses.create_address') }}</span>
        <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.create') }}</span>
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
            <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </a>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if($addresses->count() !== 0)
            <div class="max-w-6xl mx-auto grid grid-cols-1 col-gap-4 row-gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @each('addresses.show', $addresses, 'address')
            </div>
        @else
            <div class="max-w-6xl mx-auto flex justify-center">
                <span class="rounded bg-white shadow-sm px-4 py-4">{{ __('addresses.no_saved_addresses') }}</span>
            </div>
        @endif
    </div>
@endsection
