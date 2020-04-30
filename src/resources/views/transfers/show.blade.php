@extends('layouts.dashing')

@section('title', 'Transfer')

@section('header_title', $transfer->transfer_reason)

@section('header_sub_title', "Collecting for $sending_user->first_name $sending_user->last_name")

@section('header_buttons')
    @livewire('transfer-action-buttons-component', ['transfer' => $transfer])
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
    @if(Auth::user() == $transfer->sendingParty || Auth::user() == $transfer->receivingParty)
        @livewire('transfer-header-component', ['transfer' => $transfer])
    @endif
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col pt-4">
                @livewire('transfer-delivery-information-component', ['transfer' => $transfer])

                @livewire('transfer-transfer-information-component', ['transfer' => $transfer])
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
                @if ($transfer->actual_amount)
                    <div class="bg-white shadow overflow-hidden  sm:rounded-lg mt-4">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Transfer Evidence
                            </h3>
                        </div>
                        <div class="px-4 py-3 sm:px-6">
                            <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-3">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm leading-5 font-medium text-gray-500">
                                        Actual Amount
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                                        {{ $transfer->actual_amount }}
                                    </dd>
                                </div>
                                @if ($transfer->approval_note)
                                <div class="sm:col-span-1">
                                    <dt class="text-sm leading-5 font-medium text-gray-500">
                                        Additional Notes
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                                        {{ $transfer->approval_note }}
                                    </dd>
                                </div>
                                @endif
                                <div class="sm:col-span-4">
                                    <dt class="text-sm leading-5 font-medium text-gray-500 mb-2">
                                        Proof of Purchase
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900 flex">
                                    @foreach($transferEvidence as $transferPhoto)
                                    <div class="flex-auto mb-2  h-56">
                                        <a href="{{Storage::disk('public')->url($transferPhoto->path)}}" target="_blank">
                                        <img class="mr-4 object-contain h-56 w-auto" src="{{Storage::disk('public')->url($transferPhoto->path)}}" alt="">
                                        </a>
                                    </div>
                                    @endforeach
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
            </div>
            @endif
                @if($transfer->sendingParty == Auth::user())
                    @livewire('transfer-transfer-history-component', ['transfer' => $transfer])
                @endif
            </div>
        </div>
            </div>
        </div>
    </div>
@endsection
