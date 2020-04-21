<?php

namespace App\Models;

use App\Models\Concerns\UsesUUID;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use UsesUUID;

    protected $fillable = [
        'transfer_id', 'user_id', 'status'
    ];

    public function transfer() {
        return $this->belongsTo(Transfer::class);
    }
}
