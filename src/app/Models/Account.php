<?php

namespace App\Models\Stripe;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Account extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'access_token',
        'refresh_token',
        'token_type',
        'stripe_publishable_key',
        'stripe_user_id',
        'scope',
    ];
}
