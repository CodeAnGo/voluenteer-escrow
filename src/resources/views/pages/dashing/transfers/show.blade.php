@extends('layouts.dashing')

@section('title', 'Transfer')
@section('page_title')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="max-w-6xl mx-auto">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                        {{ $transfer->transfer_reason }}
                    </h2>
                    <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mr-6">
                        Collecting for {{ $sending_user->first_name }} {{ $sending_user->last_name }}
                    </div>
                </div>
                @if($is_sending_user)
                    @if($transfer->status == "Rejected")
                        <span class="hidden sm:block ml-3 shadow-sm rounded-md">
                            <form action="{{ route('transfers.update', $transfer->id) }}" method="POST" id="restartForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="statusTransition" value="1"/>
                                <button type="submit" form="restartForm"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                    Restart Transfer
                                </button>
                            </form>
                        </span>
                    @endif
                    @if($transfer->status == "Awaiting Acceptance")
                        <span class="hidden sm:block ml-3 shadow-sm rounded-md">
                            <form action="{{ route('transfers.update', $transfer->id) }}" method="POST" id="cancelForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="statusTransition" value="4"/>
                                <button type="submit" form="cancelForm"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                    Cancel Transfer
                                </button>
                            </form>
                        </span>
                        <span class="hidden sm:block ml-3 shadow-sm rounded-md">
                            <form action="{{ route('transfers.edit', $transfer->id) }}" method="POST" id="editForm">
                                @csrf
                                @method('GET')
                                <button type="submit" form="editForm"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                    Edit Details
                                </button>
                            </form>
                        </span>
                    @endif
                    @if($transfer->status == "Pending Approval")
                        <span class="hidden sm:block ml-3 shadow-sm rounded-md">
                            <form action="{{ route('transfers.update', $transfer->id) }}" method="POST" id="completeForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="statusTransition" value="6"/>
                                <button type="submit" form="completeForm"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                    Approve Transfer
                                </button>
                            </form>
                        </span>
                    @endif
                @else
                    @if($transfer->status == "Awaiting Acceptance")
                        <span class="hidden sm:block ml-3 shadow-sm rounded-md">
                            <form action="{{ route('transfers.update', $transfer->id) }}" method="POST" id = "acceptForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="statusTransition" value="2"/>
                                <button type="submit" form="acceptForm"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                    Accept Transfer
                                </button>
                            </form>
                        </span>
                    @endif
                @endif
                @if($show_delivery_details and ($transfer->status == "Accepted" or $transfer->status == "Pending Approval"))
                    <div @click.away="open = false" class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                Raise a Dispute
                            </button>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
                             class="origin-center absolute mt-2 rounded-md shadow-lg right-0 top-1 absolute">
                            <div class="py-1 rounded-md bg-white shadow-xs p-5">
                                <div class="mt-6">
                                    <form>
                                        <label for="disputeReason" class="block text-sm font-medium leading-5 text-gray-700">
                                            Dispute Reason
                                        </label>
                                        <div class="mt-1 rounded-md shadow-sm">
                                            <textarea id="disputeReason" name="disputeReason" required rows="3" col="50"
                                                      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                                      placeholder="Please write the reason for raising the dispute."></textarea>
                                        </div>
                                        <label for="disputeReason" class="block text-sm font-medium leading-5 text-gray-500">
                                            This information will be used to support your dispute.
                                        </label>
                                        <br/>
                                        <label for="disputeEvidence" class="block text-sm font-medium leading-5 text-gray-700">
                                            Attach Evidence
                                        </label>
                                        <div class="mt-1 rounded-md shadow-sm">
                                            <input id="disputeEvidence" name="disputeEvidence" type = "file" required accept="image/x-png,image/jpeg"
                                                   class="appearance-none block w-auto px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                        </div>
                                        <label for="disputeEvidence" class="block text-sm font-medium leading-5 text-gray-500">
                                            Please include any relevant images to support your dispute claim.
                                        </label>
                                        <br/>
                                        <div class="mt-1 rounded-md shadow-sm flex w-auto">
                                            <button type="button" @click="open = !open"
                                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                                Cancel
                                            </button>
                                            {{--                                            TODO - put end point for saving dispute details and adding to ticket--}}
                                            <button type="button"
                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                                Send
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div @click.away="open = false" class="ml-3 relative" x-data="{ open: false }">
                    <div>
                        <button type="button" @click="open = !open" onclick="setClipboard('{{$transfer->escrow_link}}')"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Copy Link
                        </button>
                    </div>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
                         class="origin-center absolute mt-2 rounded-md shadow-lg right-0 top-1 absolute w-auto">
                        <div class="py-1 rounded-md bg-white shadow-xs p-5">
                            <div class="mt-6 w-auto">
                                <label class="block text-sm font-medium leading-5 text-gray-700 w-auto" id = "escrowLink">
                                    {{$transfer->escrow_link}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        {{--TODO - put this into it's own file --}}
        <script>
            function setClipboard() {
                if (document.selection) {
                    var range = document.body.createTextRange();
                    range.moveToElementText(document.getElementById("escrowLink"));
                    range.select().createTextRange();
                    document.execCommand("copy");
                } else if (window.getSelection) {
                    var range = document.createRange();
                    range.selectNode(document.getElementById("escrowLink"));
                    window.getSelection().addRange(range);
                    document.execCommand("copy");
                }
                var tempInput = document.createElement("input");
                tempInput.style = "position: absolute; left: -1000px; top: -1000px";
                tempInput.value = value;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
            }
        </script>

        @section('content')
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
                <div class="max-w-6xl mx-auto">
                    <div class="flex flex-col pt-4">
                        @if($show_delivery_details)
                            <div class="bg-white shadow overflow-hidden  sm:rounded-lg">
                                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Delivery Information
                                    </h3>
                                </div>
                                <div class="px-4 py-5 sm:px-6">
                                    <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-4">
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                                Full name
                                            </dt>
                                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                                {{ $transfer->delivery_first_name }} {{ $transfer->delivery_last_name }}
                                            </dd>
                                        </div>
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                                Country / Region
                                            </dt>
                                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                                {{ $transfer->delivery_country }}
                                            </dd>
                                        </div>
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                                Email address
                                            </dt>
                                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                                {{ $transfer->delivery_email }}
                                            </dd>
                                        </div>
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                                Street Address
                                            </dt>
                                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                                {{ $transfer->delivery_street }}
                                            </dd>
                                        </div>
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                                City
                                            </dt>
                                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                                {{ $transfer->delivery_city }}
                                            </dd>
                                        </div>
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                                Town
                                            </dt>
                                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                                {{ $transfer->delivery_town }}
                                            </dd>
                                        </div>
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                                Post Code
                                            </dt>
                                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                                {{ $transfer->delivery_postcode }}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                        @endif
                        <div class="bg-white shadow overflow-hidden  sm:rounded-lg mt-4">
                            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Transfer Information - <b>{{$transfer->status}}</b>
                                </h3>
                            </div>
                            <div class="px-4 py-5 sm:px-6">
                                <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-3">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm leading-5 font-medium text-gray-500">
                                            Transfer Reason
                                        </dt>
                                        <dd class="mt-1 text-sm leading-5 text-gray-900">
                                            {{ $transfer->transfer_reason }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm leading-5 font-medium text-gray-500">
                                            Overseeing Charity
                                        </dt>
                                        <dd class="mt-1 text-sm leading-5 text-gray-900">
                                            {{ $charity }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm leading-5 font-medium text-gray-500">
                                            Transfer Amount
                                        </dt>
                                        <dd class="mt-1 text-sm leading-5 text-gray-900">
                                            {{--                                    not sure if we should be also considering currency here.--}}
                                            £{{ $transfer->transfer_amount }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <dt class="text-sm leading-5 font-medium text-gray-500">
                                            Note/Context
                                        </dt>
                                        <dd class="mt-1 text-sm leading-5 text-gray-900">
                                            {{ $transfer->transfer_note }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        @if(isset($receiving_user->id))
                            <div class="bg-white shadow overflow-hidden  sm:rounded-lg mt-4">
                                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Volunteer Information
                                    </h3>
                                </div>
                                <div class="px-4 py-5 sm:px-6">
                                    <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-3">
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                                Full name
                                            </dt>
                                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                                {{ $receiving_user->first_name }} {{ $receiving_user->last_name }}
                                            </dd>
                                        </div>
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                                Email address
                                            </dt>
                                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                                {{ $receiving_user->email }}
                                            </dd>
                                        </div>
                                        {{-- TODO this will be centered and a URL will be passed in for the image--}}
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                                Profile Photo
                                            </dt>
                                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                                <div @click.away="open = false" class="ml-3 relative" x-data="{ open: false }">
                                                    <div>
                                                        <img class="h-8 w-8 rounded-full"
                                                             src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                             alt=""/>
                                                    </div>
                                                </div>
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
@endsection
