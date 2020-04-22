<?php

namespace App\Models;

use App\Models\Concerns\UsesUUID;
use Illuminate\Database\Eloquent\Model;

class UserCharity extends Model
{
    use usesUUID;

    protected $fillable = [
        'user_id', 'charity_id'
    ];
}
