<?php
/**
 * Created by PhpStorm.
 * User: lurob
 * Date: 2020-04-30
 * Time: 02:05
 */

namespace App\Repositories;


use App\Models\Charity;
use App\Models\Transfer;
use App\Repositories\Interfaces\TransferRepositoryInterface;
use App\TransferStatus;
use App\TransferStatusId;
use App\User;

class TransferRepository implements TransferRepositoryInterface
{

    public function getTransferFromID($transfer_id)
    {
        return Transfer::where('id', $transfer_id)->first();
    }

    public function getAllTransfersForUser(User $user, $activeOnly=false)
    {
        if($activeOnly){
            return Transfer::where('sending_party_id', $user->id)
                ->orWhere('receiving_party_id', $user->id)
                ->whereNotIn('status', [
                    TransferStatusId::Cancelled,
                    TransferStatusId::Closed,
                    TransferStatusId::ClosedNonPayment,
                    TransferStatusId::Rejected,
                    TransferStatusId::InDispute,
                    TransferStatusId::Declined
                ])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            return Transfer::where('sending_party_id', $user->id)
                ->orWhere('receiving_party_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function createTransfer(User $sendingParty, Charity $charity, $deliveryFirstName, $deliveryLastName, $deliveryEmail, $deliveryPhone, $deliveryStreet1, $deliveryCity, $deliveryPostCode, $deliveryCountry, $transferAmount, $transferReason, $status, $transferNote = null, $stripePaymentIntent = null, $actualAmount = null, $approvalNote = null, $stripeId = null, $freshdeskId = null, $transferGroup = null, $deliveryStreet2 = null, $deliveryCounty = null, User $receivingParty=null)
    {
        return Transfer::create([
            'sending_party_id' => $sendingParty->id,
            'receiving_party_id' => (is_null($receivingParty)) ? null : $receivingParty->id,
            'charity_id' => $charity->id,
            'delivery_first_name' => $deliveryFirstName,
            'delivery_last_name' => $deliveryLastName,
            'delivery_email' => $deliveryEmail,
            'delivery_phone' => $deliveryPhone,
            'delivery_street_1' => $deliveryStreet1,
            'delivery_street_2' => $deliveryStreet2,
            'delivery_city' => $deliveryCity,
            'delivery_county' => $deliveryCounty,
            'delivery_postcode' => $deliveryPostCode,
            'delivery_country' => $deliveryCounty,
            'transfer_amount' => $transferAmount,
            'transfer_reason' => $transferReason,
            'transfer_note' => $transferNote,
            'approval_note' => $approvalNote,
            'actual_amount' => $actualAmount,
            'status' => $status,
            'stripe_id' => $stripeId,
            'stripe_payment_intent' => $stripePaymentIntent,
            'freshdesk_id' => $freshdeskId,
            'transfer_group' => $transferGroup
        ]);
    }
}