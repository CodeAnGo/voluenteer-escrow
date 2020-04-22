<?php

namespace App;

abstract class TransferStatus
{
    const Cancelled = "Cancelled";
    const Rejected = "Rejected";
    const AwaitingAcceptance = "Awaiting Acceptance";
    const Accepted = "Accepted";
    const PendingApproval = "Pending Approval";
    const InDispute = "In Dispute";
    const Approved = "Approved";
    const Closed = "Closed";
    const ClosedNonPayment = "Closed (Non Payment)";
}


