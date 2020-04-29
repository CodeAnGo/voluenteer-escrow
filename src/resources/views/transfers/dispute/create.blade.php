@extends('layouts.dashing')

@section('title', 'Transfer Dispute')

@section('header_title')
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
            {{ $transfer->transfer_reason }}
        </h2>
    </div>
@endsection

@section('content')
    <form action="{{ route('transfers.dispute.store', $transfer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-col">
                    <div class="hidden sm:block">
                        <div class="sm:py-1 md:py-1 lg:py-5">
                            <div class="border-t border-gray-200"></div>
                        </div>
                    </div>
                    <div class="mt-10 sm:mt-0">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                                        Dispute Transfer
                                    </h3>
                                    <p class="mt-1 text-sm leading-5 text-gray-500">
                                        Please provide your reason for raising a dispute, as well as any supporting evidence to the claim.
                                        This will be used by your selected charity to resolve the dispute.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="dispute_reason"
                                                       class="block text-sm font-medium leading-5 text-gray-700">
                                                    Reason for disputing.
                                                </label>
                                                <textarea
                                                    placeholder="E.g., Goods weren't delivered."
                                                    name="dispute_reason" required maxlength="255"
                                                    class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"></textarea>
                                           @error('dispute_reason')
                                                <div>
                                                    <p class="text-red-600 text-sm tracking-wide font-light">
                                                        {{ $message }}
                                                    </p>
                                                </div>

                                                @enderror
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="evidence[]"
                                                       class="block text-sm font-medium leading-5 text-gray-700">
                                                    Additional evidence (optional)
                                                </label>
                                                <input id="evidence[]" name="evidence[]" type="file"
                                                       value="{{ old('evidence[]') }}" multiple accept="image/*"
                                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                                @error('evidence.*')
                                                <div>
                                                    <p class="text-red-600 text-sm tracking-wide font-light">
                                                        The attached Evidence must be an image.
                                                    </p>
                                                </div>
                                                @enderror
                                                @error('evidence')
                                                <div>
                                                    <p class="text-red-600 text-sm tracking-wide font-light">
                                                        Please provide at least one proof of purchase.
                                                    </p>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <div class="py-1">
                            <div class="border-t border-gray-200"></div>
                        </div>
                    </div>
                    <div class="mt-10 sm:mt-0">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">

                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-3 py-5 bg-white sm:p-6 flex flex-row">
                                        <button type="submit" class="inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-green-500 hover:border-green-700 bg-white hover:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                                            <span class="mr-2 hidden md:inline-flex">{{ __('transfers.submit_dispute') }}</span>
                                            <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.dispute') }}</span>
                                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                        <a href="{{ route('transfers.show', $transfer->id) }}" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg bg-white hover:bg-red-500 text-md font-medium text-red-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                                            <span class="inline-flex">{{ __('common.cancel') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
