<?php

namespace App;

abstract class TransferStatusTransitions
{
    const ToCancelled = 1;
    const ToRejected = 2;
    const ToAwaitingAcceptance = 3;
    const ToAccepted = 4;
    const ToPendingApproval = 5;
    const ToApproved = 6;
    const ToInDispute = 7;
    const ToClosed = 8;
    const ToClosedNonPayment = 9;
}
