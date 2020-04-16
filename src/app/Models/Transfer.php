<?php

namespace App\Models;

use App\Models\Concerns\UsesUUID;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;
use SM\Factory\Factory as SMFactory;

class Transfer extends Model implements Auditable
{
    use UsesUUID, \OwenIt\Auditing\Auditable;

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
