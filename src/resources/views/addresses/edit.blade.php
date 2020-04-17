@extends('layouts.dashing')

@section('title', __('addresses.edit.title'))
@section('header_title', __('addresses.edit.title'))
@section('header_buttons')
    <a href="{{ route('addresses.index') }}" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg bg-white hover:bg-red-500 text-md font-medium text-red-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
        <span class="inline-flex">{{ __('common.cancel') }}</span>
    </a>
    <button type="submit" form="editAddress" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-green-500 hover:border-green-700 bg-white hover:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
        <span class="mr-2 hidden md:inline-flex">{{ __('addresses.save_address') }}</span>
        <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.save') }}</span>
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </button>
@endsection

@section('content')
    <form action="{{ route('addresses.update', $address->id) }}" method="POST" id="editAddress">
        @csrf
        @method('PUT')
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="max-w-6xl mx-auto grid grid-cols-1 col-gap-4 row-gap-4 sm:grid-cols-1">
                <div class="flex flex-col sm:col-span-3">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg h-full">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('addresses.address_details') }}
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:px-6">
                            <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2 lg:grid-cols-3">
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.name'),
                                        'value' => $address->name,
                                        'input_id' => 'name',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.email_address'),
                                        'value' => $address->email,
                                        'input_id' => 'email',
                                        'input_type' => 'email',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="hidden lg:inline-flex lg:col-span-1"></div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.line1'),
                                        'value' => $address->line1,
                                        'input_id' => 'line1',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.line2'),
                                        'value' => $address->line2,
                                        'input_id' => 'line2',
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.city'),
                                        'value' => $address->city,
                                        'input_id' => 'city',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.county'),
                                        'value' => $address->county,
                                        'input_id' => 'county',
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.postcode'),
                                        'value' => $address->postcode,
                                        'input_id' => 'postcode',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.country'),
                                        'value' => $address->country,
                                        'input_id' => 'country',
                                        'required' => true,
                                    ])
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
