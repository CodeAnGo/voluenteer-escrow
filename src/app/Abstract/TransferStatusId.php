<?php

namespace App;

abstract class TransferStatusId
{
    const AwaitingAcceptance = 1;
    const Accepted = 2;
    const Rejected = 3;
    const Cancelled = 4;
    const PendingApproval = 5;
    const Approved = 6;
    const InDispute = 7;
    const Closed = 8;
    const ClosedNonPayment = 9;
}
