<?php

use App\Transfer;
use App\TransferStatus;
use App\TransferStatusTransitions;

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
            TransferStatusTransitions::ToAwaitingAcceptance => [
                'from' => [TransferStatus::Rejected],
                'to' => TransferStatus::AwaitingAcceptance,
            ],
            TransferStatusTransitions::ToAccepted => [
                'from' => [TransferStatus::AwaitingAcceptance],
                'to' => TransferStatus::Accepted,
            ],
            TransferStatusTransitions::ToRejected => [
                'from' => [TransferStatus::Accepted],
                'to' => TransferStatus::Rejected,
            ],
            TransferStatusTransitions::ToCancelled => [
                'from' => [TransferStatus::AwaitingAcceptance, TransferStatus::Accepted, TransferStatus::Rejected],
                'to' => TransferStatus::Cancelled,
            ],
            TransferStatusTransitions::ToPendingApproval => [
                'from' => [TransferStatus::Accepted],
                'to' => TransferStatus::PendingApproval,
            ],
            TransferStatusTransitions::ToApproved => [
                'from' => [TransferStatus::PendingApproval],
                'to' => TransferStatus::Approved,
            ],
            TransferStatusTransitions::ToInDispute => [
                'from' => [TransferStatus::PendingApproval],
                'to' => TransferStatus::InDispute,
            ],
            TransferStatusTransitions::ToClosed => [
                'from' => [TransferStatus::Approved, TransferStatus::InDispute],
                'to' => TransferStatus::Closed,
            ],
            TransferStatusTransitions::ToClosedNonPayment => [
                'from' => [TransferStatus::InDispute],
                'to' => TransferStatus::ClosedNonPayment,
            ],
        ],
    ],
];
