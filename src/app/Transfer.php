<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SM\Factory\Factory as SMFactory;

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
        'charity_id',
        'transfer_amount',
        'transfer_reason',
        'transfer_note',
        'status',
        'stripe_id',
    ];

    public function statusStateMachine()
    {
        $factory = new SMFactory(config('state_machine'));

        return $factory->get($this, 'transfer_status');
    }
}
