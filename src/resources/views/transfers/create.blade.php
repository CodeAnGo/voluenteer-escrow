@extends('layouts.dashing')

@section('title', 'Create a Transfer')
@section('header_title', __('transfers.create.title'))

@section('content')
    <script src="https://js.stripe.com/v3/"></script>
    <form action="{{ route('transfers.store') }}" method="Post">
        @csrf
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="max-w-6xl mx-auto">

            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Delivery Information</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                This should be the recipient of the volunteers actions, eg who they will deliver some groceries too.
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="first_name" class="block text-sm font-medium leading-5 text-gray-700">First name</label>
                                        <input required name="first_name" value="@if(count($transfers) ==1)  {{$transfers[0]->delivery_first_name}} @endif" id="first_name" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>


                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="last_name" class="block text-sm font-medium leading-5 text-gray-700">Last name</label>
                                        <input required name="last_name" value="@if(count($transfers) ==1)  {{$transfers[0]->delivery_last_name}} @endif" id="last_name" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="email_address" class="block text-sm font-medium leading-5 text-gray-700">Email address</label>
                                        <input required value="@if(count($transfers) ==1)  {{$transfers[0]->delivery_email}} @endif" name="email_address"  class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="country" class="block text-sm font-medium leading-5 text-gray-700">Country / Region</label>
                                        <select name="country" id="country" class="mt-1 block form-select w-full py-2 px-3 py-0 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                            <option>United Kingdom</option>
                                        </select>
                                    </div>

                                    <div class="col-span-6">
                                        <label for="street_address" class="block text-sm font-medium leading-5 text-gray-700">Street address</label>
                                        <input name="street_address" value="@if(count($transfers) ==1)  {{$transfers[0]->delivery_street}} @endif"   id="street_address" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                        <label for="city" class="block text-sm font-medium leading-5 text-gray-700">City</label>
                                        <input name="city"  id="city" value="@if(count($transfers) ==1)  {{$transfers[0]->delivery_city}} @endif"  class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                        <label for="state" class="block text-sm font-medium leading-5 text-gray-700">Town / Province</label>
                                        <input name="state"  id="state" value="@if(count($transfers) ==1)  {{$transfers[0]->delivery_town}} @endif"  class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                        <label for="postal_code" class="block text-sm font-medium leading-5 text-gray-700">Post Code</label>
                                        <input name="postal_code" value="@if(count($transfers) ==1)  {{$transfers[0]->delivery_postcode}} @endif"  id="postal_code" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
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
                                This helps us combat fraudulent use of the system, and helps the chosen charity enforce their respective rules.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="transfer_reason" class="block text-sm font-medium leading-5 text-gray-700">What is the transfer for?</label>
                                        <input name="transfer_reason"  class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="charity_id" class="block text-sm font-medium leading-5 text-gray-700">Which charity is overseeing this transaction?</label>
                                         <select name="charity"  class="mt-1 block form-select w-full py-2 px-3 py-0 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" style="width:250px">
                                            <option value="">Select Charity</option>
                                            @foreach ( $charities  as $ch)
                                                <option value="{{$ch->id}}">{{$ch->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="transfer_amount" class="block text-sm font-medium leading-5 text-gray-700">How much is this transfer for?</label>
                                        <input name="transfer_amount" required id="transfer_amount" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="transfer_note" class="block text-sm font-medium leading-5 text-gray-700">Please attach some context around this transfer</label>
                                        <textarea  name="transfer_note"  required class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"></textarea>
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
            @if (empty($cards))

            @else
<!--Payment Details-->

        <div class="mt-10 sm:mt-0" >
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Payment Information</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                This will be used to take payment from you for this transaction.
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        @foreach($cards['data'] as $value)
                        <div class="shadow overflow-hidden sm:rounded-md">

                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-6">
                                        <div class="rounded-md bg-gray-50 px-6 py-5 sm:flex sm:items-start sm:justify-between">
                                            <div class="sm:flex sm:items-start">
                                                <svg class="h-8 w-auto sm:flex-shrink-0 sm:h-6" fill="none" viewBox="0 0 36 24" role="img" aria-labelledby="svg-{{ $value['brand'] }}">
                                                    <title id="svg-{{ $value['brand'] }}">{{ $value['brand'] }}</title>
                                                    <rect width="36" height="24" fill="#224DBA" rx="4" />
                                                    <path fill="#fff" fill-rule="evenodd" d="M10.925 15.673H8.874l-1.538-6c-.073-.276-.228-.52-.456-.635A6.575 6.575 0 005 8.403v-.231h3.304c.456 0 .798.347.855.75l.798 4.328 2.05-5.078h1.994l-3.076 7.5zm4.216 0h-1.937L14.8 8.172h1.937l-1.595 7.5zm4.101-5.422c.057-.404.399-.635.798-.635a3.54 3.54 0 011.88.346l.342-1.615A4.808 4.808 0 0020.496 8c-1.88 0-3.248 1.039-3.248 2.481 0 1.097.969 1.673 1.653 2.02.74.346 1.025.577.968.923 0 .519-.57.75-1.139.75a4.795 4.795 0 01-1.994-.462l-.342 1.616a5.48 5.48 0 002.108.404c2.108.057 3.418-.981 3.418-2.539 0-1.962-2.678-2.077-2.678-2.942zm9.457 5.422L27.16 8.172h-1.652a.858.858 0 00-.798.577l-2.848 6.924h1.994l.398-1.096h2.45l.228 1.096h1.766zm-2.905-5.482l.57 2.827h-1.596l1.026-2.827z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="mt-3 sm:mt-0 sm:ml-4">
                                                    <div class="text-sm leading-5 font-medium text-gray-900">
                                                        Ending with {{ $value['last4'] }}
                                                    </div>
                                                    <div class="mt-1 text-sm leading-5 text-gray-600 sm:flex sm:items-center">
                                                        <div>
                                                            Expires year {{ $value['exp_year'] }}
                                                        </div>
                                                        <span class="hidden sm:mx-2 sm:inline" aria-hidden="true">

              </span>
                                                       <!-- <div class="mt-1 sm:mt-0">
                                                            Last updated on 22 Aug 2017  *******
                                                        </div>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 sm:mt-0 sm:ml-6 sm:flex-shrink-0">
          <span class="inline-flex rounded-md shadow-sm">
         <input type="radio" id="card" name="card" value="{{ $value['id'] }}" required>

            <!--<button type="button" url="$url" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
              Edit
            </button>-->
          </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                            <br/>
                        @endforeach
                    </div>

                </div>
                <div class="hidden sm:block">
                    <div class="py-5">
                        <div class="border-t border-gray-200"></div>
                    </div>
                </div>


            </div>


        @endif
            <!--End Payment Details-->
            <div class="bg-white shadow sm:rounded-lg mt-5">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Are you sure?
                    </h3>
                    <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                        <div class="max-w-xl text-sm leading-5 text-gray-500">
                            <p>
                                This will take money from the payment method chosen above, and hold the money in escrow until a volunteer completes your task, or you cancel the job.
                            </p>
                        </div>
                        <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                        <span class="inline-flex rounded-md shadow-sm">
                            <a href="{{ route('transfers.index') }}" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg bg-white hover:bg-red-500 text-md font-medium text-red-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                                <span class="inline-flex">{{ __('common.cancel') }}</span>
                            </a>
                            <button type="submit" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-green-500 hover:border-green-700 bg-white hover:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                                <span class="mr-2 hidden md:inline-flex">{{ __('transfers.save_transfer') }}</span>
                                <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.save') }}</span>
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection
