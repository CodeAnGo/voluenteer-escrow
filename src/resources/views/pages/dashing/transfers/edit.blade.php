@extends('layouts.app')

@section('title', 'Create a Transfer')
@section('page_title', 'Create a Transfer')

@section('content')
    <form action="{{ route('transfers.update',$transfer->id) }}" method="Post">
        @csrf
        @method('PUT');
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="max-w-6xl mx-auto">

                <div class="mt-10 sm:mt-0">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Delivery Information</h3>
                                <p class="mt-1 text-sm leading-5 text-gray-500">
                                    This should be the recipient of the volunteers actions, e.g. who they will deliver
                                    some groceries too.
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="first_name"
                                                   class="block text-sm font-medium leading-5 text-gray-700">First
                                                name</label>
                                            <input required name="first_name" value="{{$transfer->delivery_first_name}}"
                                                   id="first_name"
                                                   class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                        </div>


                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="last_name"
                                                   class="block text-sm font-medium leading-5 text-gray-700">Last
                                                name</label>
                                            <input required name="last_name" value="{{$transfer->delivery_last_name}}"
                                                   id="last_name"
                                                   class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-4">
                                            <label for="email_address"
                                                   class="block text-sm font-medium leading-5 text-gray-700">Email
                                                address</label>
                                            <input required value="{{$transfer->delivery_email}}" name="email_address"
                                                   class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="country"
                                                   class="block text-sm font-medium leading-5 text-gray-700">Country /
                                                Region</label>
                                            <select name="country" id="country"
                                                    class="mt-1 block form-select w-full py-2 px-3 py-0 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                                <option>United Kingdom</option>
                                            </select>
                                        </div>

                                        <div class="col-span-6">
                                            <label for="street_address"
                                                   class="block text-sm font-medium leading-5 text-gray-700">Street
                                                address</label>
                                            <input name="street_address" value="{{$transfer->delivery_street}}"
                                                   id="street_address"
                                                   class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                            <label for="city" class="block text-sm font-medium leading-5 text-gray-700">City</label>
                                            <input name="city" id="city" value="{{$transfer->delivery_city}}"
                                                   class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                            <label for="state"
                                                   class="block text-sm font-medium leading-5 text-gray-700">Town /
                                                Province</label>
                                            <input name="state" id="state" value="{{$transfer->delivery_town}}"
                                                   class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                            <label for="postal_code"
                                                   class="block text-sm font-medium leading-5 text-gray-700">Post
                                                Code</label>
                                            <input name="postal_code" value="{{$transfer->delivery_postcode}}"
                                                   id="postal_code"
                                                   class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden sm:block">
                    <div class="py-5">
                        <div class="border-t border-gray-200"></div>
                    </div>
                </div>

                <div class="mt-10 sm:mt-0">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Transfer Information</h3>
                                <p class="mt-1 text-sm leading-5 text-gray-500">
                                    This helps us combat fraudulent use of the system, and helps the chosen charity
                                    enforce their respective rules.
                                </p>
                            </div>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="transfer_reason"
                                                   class="block text-sm font-medium leading-5 text-gray-700">What is the
                                                transfer for?</label>
                                            <input name="transfer_reason" value="{{$transfer->transfer_reason}}"
                                                   class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="charity_id"
                                                   class="block text-sm font-medium leading-5 text-gray-700">Which
                                                charity is overseeing this transaction?</label>
                                            <input name="charity" value="{{$charity}}" readonly
                                                   class="bg-gray-100 mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="transfer_amount"
                                                   class="block text-sm font-medium leading-5 text-gray-700">How much is
                                                this transfer for?</label>
                                            <input name="transfer_amount" value="{{$transfer->transfer_amount}}"
                                                   readonly required id="transfer_amount"
                                                   class="bg-gray-100 mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                                The charity and payment amount cannot be changed. To change this
                                                information please cancel the transfer and create a new one.
                                            </p>
                                        </div>

                                        <div class="col-span-6 sm:col-span-6">
                                            <label for="transfer_note"
                                                   class="block text-sm font-medium leading-5 text-gray-700">Please
                                                attach some context around this transfer</label>
                                            <textarea name="transfer_note" required
                                                      class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">{{$transfer->transfer_note}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 sm:mt-0">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div></div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="bg-white shadow sm:rounded-lg mt-5 col-span-6">
                                <div class="px-4 py-5 sm:p-6">
                                    <div class="mt-2 sm:flex sm:items-start sm:justify-between flex-row-reverse">
                                        <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                                            <span class="inline-flex rounded-md shadow-sm mx-1 px-2">
                                                <a href="{{ route('transfers.show', $transfer->id) }}"
                                                        class="inline-flex items-center px-4 py-2 border border-gray-600 text-sm leading-5 font-medium rounded-md text-gray-700 bg-gray-100 hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                                    Cancel
                                                </a>
                                            </span>
                                            <span class="inline-flex rounded-md shadow-sm mx-1 px-2">
                                                <button type="submit"
                                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                                    Confirm Changes
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <div class="py-5">
                        <div class="border-t border-gray-200"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
