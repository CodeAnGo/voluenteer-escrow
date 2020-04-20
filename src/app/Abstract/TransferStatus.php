<?php

namespace App;

abstract class TransferStatus
{
    const AwaitingAcceptance = "Awaiting Acceptance";
    const Accepted = "Accepted";
    const Rejected = "Rejected";
    const Cancelled = "Cancelled";
    const PendingApproval = "Pending Approval";
    const Approved = "Approved";
    const InDispute = "In Dispute";
    const Closed = "Closed";
    const ClosedNonPayment = "Closed (Non Payment)";
}


