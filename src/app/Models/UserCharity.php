<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCharity extends Model
{
    protected $fillable = [
        'user_id', 'charity_id'
    ];
}
