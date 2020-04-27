<?php

namespace App;

abstract class TransferStatusTransitions
{
    const ToCancelled = 1;
    const ToRejected = 2;
    const ToAwaitingAcceptance = 3;
    const ToAccepted = 4;
    const ToDeclined = 5;
    const ToPendingApproval = 6;
    const ToInDispute = 7;
    const ToApproved = 8;
    const ToClosed = 9;
    const ToClosedNonPayment = 10;
}
