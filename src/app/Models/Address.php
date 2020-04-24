<?php

namespace App\Models;

use App\Models\Concerns\UsesUUID;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Address extends Model implements Auditable
{
    use UsesUUID, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'line1',
        'line2',
        'city',
        'county',
        'postcode',
        'country',
    ];
}
