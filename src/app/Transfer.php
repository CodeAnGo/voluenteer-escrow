<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
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
        'transfer_amount',
        'transfer_reason',
        'transfer_note',
        'status',
        'stripe_id',
        'escrow_link'
    ];
}
