<?php

namespace App\Models;

use App\Models\Concerns\Statable;
use App\Models\Concerns\UsesUUID;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Transfer extends Model implements Auditable
{
    use UsesUUID, \OwenIt\Auditing\Auditable, Statable;

    protected $fillable = [
        'sending_party_id',
        'receiving_party_id',
        'charity_id',
        'delivery_first_name',
        'delivery_last_name',
        'delivery_email',
        'delivery_country',
        'delivery_street',
        'delivery_city',
        'delivery_county',
        'delivery_postcode',
        'charity_id',
        'transfer_amount',
        'transfer_reason',
        'transfer_note',
        'approval_note',
        'actual_amount',
        'status',
        'stripe_id',
        'stripe_payment_intent',
        'freshdesk_id',
      'transfer_group'
    ];

    const SM_CONFIG = 'transfer';
}
