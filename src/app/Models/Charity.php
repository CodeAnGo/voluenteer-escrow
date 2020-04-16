<?php

namespace App;

use App\Models\Concerns\UsesUUID;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Charity extends Model implements Auditable
{
    use UsesUUID, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'active',
        'api_key',
        'domain'
    ];

    protected $table = 'charities';


}
