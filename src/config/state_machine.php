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
                'from' => [TransferStatus::Rejected],
                'to' => TransferStatusId::AwaitingAcceptance,
            ],
            TransferStatusTransitions::ToAccepted => [
                'from' => [TransferStatus::AwaitingAcceptance],
                'to' => TransferStatusId::Accepted,
            ],
            TransferStatusTransitions::ToRejected => [
                'from' => [TransferStatus::Accepted],
                'to' => TransferStatusId::Rejected,
            ],
            TransferStatusTransitions::ToCancelled => [
                'from' => [TransferStatus::AwaitingAcceptance, TransferStatus::Accepted, TransferStatus::Rejected],
                'to' => TransferStatusId::Cancelled,
            ],
            TransferStatusTransitions::ToPendingApproval => [
                'from' => [TransferStatus::Accepted],
                'to' => TransferStatusId::PendingApproval,
            ],
            TransferStatusTransitions::ToApproved => [
                'from' => [TransferStatus::PendingApproval],
                'to' => TransferStatusId::Approved,
            ],
            TransferStatusTransitions::ToInDispute => [
                'from' => [TransferStatus::PendingApproval],
                'to' => TransferStatusId::InDispute,
            ],
            TransferStatusTransitions::ToClosed => [
                'from' => [TransferStatus::Approved, TransferStatus::InDispute],
                'to' => TransferStatusId::Closed,
            ],
            TransferStatusTransitions::ToClosedNonPayment => [
                'from' => [TransferStatus::InDispute],
                'to' => TransferStatusId::ClosedNonPayment,
            ],
        ],
    ],
];
