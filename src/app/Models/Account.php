<?php

namespace App\Models\Stripe;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

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
