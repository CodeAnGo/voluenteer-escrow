<?php

namespace App\Models;

use App\Models\Concerns\Statable;
use App\Models\Concerns\UsesUUID;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TransferDispute extends Model implements Auditable
{
    use UsesUUID, \OwenIt\Auditing\Auditable, Statable;

    protected $fillable = [
        'transfer_id',
        'user_id',
        'dispute_reason'
    ];

    protected $table = 'transfer_disputes';
}
