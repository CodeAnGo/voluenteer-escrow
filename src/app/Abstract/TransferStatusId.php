<?php

namespace App;

abstract class TransferStatusId
{
    const Cancelled = 1;
    const Rejected = 2;
    const AwaitingAcceptance = 3;
    const Accepted = 4;
    const Declined = 5;
    const PendingApproval = 6;
    const InDispute = 7;
    const Approved = 8;
    const Closed = 9;
    const ClosedNonPayment = 10;
}
