<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'transfer_id', 'user_id', 'status'
    ];

    public function transfer() {
        return $this->belongsTo(Transfer::class);
    }
}
