<?php

namespace App;

abstract class TransferStatusTransitions
{
    const ToCancelled = 1;
    const ToRejected = 2;
    const ToAwaitingAcceptance = 3;
    const ToAccepted = 4;
    const ToPendingApproval = 5;
    const ToInDispute = 6;
    const ToApproved = 7;
    const ToClosed = 8;
    const ToClosedNonPayment = 9;
}
