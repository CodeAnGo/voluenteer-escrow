<?php

use App\Transfer;
use App\TransferStatus;
use App\TransferStatusId;
use App\TransferStatusTransitions;

return [
    'transfer_status' => [
        'class' => Transfer::class,

        'property_path' => 'status',

        'states' => [
            TransferStatusId::AwaitingAcceptance,
            TransferStatusId::Accepted,
            TransferStatusId::Rejected,
            TransferStatusId::Cancelled,
            TransferStatusId::PendingApproval,
            TransferStatusId::Approved,
            TransferStatusId::InDispute,
            TransferStatusId::Closed,
            TransferStatusId::ClosedNonPayment,
        ],

        'transitions' => [
            TransferStatusTransitions::ToAwaitingAcceptance => [
                'from' => [TransferStatusId::Rejected],
                'to' => TransferStatusId::AwaitingAcceptance,
            ],
            TransferStatusTransitions::ToAccepted => [
                'from' => [TransferStatusId::AwaitingAcceptance],
                'to' => TransferStatusId::Accepted,
            ],
            TransferStatusTransitions::ToRejected => [
                'from' => [TransferStatusId::Accepted],
                'to' => TransferStatusId::Rejected,
            ],
            TransferStatusTransitions::ToCancelled => [
                'from' => [TransferStatusId::AwaitingAcceptance, TransferStatusId::Accepted, TransferStatusId::Rejected],
                'to' => TransferStatusId::Cancelled,
            ],
            TransferStatusTransitions::ToPendingApproval => [
                'from' => [TransferStatusId::Accepted],
                'to' => TransferStatusId::PendingApproval,
            ],
            TransferStatusTransitions::ToApproved => [
                'from' => [TransferStatusId::PendingApproval],
                'to' => TransferStatusId::Approved,
            ],
            TransferStatusTransitions::ToInDispute => [
                'from' => [TransferStatusId::PendingApproval],
                'to' => TransferStatusId::InDispute,
            ],
            TransferStatusTransitions::ToClosed => [
                'from' => [TransferStatusId::Approved, TransferStatusId::InDispute],
                'to' => TransferStatusId::Closed,
            ],
            TransferStatusTransitions::ToClosedNonPayment => [
                'from' => [TransferStatusId::InDispute],
                'to' => TransferStatusId::ClosedNonPayment,
            ],
        ],
    ],
];
