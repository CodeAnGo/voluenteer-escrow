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
            @include('transfers.action_buttons.restart')
        @endif
        @if($transfer->status == \App\TransferStatusId::PendingApproval || $transfer->status == \App\TransferStatusId::InDispute)
            @include('transfers.action_buttons.approve')
        @endif
        @if($transfer->status == \App\TransferStatusId::PendingApproval)
            @include('transfers.action_buttons.dispute')
        @endif
        @if($transfer->status == \App\TransferStatusId::AwaitingAcceptance || $transfer->status == \App\TransferStatusId::Accepted || $transfer->status == \App\TransferStatusId::Rejected)
            @include('transfers.action_buttons.cancel')
        @endif
    @elseif($is_receiving_user)
        @if($transfer->status == \App\TransferStatusId::Accepted)
            @include('transfers.action_buttons.evidence')
            @include('transfers.action_buttons.reject')
        @endif
        @if($transfer->status == \App\TransferStatusId::PendingApproval)
            @include('transfers.action_buttons.dispute')
        @endif
    @else
        @if($transfer->status == \App\TransferStatusId::AwaitingAcceptance)
            @include('transfers.action_buttons.accept')
            @include('transfers.action_buttons.reject')
        @endif
    @endif
    @include('transfers.action_buttons.copy')
@endsection

<script>
    function copyToClipboard(text) {
        if (window.clipboardData && window.clipboardData.setData) {
            return clipboardData.setData("Text", text);
        }
        else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
            var textarea = document.createElement("textarea");
            textarea.textContent = text;
            textarea.style.position = "fixed";
            document.body.appendChild(textarea);
            textarea.select();
            try {
                return document.execCommand("copy");
            }
            catch (ex) {
                console.warn("Copy to clipboard failed.", ex);
                return false;
            }
            finally {
                document.body.removeChild(textarea);
            }
        }
    }
</script>

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
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
