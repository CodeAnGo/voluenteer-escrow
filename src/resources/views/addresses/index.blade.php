@extends('layouts.dashing')

@section('title', __('addresses.index.title'))
@section('header_title', __('addresses.index.title'))
@section('header_sub_title', __('addresses.index.sub_title'))
@section('header_buttons')
    <a href="{{ route('addresses.create') }}" class="w-full inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green active:bg-green-700 transition duration-150 ease-in-out">
        <span class="hidden md:inline-flex">{{ __('addresses.create_address') }}</span>
        <span class="sm:inline-flex md:hidden">{{ __('common.create') }}</span>
    </a>
@endsection

@section('content')
    @each('addresses.show', $addresses, 'address', 'addresses.empty')
@endsection
