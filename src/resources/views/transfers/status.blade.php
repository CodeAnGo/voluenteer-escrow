<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <div class="p-2 sm:rounded-md shadow bg-white flex flex-col sm:flex-row">
        @if($transfer->status === \App\TransferStatusId::Cancelled)
            @include('transfers.status.negative', [
                'status_id' => \App\TransferStatusId::Cancelled,
                'status_title' => 'Cancelled',
                'status_message' => 'Transfer has been cancelled and will no long be fulfilled',
                'status_final' => true,
            ])
            <span class="mx-2 sm:mx-0 sm:my-2 border-b sm:border-b-0 sm:border-l border-gray-200"></span>
        @endif
        @if($transfer->status === \App\TransferStatusId::Rejected)
            @include('transfers.status.negative', [
                'status_id' => \App\TransferStatusId::Rejected,
                'status_title' => 'Rejected',
                'status_message' => 'Transfer has been rejected by a Volunteer as it required changes',
                'status_final' => true,
            ])
            <span class="mx-2 sm:mx-0 sm:my-2 border-b sm:border-b-0 sm:border-l border-gray-200"></span>
        @endif
        @include('transfers.status.positive', [
            'status_id' => \App\TransferStatusId::AwaitingAcceptance,
            'status_title' => 'Awaiting Acceptance',
            'status_message' => 'Transfer has been created and is awaiting a Volunteer to be assigned',
        ])
        <span class="mx-2 sm:mx-0 sm:my-2 border-b sm:border-b-0 sm:border-l border-gray-200"></span>
        @include('transfers.status.positive', [
            'status_id' => \App\TransferStatusId::Accepted,
            'status_title' => 'Accepted',
            'status_message' => 'A Volunteer has been assigned and is completing the requested task',
        ])
        <span class="mx-2 sm:mx-0 sm:my-2 border-b sm:border-b-0 sm:border-l border-gray-200"></span>
        @include('transfers.status.positive', [
            'status_id' => \App\TransferStatusId::PendingApproval,
            'status_title' => 'Pending Approval',
            'status_message' => 'Volunteer has completed the task and is awaiting confirmation of completion',
        ])
        @if($transfer->status === \App\TransferStatusId::InDispute)
            <span class="mx-2 sm:mx-0 sm:my-2 border-b sm:border-b-0 sm:border-l border-gray-200"></span>
            @include('transfers.status.negative', [
                'status_id' => \App\TransferStatusId::InDispute,
                'status_title' => 'In Dispute',
                'status_message' => 'Disagreement between parties which the overseeing charity will solve',
                'status_final' => false,
            ])
        @endif
        <span class="mx-2 sm:mx-0 sm:my-2 border-b sm:border-b-0 sm:border-l border-gray-200"></span>
        @include('transfers.status.positive', [
            'status_id' => \App\TransferStatusId::Approved,
            'status_title' => 'Approved',
            'status_message' => 'Volunteer task completion has been confirmed and payment is being organised',
        ])
        <span class="mx-2 sm:mx-0 sm:my-2 border-b sm:border-b-0 sm:border-l border-gray-200"></span>
        @if($transfer->status !== \App\TransferStatusId::ClosedNonPayment)
            @include('transfers.status.positive', [
                'status_id' => \App\TransferStatusId::Closed,
                'status_title' => 'Closed',
                'status_message' => 'Transfer has been completed successfully and the Volunteer has been paid',
            ])
        @endif
        @if($transfer->status === \App\TransferStatusId::ClosedNonPayment)
            @include('transfers.status.negative', [
                'status_id' => \App\TransferStatusId::ClosedNonPayment,
                'status_title' => 'Closed (Non-Payment)',
                'status_message' => 'Transfer has been closed following a dispute',
                'status_final' => true,
            ])
        @endif
    </div>
</div>
