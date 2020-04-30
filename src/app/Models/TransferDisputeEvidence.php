<?php

namespace App\Models;

use App\Models\Concerns\UsesUUID;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TransferDisputeEvidence extends Model implements Auditable
{
    use UsesUUID, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'transfer_id',
        'user_id',
        'transfer_dispute_id',
        'path'
    ];

    protected $table = 'transfer_dispute_evidences';

    public function transferDispute() {
        return $this->belongsTo(TransferDispute::class);
    }
}
