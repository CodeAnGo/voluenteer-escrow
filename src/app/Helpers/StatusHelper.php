<?php
/**
 * Created by PhpStorm.
 * User: lurob
 * Date: 2020-04-30
 * Time: 02:59
 */

namespace App\Helpers;


use App\TransferStatus;
use App\TransferStatusId;

trait StatusHelper
{
    public function getClosedStatus(){
        return [
            TransferStatusId::Cancelled,
            TransferStatusId::Closed,
            TransferStatusId::ClosedNonPayment,
            TransferStatusId::Rejected,
            TransferStatusId::InDispute,
            TransferStatusId::Declined
        ];
    }

    public function getStatusMap(){
        $reflection = new \ReflectionClass(TransferStatus::class);
        $status_map = array('Unable to get Status');
        foreach ($reflection->getConstants() as $value){
            array_push($status_map, $value);
        }
        return $status_map;
    }
}