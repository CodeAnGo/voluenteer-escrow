<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charity extends Model
{
    protected $fillable = [
        'name',
        'active'
    ];

    protected $table = 'charities';


}
