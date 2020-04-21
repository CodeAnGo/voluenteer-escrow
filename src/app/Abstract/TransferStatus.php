<?php

namespace App;

abstract class TransferStatus
{
    const Cancelled = "Cancelled";
    const Rejected = "Rejected";
    const AwaitingAcceptance = "Awaiting Acceptance";
    const Accepted = "Accepted";
    const PendingApproval = "Pending Approval";
    const Approved = "Approved";
    const InDispute = "In Dispute";
    const Closed = "Closed";
    const ClosedNonPayment = "Closed (Non Payment)";
}
