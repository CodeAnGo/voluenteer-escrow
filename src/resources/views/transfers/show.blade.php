@extends('layouts.dashing')

@section('title', 'Transfer')

@section('header_title')
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
            {{ $transfer->transfer_reason }}
        </h2>

    </div>
@endsection
@section('header_sub_title')
    <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mr-6">
        Collecting for {{ $sending_user->first_name }} {{ $sending_user->last_name }}
    </div>
@endsection
@section('header_buttons')
    @if($is_sending_user)
        @if($transfer->status == \App\TransferStatusId::Rejected)
            <button type="submit" form="restartForm" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-green-500 hover:border-green-700 bg-white hover:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                <span class="mr-2 hidden md:inline-flex">{{ __('transfers.restart_transfer') }}</span>
                <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.restart') }}</span>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </button>
            <form class="hidden" action="{{ route('transfers.update', $transfer->id) }}" method="POST" id="restartForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="statusTransition" value="{{\App\TransferStatusId::AwaitingAcceptance}}"/>
            </form>
        @endif
        @if($transfer->status == \App\TransferStatusId::AwaitingAcceptance)
            <button type="submit" form="cancelForm" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-red-500 hover:border-red-700 bg-white hover:bg-red-500 text-md font-medium text-red-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                <span class="mr-2 hidden md:inline-flex">{{ __('transfers.cancel_transfer') }}</span>
                <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.cancel') }}</span>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                    <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
            <a href="{{ route('transfers.edit', $transfer->id) }}" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-indigo-500 hover:border-indigo-700 bg-white hover:bg-indigo-500 text-md font-medium text-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                <span class="mr-2 hidden md:inline-flex">{{ __('transfers.edit_transfer') }}</span>
                <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.edit') }}</span>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </a>
            <form class="hidden" action="{{ route('transfers.update', $transfer->id) }}" method="POST" id="cancelForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="statusTransition" value="{{\App\TransferStatusId::Cancelled}}"/>
            </form>
        @endif
        @if($transfer->status == \App\TransferStatusId::PendingApproval)
            <button type="submit" form="approveForm" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-green-500 hover:border-green-700 bg-white hover:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                <span class="mr-2 hidden md:inline-flex">{{ __('transfers.approve_transfer') }}</span>
                <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.approve') }}</span>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
            <form class="hidden" action="{{ route('transfers.update', $transfer->id) }}" method="POST"
                  id="approveForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="statusTransition" value="{{\App\TransferStatusId::Approved}}"/>
            </form>
        @endif
    @else
        @if(Auth::user()->id === $transfer->receiving_party_id and $transfer->status == \App\TransferStatusId::Accepted)
            <button type="submit" form="evidenceForm" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-green-500 hover:border-green-700 bg-white hover:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                <span class="mr-2">Submit for Approval</span>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
            <form class="hidden" action="{{ route('transfers.evidence.create', $transfer->id) }}"
                  method="GET"
                  id="evidenceForm">
                @csrf
            </form>
        @endif
        @if($transfer->status == \App\TransferStatusId::AwaitingAcceptance)
            <button type="submit" form="acceptForm" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-green-500 hover:border-green-700 bg-white hover:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                <span class="mr-2 hidden md:inline-flex">{{ __('transfers.accept_transfer') }}</span>
                <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.accept') }}</span>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
            <form class="hidden" action="{{ route('transfers.update', $transfer->id) }}" method="POST" id="acceptForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="statusTransition" value="{{\App\TransferStatusId::Accepted}}"/>
            </form>
        @endif
        @if(!(in_array($transfer->status, $closed_status)) and $transfer->status != \App\TransferStatusId::Rejected and Auth::user()->id === $transfer->receiving_party_id)
            <button type="submit" form="rejectForm" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-red-500 hover:border-red-700 bg-white hover:bg-red-500 text-md font-medium text-red-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                <span class="mr-2 hidden md:inline-flex">{{ __('transfers.reject_transfer') }}</span>
                <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.reject') }}</span>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                    <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
            <form class="hidden" action="{{ route('transfers.update', $transfer->id) }}" method="POST" id="rejectForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="statusTransition" value="{{\App\TransferStatusId::Rejected}}"/>
            </form>
        @endif
    @endif
    @if($show_delivery_details and ($transfer->status == \App\TransferStatusId::Accepted or $transfer->status == \App\TransferStatusId::PendingApproval))
        <div @click.away="open = false" x-data="{ open: false }" class="items-center">
            <button @click="open = !open" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-red-500 hover:border-red-700 bg-white hover:bg-red-500 text-md font-medium text-red-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                <span class="mr-2 hidden md:inline-flex">{{ __('transfers.dispute_transfer') }}</span>
                <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.dispute') }}</span>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
                 class="origin-center mt-2 rounded-md shadow-lg absolute w-64">
                <div class="py-1 rounded-md bg-white shadow-xs p-5">
                    <div class="mt-6">
                        <form>
                            <label for="disputeReason"
                                   class="block text-sm font-medium leading-5 text-gray-700">
                                Dispute Reason
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                            <textarea id="disputeReason" name="disputeReason" required rows="3" col="50"
                                      class="appearance-none block w-full text-sm px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                      placeholder="Please write the reason for raising the dispute."></textarea>
                            </div>
                            <label for="disputeReason"
                                   class="block text-sm font-medium leading-5 text-gray-500">
                                This information will be used to support your dispute.
                            </label>
                            <br/>
                            <label for="disputeEvidence"
                                   class="font-bold block text-sm font-medium leading-5 text-gray-700">
                                Attach Evidence
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="disputeEvidence" name="disputeEvidence" type="file" required
                                       accept="image/x-png,image/jpeg"
                                       class="appearance-none block w-full text-sm px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out"/>
                            </div>
                            <label for="disputeEvidence"
                                   class="block text-sm font-medium leading-5 text-gray-500">
                                Please include any relevant images to support your dispute claim.
                            </label>
                            <div
                                class="mt-1 rounded-md shadow-sm flex flex-row justify-between w-auto py-1">
                                <button type="button" @click="open = !open"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md  hover:text-gray-800 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 hover:bg-gray-100 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out text-black bg-white">
                                    Cancel
                                </button>
                                {{--                                        TODO - put end point for saving dispute details and adding to ticket--}}
                                <button type="button"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-black bg-blue-300 hover:bg-blue-200 hover:text-gray-800 focus:outline-none focus:blue-400 active:bg-blue-300 transition ease-in-out duration-150">
                                    Send
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div @click.away="open = false" x-data="{ open: false }" class="items-center">
        <button type="button" @click="open = !open" onclick="setClipboard('{{env('APP_URL') . '/transfers/'. $transfer->id}}')" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-indigo-500 hover:border-indigo-700 bg-white hover:bg-indigo-500 text-md font-medium text-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
            <span class="mr-2 inline-flex">{{ __('transfers.copy_link') }}</span>
            <svg fill="currentColor" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"></path>
            </svg>
        </button>
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
             class="absolute mt-2 rounded-md shadow-lg origin-center">
            <div class="p-3 rounded-md bg-gray-100 shadow-xs">
                <div
                    class="overflow-x-scroll w-64 text-sm font-medium leading-5 text-gray-700 text-center"
                    id="escrowLink">
                    {{env('APP_URL') . '/transfers/'. $transfer->id}}
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
                @if($show_delivery_details or is_null($transfer->receiving_party_id))
                    <div class="bg-white shadow overflow-hidden  sm:rounded-lg">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <div class="flex flex-row">
                                <div class="text-lg leading-6 font-medium text-gray-900">
                                    Delivery Information
                                </div>
                            </div>
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
                                        County
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                                        {{ $transfer->delivery_county }}
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
                        <div class="flex flex-row">
                            <div class="text-lg leading-6 font-medium text-gray-900">
                                Transfer Information
                            </div>
                            <div class="text-sm leading-6 font-medium text-gray-900 ml-auto text-center font-semibold rounded-full px-2
                                @if (in_array($transfer->status, $closed_status))
                                    bg-red-200 text-red-800 tracking-wide font-thin
                                @else
                                    bg-green-200 text-green-800 tracking-wide font-thin
                                @endif
                                ">{{$status_map[$transfer->status]}}
                            </div>
                        </div>
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
                            </dl>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
