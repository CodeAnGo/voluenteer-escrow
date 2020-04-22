<?php

namespace App;

abstract class TransferStatusId
{
    const Cancelled = 1;
    const Rejected = 2;
    const AwaitingAcceptance = 3;
    const Accepted = 4;
    const PendingApproval = 5;
    const InDispute = 6;
    const Approved = 7;
    const Closed = 8;
    const ClosedNonPayment = 9;
}
