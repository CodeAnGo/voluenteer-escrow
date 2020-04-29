@extends('layouts.dashing')

@section('title', 'Transfer Confirmation')

@section('header_title')
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
            {{ $transfer->transfer_reason }}
        </h2>
    </div>
@endsection

@section('content')
    <form action="{{ route('transfers.evidence.store', $transfer->id) }}" method="POST" enctype="multipart/form-data">
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
                                    Submit for Approval
                                </h3>
                                <p class="mt-1 text-sm leading-5 text-gray-500">
                                    Please provide the actual amount of the transaction, as well as a proof of purchase,
                                    e.g., a receipt for the goods.
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="actual_amount"
                                                   class="block text-sm font-medium leading-5 text-gray-700">
                                                Actual Amount
                                            </label>
                                            <input required name="actual_amount" type="number" min="0" step="0.01"
                                                   placeholder="{{$transfer->transfer_amount}}"
                                                   class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                            <label for="actual_amount"
                                                   class="block text-sm font-medium leading-5 text-gray-500 py-1">
                                                The actual cost of the service provided.
                                            </label>
                                            @error('actual_amount')
                                            <div>
                                                <p class="text-red-600 text-sm tracking-wide font-light">
                                                    Please provide an amount.
                                                </p>
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="evidence[]"
                                                   class="block text-sm font-medium leading-5 text-gray-700">
                                                Proof of Purchase
                                            </label>
                                            <input id="evidence[]" name="evidence[]" type="file"
                                                   value="{{ old('evidence[]') }}" multiple required accept="image/*"
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

                                        <div class="col-span-6 sm:col-span-6">
                                            <label for="transfer_note"
                                                   class="block text-sm font-medium leading-5 text-gray-700">
                                                Additional Notes (optional)
                                            </label>
                                            <textarea
                                                placeholder="E.g., Groceries were cheaper than previously specified."
                                                name="transfer_note"
                                                class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"></textarea>
                                            @error('transfer_note')
                                            <div>
                                                <p class="text-red-600 text-sm tracking-wide font-light">
                                                    {{ $message }}
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
                                    <span class="inline-flex rounded-md px-1">
                                        <button type="submit"
                                                class="inline-flex px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                            Submit for Approval
                                        </button>
                                    </span>
                                    <span class="inline-flex rounded-md px-1">
                                        <a href="{{Route('transfers.show', $transfer->id)}}"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-black hover:text-gray-900 bg-gray-300 hover:bg-gray-200 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                            Cancel
                                        </a>
                                    </span>
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







{{--<form action="{{ route('transfers.evidence.store', $transfer_id) }}" method="POST" enctype="multipart/form-data">--}}
{{--    @csrf--}}
{{--    <label for="evidence[]" class="text-sm leading-5 font-medium text-gray-500">--}}
{{--        Evidence--}}
{{--    </label>--}}
{{--    <div class="mt-1 rounded-md shadow-sm">--}}
{{--    </div>--}}
{{--    @error('evidence.*')--}}
{{--        <div class="mt-1 rounded-md shadow-sm">--}}
{{--            <p class="text-red-600 text-sm tracking-wide font-light">--}}
{{--                The attached Evidence must be an image.--}}
{{--            </p>--}}
{{--        </div>--}}
{{--    @enderror--}}
{{--    @error('evidence')--}}
{{--    <div class="mt-1 rounded-md shadow-sm">--}}
{{--        <p class="text-red-600 text-sm tracking-wide font-light">--}}
{{--            You must provide at least one image as proof of service.--}}
{{--        </p>--}}
{{--    </div>--}}
{{--    @enderror--}}
{{--    <button type="submit" class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">--}}
{{--        Upload Evidence--}}
{{--    </button>--}}
{{--</form>--}}
