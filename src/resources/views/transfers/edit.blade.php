@extends('layouts.dashing')

@section('title', __('transfers.edit.title'))
@section('header_title', __('transfers.edit.title'))

@section('content')
    <form action="{{ route('transfers.update', $transfer->id) }}" method="POST" id="editTransfer">
        @csrf
        @method('PUT')
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
                        <div class="px-4 py-5 sm:px-6">
                            <dl class="grid grid-cols-1 col-gap-4 row-gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.name'),
                                        'value' => $transfer->delivery_first_name,
                                        'input_id' => 'delivery_first_name',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.name'),
                                        'value' => $transfer->delivery_last_name,
                                        'input_id' => 'delivery_last_name',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="hidden sm:inline-flex col-span-1"></div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.email_address'),
                                        'value' => $transfer->delivery_email,
                                        'input_id' => 'delivery_email',
                                        'input_type' => 'email',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.phone_number'),
                                        'value' => $transfer->delivery_phone,
                                        'input_id' => 'delivery_phone',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="hidden sm:inline-flex col-span-1"></div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.line1'),
                                        'value' => $transfer->delivery_street_1,
                                        'input_id' => 'delivery_street_1',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.line2'),
                                        'value' => $transfer->delivery_street_2,
                                        'input_id' => 'delivery_street_2',
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.city'),
                                        'value' => $transfer->delivery_city,
                                        'input_id' => 'delivery_city',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.county'),
                                        'value' => $transfer->delivery_county,
                                        'input_id' => 'delivery_county',
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.postcode'),
                                        'value' => $transfer->delivery_postcode,
                                        'input_id' => 'delivery_postcode',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.country'),
                                        'value' => $transfer->delivery_country,
                                        'input_id' => 'delivery_country',
                                        'input_type' => 'select',
                                        'input_default_value' => 'United Kingdom',
                                        'input_default_id' => 'United Kingdom',
                                        'required' => true,
                                    ])
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
                                        'value' => $transfer->transfer_reason,
                                        'input_id' => 'transfer_reason',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('transfers.transfer_information.amount'),
                                        'value' => $transfer->transfer_amount,
                                        'input_id' => 'transfer_amount',
                                        'required' => true,
                                        'readonly' => true
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('transfers.transfer_information.charity'),
                                        'value' => $charity,
                                        'input_id' => 'charity_id',
                                        'required' => true,
                                        'readonly' => true
                                    ])
                                </div>
                                <div class="hidden sm:inline-flex col-span-1 lg:hidden"></div>
                                <div class="sm:col-span-3">
                                    @include('layouts.input_with_label', [
                                        'label' => __('transfers.transfer_information.context'),
                                        'value' => $transfer->transfer_note,
                                        'input_id' => 'transfer_note',
                                        'input_type' => 'textarea',
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

@section('footer_buttons')
    <a href="{{ route('transfers.show', $transfer->id) }}" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md bg-white hover:bg-red-500 focus:bg-red-500 text-md font-medium text-red-500 hover:text-white focus:text-white transition duration-150 ease-in-out">
        <span class="inline-flex">{{ __('common.cancel') }}</span>
    </a>
    <button type="submit" form="editTransfer" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md border-b-2 border-green-500 hover:border-green-700 focus:border-green-700 bg-white hover:bg-green-500 focus:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:text-white transition duration-150 ease-in-out">
        <span class="mr-2 hidden md:inline-flex">{{ __('transfers.update_transfer') }}</span>
        <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.update') }}</span>
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </button>
@endsection
