<?php

namespace App;

use App\Models\Account;
use App\Models\Address;
use App\Models\Concerns\UsesUUID;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Notification;

class User extends Authenticatable implements Auditable
{
    use UsesUUID, Notifiable, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'volunteer', 'Phone Number','Street Address 1',
        'Street Address 2','Street Address 3','City','Postcode',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function account(){
        return $this->hasOne(Account::class);
    }

    public function getName(){
        return $this->first_name . " " . $this->last_name;
    }

    public function addresses(){
        return $this->hasMany(Address::class);
    }
}
