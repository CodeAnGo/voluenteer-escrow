<?php

namespace App;

abstract class TransferStatusTransitions
{
    const ToAwaitingAcceptance = 1;
    const ToAccepted = 2;
    const ToRejected = 3;
    const ToCancelled = 4;
    const ToPendingApproval = 5;
    const ToApproved = 6;
    const ToInDispute = 7;
    const ToClosed = 8;
    const ToClosedNonPayment = 9;
}
