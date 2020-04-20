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
        'delivery_town',
        'delivery_postcode',
        'charity_id',
        'transfer_amount',
        'transfer_reason',
        'transfer_note',
        'status',
        'stripe_id',
        'freshdesk_id'
    ];

    const SM_CONFIG = 'transfer';
}
