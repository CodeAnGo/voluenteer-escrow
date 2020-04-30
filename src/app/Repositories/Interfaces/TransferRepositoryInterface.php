<?php
/**
 * Created by PhpStorm.
 * User: lurob
 * Date: 2020-04-30
 * Time: 02:05
 */

namespace App\Repositories\Interfaces;


use App\Models\Charity;
use App\Models\Transfer;
use App\TransferStatusId;
use App\User;

interface TransferRepositoryInterface
{
    public function getTransferFromID($transfer_id);

    public function getAllTransfersForUser(User $user, $activeOnly=false);

    public function createTransfer(User $sendingParty, Charity $charity, $deliveryFirstName,
                                   $deliveryLastName, $deliveryEmail, $deliveryPhone,
                                   $deliveryStreet1, $deliveryCity, $deliveryPostCode,
                                   $deliveryCountry, $transferAmount, $transferReason,
                                   $status, $transferNote=null, $stripePaymentIntent=null,
                                   $actualAmount=null, $approvalNote=null, $stripeId=null,
                                   $freshdeskId=null, $transferGroup=null, $deliveryStreet2=null,
                                   $deliveryCounty=null, User $receivingParty=null, $stripeTransferId=null);

    public function getAllTransfersOfStatus($transferStatus);

}