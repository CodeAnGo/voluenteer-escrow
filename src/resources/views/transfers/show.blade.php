@extends('layouts.dashing')

@section('title', 'Transfer')

@section('header_title', $transfer->transfer_reason)

@section('header_sub_title', "Collecting for $sending_user->first_name $sending_user->last_name")

@section('header_buttons')
    @if(Auth::id() === $transfer->sending_party_id)
        @if($transfer->status == \App\TransferStatusId::Rejected)
            @include('transfers.action_buttons.restart')
        @endif
        @if($transfer->status == \App\TransferStatusId::Rejected || $transfer->status == \App\TransferStatusId::AwaitingAcceptance)
            @include('transfers.action_buttons.edit')
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
    @elseif(Auth::id() === $transfer->receiving_party_id)
        @if($transfer->status == \App\TransferStatusId::Accepted)
            @include('transfers.action_buttons.evidence')
            @include('transfers.action_buttons.reject')
        @endif
        @if($transfer->status == \App\TransferStatusId::PendingApproval)
            @include('transfers.action_buttons.dispute')
        @endif
    @elseif(Auth::user()->volunteer)
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
    @if(Auth::id() === $transfer->sending_party_id || Auth::id() === $transfer->receiving_party_id)
        @include('transfers.status')
    @endif
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col pt-4">
                <div class="bg-white shadow overflow-hidden  sm:rounded-lg">
                    <div class="px-4 py-3 border-b border-gray-200 sm:px-6">
                        <div class="flex flex-col">
                            <div class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('transfers.delivery_information') }}
                            </div>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ __('transfers.delivery_information_sub_title') }}
                            </p>
                        </div>
                    </div>
                    <div class="px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2 lg:grid-cols-3">
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ __('common.full_name') }}
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ $transfer->delivery_first_name }} {{ $transfer->delivery_last_name }}
                                </dd>
                            </div>
                            @if(Auth::id() === $transfer->sending_party_id || Auth::id() === $transfer->receiving_party_id)
                                <div class="sm:col-span-1">
                                    <dt class="text-sm leading-5 font-medium text-gray-500">
                                        {{ __('common.email_address') }}
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                                        {{ $transfer->delivery_email ?? '-' }}
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm leading-5 font-medium text-gray-500">
                                        {{ __('common.phone_number') }}
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                                        {{ $transfer->delivery_phone ?? '-' }}
                                    </dd>
                                </div>
                                <div class="hidden col-span-1 sm:inline-flex lg:hidden"></div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm leading-5 font-medium text-gray-500">
                                        {{ __('common.line1') }}
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                                        {{ $transfer->delivery_street_1 ?? '-' }}
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm leading-5 font-medium text-gray-500">
                                        {{ __('common.line2') }}
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                                        {{ $transfer->delivery_street_2 ?? '-' }}
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm leading-5 font-medium text-gray-500">
                                        {{ __('common.city') }}
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                                        {{ $transfer->delivery_city ?? '-' }}
                                    </dd>
                                </div>
                            @else
                                <div class="hidden lg:inline-flex lg:col-span-2"></div>
                            @endif
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ __('common.county') }}
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ $transfer->delivery_county ?? '-' }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ __('common.postcode') }}
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ $transfer->delivery_postcode ?? '-' }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ __('common.country') }}
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ $transfer->delivery_country ?? '-' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="bg-white shadow overflow-hidden  sm:rounded-lg mt-4">
                    <div class="px-4 py-3 border-b border-gray-200 sm:px-6">
                        <div class="flex flex-row items-center">
                            <div class="flex flex-col">
                                <div class="text-lg leading-6 font-medium text-gray-900">
                                    {{ __('transfers.transfer_information') }}
                                </div>
                                <p class="mt-1 text-sm leading-5 text-gray-500">
                                    {{ __('transfers.transfer_information_sub_title') }}
                                </p>
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
                    <div class="px-4 py-3 sm:px-6">
                        <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-3">
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ __('transfers.transfer_information.reason') }}
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ $transfer->transfer_reason ?? '-' }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ __('transfers.transfer_information.amount') }}
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    £{{ $transfer->transfer_amount ?? '-' }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ __('transfers.transfer_information.charity') }}
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ $charity ?? '-' }}
                                </dd>
                            </div>
                            <div class="sm:col-span-3">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ __('transfers.transfer_information.context') }}
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ $transfer->transfer_note ?? '-' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
                @if(isset($transfer->receiving_party_id) && (Auth::id() === $transfer->sending_party_id || Auth::id() === $transfer->receiving_party_id))
                    <div class="bg-white shadow overflow-hidden  sm:rounded-lg mt-4">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('transfers.volunteering_information') }}
                            </h3>
                        </div>
                        <div class="px-4 py-3 sm:px-6">
                            <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-3">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm leading-5 font-medium text-gray-500">
                                        {{ __('common.full_name') }}
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                                        {{ $receiving_user->first_name }} {{ $receiving_user->last_name }}
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm leading-5 font-medium text-gray-500">
                                        {{ __('common.email_address') }}
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                                        {{ $receiving_user->email }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                @endif
                @if($transfer->sending_party_id === Auth::id())
                    <div class="bg-white shadow overflow-hidden  sm:rounded-lg mt-4">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Transfer History
                            </h3>
                        </div>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul>
                                @foreach ($transfer_history as $change)
                                    @if($change_user= $change_users->find($change->user_id)) @endif
                                    @if($change->event=='created' or ($change->event=='updated' and !array_key_exists('freshdesk_id', $change->old_values)))
                                    <li class="border border-2 border-gray-100">
                                        <div href="/transfers/{{ $transfer->id }}"
                                             class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                                            <div class="px-4 py-4 sm:px-6">
                                                @if(array_key_exists('status', $change->old_values))
                                                    <div class="flex items-center justify-between">
                                                        <div
                                                            class="text-sm leading-5 font-medium text-gray-500 truncate tracking-wider">
                                                            <span class="text-indigo-600">
                                                                Status moved
                                                            </span>
                                                            to
                                                            <span
                                                                @if (in_array($change->new_values['status'], $closed_status))
                                                                class="text-red-600">
                                                                @else
                                                                    class="text-green-600">
                                                                @endif
                                                                {{$status_map[$change->new_values['status']]}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <div
                                                            class="text-sm leading-5 font-medium text-gray-500 tracking-wider">
                                                            <span class="text-gray-500">
                                                                by
                                                            </span>
                                                            <span class="text-gray-600">
                                                                {{$change_user->first_name}} {{$change_user->last_name}}
                                                            </span>
                                                        </div>
                                                        <div
                                                            class="mt-2 flex items-center text-sm leading-5 text-gray-600 sm:mt-0 font-thin tracking-wide">
                                                            <span>
                                                                Updated
                                                                <time
                                                                    datetime="{{ $change->created_at }}">{{ \Carbon\Carbon::make($change->created_at)->diffForHumans() }}</time>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @elseif($change->event=='created')
                                                    <div class="flex items-center justify-between">
                                                        <div
                                                            class="text-sm leading-5 font-medium text-gray-500 truncate tracking-wider">
                                                            <span class="text-indigo-600">
                                                                Transfer <span class="text-green-600">Created</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <div
                                                            class="text-sm leading-5 font-medium text-gray-500 tracking-wider">
                                                            <span class="text-gray-500">
                                                                by
                                                            </span>
                                                            <span class="text-gray-600">
                                                                {{$change_user->first_name}} {{$change_user->last_name}}
                                                            </span>
                                                        </div>
                                                        <div
                                                            class="mt-2 flex items-center text-sm leading-5 text-gray-600 sm:mt-0 font-thin tracking-wide">
                                                            <span>
                                                                Created
                                                                <time
                                                                    datetime="{{ $change->created_at }}">{{ \Carbon\Carbon::make($change->created_at)->diffForHumans() }}</time>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="flex items-center justify-between">
                                                        <div
                                                            class="text-sm leading-5 font-medium text-gray-500 truncate tracking-wider">
                                                            <span class="text-indigo-600">
                                                                Transfer Details Updated
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <div
                                                            class="text-sm leading-5 font-medium text-gray-500 tracking-wider">
                                                            <span class="text-gray-500">
                                                                by
                                                            </span>
                                                            <span class="text-gray-600">
                                                                {{$change_user->first_name}} {{$change_user->last_name}}
                                                            </span>
                                                        </div>
                                                        <div
                                                            class="mt-2 flex items-center text-sm leading-5 text-gray-600 sm:mt-0 font-thin tracking-wide">
                                                            <span>
                                                                Updated
                                                                <time
                                                                    datetime="{{ $change->created_at }}">{{ \Carbon\Carbon::make($change->created_at)->diffForHumans() }}</time>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                        @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
            </div>
        </div>
    </div>
@endsection
