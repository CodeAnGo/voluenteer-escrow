<?php

namespace App\Models;

use App\Models\Concerns\Statable;
use App\Models\Concerns\UsesUUID;
use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Audit;
use OwenIt\Auditing\Contracts\Auditable;

class Transfer extends Model implements Auditable
{
    use UsesUUID, \OwenIt\Auditing\Auditable, Statable;

    protected $fillable = [
        'sending_party_id',
        'receiving_party_id',
        'delivery_first_name',
        'delivery_last_name',
        'delivery_email',
        'delivery_phone',
        'delivery_street_1',
        'delivery_street_2',
        'delivery_city',
        'delivery_county',
        'delivery_postcode',
        'delivery_country',
        'charity_id',
        'transfer_amount',
        'transfer_reason',
        'transfer_note',
        'approval_note',
        'actual_amount',
        'status',
        'stripe_id',
        'stripe_payment_intent',
        'stripe_transfer_id',
        'freshdesk_id',
        'transfer_group'
    ];

    const SM_CONFIG = 'transfer';

    public function charity(){
        return $this->belongsTo(Charity::class);
    }

    public function sendingParty(){
        return $this->belongsTo(User::class, 'sending_party_id');
    }

    public function receivingParty(){
        return $this->belongsTo(User::class, 'receiving_party_id');
    }

    public function transferFile() {
        return $this->hasMany(TransferFile::class);
    }
}
