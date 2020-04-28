@extends('layouts.dashing')

@section('title', 'Create a Transfer')
@section('header_title', __('transfers.create.title'))

@section('content')
    <form action="{{ route('transfers.store') }}" method="POST" id="createTransfer" enctype="multipart/form-data">
        @csrf
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="max-w-6xl mx-auto grid grid-cols-1 col-gap-4 row-gap-4 sm:grid-cols-1">
                <div class="flex flex-col">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg h-full">
                        <div class="px-4 py-3 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('transfers.delivery_information') }}
                            </h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ __('transfers.delivery_information_sub_title') }}
                            </p>
                        </div>
                        <div class="px-4 py-3 sm:px-6">
                            <dl class="grid grid-cols-1 col-gap-4 row-gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.first_name'),
                                        'value' => Auth::user()->first_name,
                                        'input_id' => 'delivery_first_name',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.last_name'),
                                        'value' => Auth::user()->last_name,
                                        'input_id' => 'delivery_last_name',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.email_address'),
                                        'value' => Auth::user()->email,
                                        'input_id' => 'delivery_email',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.phone_number'),
                                        'value' => Auth::user()->phone,
                                        'input_id' => 'delivery_phone',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="col-span-1 sm:col-span-2 lg:col-span-4">
                                    <div>
                                        <label class="block text-sm font-medium leading-5 text-gray-500">Address:</label>
                                        <select name="user_address_select" id="user_address_checkbox" class="mt-1 block form-select w-full py-2 px-3 py-0 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                            @if(isset($addresses) && $addresses->count() === 0)
                                                <option value="">{{ __('addresses.no_saved_addresses') }}</option>
                                            @endif

                                            @foreach($addresses as $address)
                                                <option value="{{$address->id}}">{{$address->line1}}@if(isset($address->line2)){{", " . $address->line2}}@endif{{", " . $address->city}}@if(isset($address->county)){{", " . $address->county}}@endif{{", " . $address->postcode}}</option>
                                            @endforeach
                                        </select>
                                        @error('user_address_select')
                                        <div>
                                            <p class="text-red-600 text-sm tracking-wide font-light">
                                                Please provide an address, you can add a new one or select one from the dropdown.
                                            </p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-row justify-end">
                                        <a href="{{ route('addresses.create') }}" class="mt-2 inline-flex items-center justify-center py-2 px-4 text-md font-medium text-indigo-500 hover:text-indigo-700 focus:text-indigo-700 transition duration-150 ease-in-out">
                                            <span class="mr-2 hidden md:inline-flex">{{ __('addresses.create_address') }}</span>
                                            <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.create') }}</span>
                                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                                <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg h-full">
                        <div class="px-4 py-3 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('transfers.transfer_information') }}
                            </h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ __('transfers.transfer_information_sub_title') }}
                            </p>
                        </div>
                        <div class="px-4 py-5 sm:px-6">
                            <dl class="grid grid-cols-1 col-gap-4 row-gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('transfers.transfer_information.reason'),
                                        'value' => old('transfer_reason') ??  '',
                                        'input_id' => 'transfer_reason',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('transfers.transfer_information.amount'),
                                        'value' => old('transfer_amount') ??  '',
                                        'input_id' => 'transfer_amount',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('transfers.transfer_information.charity'),
                                        'value' => old('charity_id') ??  '',
                                        'input_id' => 'charity_id',
                                        'input_type' => 'select',
                                        'input_items' => $charities,
                                        'input_default_value' => '-',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="hidden sm:inline-flex col-span-1 lg:hidden"></div>
                                <div class="sm:col-span-3">
                                    @include('layouts.input_with_label', [
                                        'label' => __('transfers.transfer_information.context'),
                                        'value' => old('transfer_note') ??  '',
                                        'input_id' => 'transfer_note',
                                        'input_type' => 'textarea',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('transfers.transfer_information.images'),
                                        'value' => old('images[]') ??  '',
                                        'input_id' => 'images[]',
                                        'required' => false,
                                        'input_type' => 'file',
                                        'multiple' => true
                                    ])
                                    @error('images.*')
                                    <div>
                                        <p class="text-red-600 text-sm tracking-wide font-light">
                                            The attached Evidence must be an image.
                                        </p>
                                    </div>
                                    @enderror
                                    <p class="mt-1 text-sm leading-5 text-gray-500">
                                        {{ __('transfers.transfer_information.images_sub_text') }}
                                    </p>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
