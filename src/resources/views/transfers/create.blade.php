@extends('layouts.dashing')

@section('title', 'Create a Transfer')
@section('header_title', __('transfers.create.title'))

@section('content')
    @livewire('create-transfer-calculation-component')
@endsection

@section('footer_buttons')
    <a href="{{ route('transfers.index') }}" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md bg-white hover:bg-red-500 focus:bg-red-500 text-md font-medium text-red-500 hover:text-white focus:text-white transition duration-150 ease-in-out">
        <span class="inline-flex">{{ __('common.cancel') }}</span>
    </a>
    <button type="submit" form="createTransfer" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md border-b-2 border-green-500 hover:border-green-700 focus:border-green-700 bg-white hover:bg-green-500 focus:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:text-white transition duration-150 ease-in-out">
        <span class="mr-2 hidden md:inline-flex">{{ __('transfers.create_transfer') }}</span>
        <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.create') }}</span>
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </button>
@endsection
