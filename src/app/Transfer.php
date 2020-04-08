<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'sending_user', 'receiving_user', 'created_date', 'status'
    ];
}
