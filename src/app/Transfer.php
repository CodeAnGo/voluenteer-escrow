<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SM\Factory\Factory as SMFactory;
use TransferStatus;

class Transfer extends Model
{
    protected $attributes = [
        'status' => TransferStatus::AwaitingAcceptance
    ];

    public function statusStateMachine()
    {
        $factory = new SMFactory(config('state_machine'));

        return $factory->get($this, 'transfer_status');
    }
}
