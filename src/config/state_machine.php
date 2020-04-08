<?php

use App\Transfer;

return [
    'transfer_status' => [
        'class' => Transfer::class,

        'property_path' => 'status',

        'states' => [
            TransferStatus::AwaitingAcceptance,
            TransferStatus::Accepted,
            TransferStatus::Rejected,
            TransferStatus::Cancelled,
            TransferStatus::PendingApproval,
            TransferStatus::Approved,
            TransferStatus::InDispute,
            TransferStatus::Closed,
            TransferStatus::ClosedNonPayment,
        ],

        'transitions' => [
            'to_awaiting_acceptance' => [
                'from' => [TransferStatus::Rejected],
                'to' => TransferStatus::AwaitingAcceptance,
            ],
            'to_accepted' => [
                'from' => [TransferStatus::AwaitingAcceptance],
                'to' => TransferStatus::Accepted,
            ],
            'to_rejected' => [
                'from' => [TransferStatus::Accepted],
                'to' => TransferStatus::Rejected,
            ],
            'to_cancelled' => [
                'from' => [TransferStatus::AwaitingAcceptance, TransferStatus::Accepted, TransferStatus::Rejected],
                'to' => TransferStatus::Cancelled,
            ],
            'to_pending_approval' => [
                'from' => [TransferStatus::Accepted],
                'to' => TransferStatus::PendingApproval,
            ],
            'to_approved' => [
                'from' => [TransferStatus::PendingApproval],
                'to' => TransferStatus::Approved,
            ],
            'to_in_dispute' => [
                'from' => [TransferStatus::PendingApproval],
                'to' => TransferStatus::InDispute,
            ],
            'to_close' => [
                'from' => [TransferStatus::Approved, TransferStatus::InDispute],
                'to' => TransferStatus::Closed,
            ],
            'to_closed_non_payment' => [
                'from' => [TransferStatus::InDispute],
                'to' => TransferStatus::ClosedNonPayment,
            ],
        ],
    ],
];
