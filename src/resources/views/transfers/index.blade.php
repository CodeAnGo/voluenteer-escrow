@extends('layouts.dashing')

@section('header_title', __('transfers.index.title'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col pt-4">
                <div class="flex flex-row justify-between items-center mb-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-800 p-4">
                        Active transfers
                    </h3>

                @if (!Auth::user()->volunteer)
                    <a href="{{ route('transfers.create') }}" class="ml-2 inline-flex items-center justify-center py-2 px-4 rounded shadow-md border-b-2 border-green-500 hover:border-green-700 focus:border-green-700 bg-white hover:bg-green-500 focus:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:text-white transition duration-150 ease-in-out">
                        <span class="mr-2 hidden md:inline-flex">{{ __('transfers.create_transfer') }}</span>
                        <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.create') }}</span>
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                            <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </a>
                        @endif
                </div>

                @livewire('active-transfers-component')
            </div>
            <div class="flex flex-col pt-4">
                <h3 class="text-lg leading-6 font-medium text-gray-800 p-4">
                    All transfers
                </h3>

                @livewire('all-transfers-component')
            </div>
    </div>
@endsection
