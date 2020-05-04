<div wire:poll="rerender" class="mx-2 mt-2 sm:mt-0 sm:mx-4 rounded-md flex flex-row justify-end">
    @if(Auth::id() === $transfer->sending_party_id)
        @if($transfer->status == \App\TransferStatusId::Rejected || $transfer->status == \App\TransferStatusId::Declined)
            @include('transfers.action_buttons.restart')
        @endif
        @if($transfer->status == \App\TransferStatusId::Rejected || $transfer->status == \App\TransferStatusId::AwaitingAcceptance)
            @include('transfers.action_buttons.edit')
        @endif
        @if($transfer->status == \App\TransferStatusId::PendingApproval)
            @include('transfers.action_buttons.approve')
            @include('transfers.action_buttons.dispute')
        @endif
        @if($transfer->status == \App\TransferStatusId::AwaitingAcceptance || $transfer->status == \App\TransferStatusId::Rejected)
            @include('transfers.action_buttons.cancel')
        @endif
    @elseif(Auth::id() === $transfer->receiving_party_id)
        @if($transfer->status == \App\TransferStatusId::Accepted)
            @include('transfers.action_buttons.evidence')
            @include('transfers.action_buttons.decline')
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
        @if($transfer->status == \App\TransferStatusId::InDispute)
            @if ($transfer->transferDispute->user_id !== Auth::id())
                @include('transfers.action_buttons.acceptdispute')
            @endif
        @endif
    @include('transfers.action_buttons.copy')
</div>
