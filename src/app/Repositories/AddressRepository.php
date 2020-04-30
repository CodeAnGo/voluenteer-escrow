<?php
/**
 * Created by PhpStorm.
 * User: lurob
 * Date: 2020-04-30
 * Time: 02:31
 */

namespace App\Repositories;


use App\Models\Address;
use App\Repositories\Interfaces\AddressRepositoryInterface;

class AddressRepository implements AddressRepositoryInterface
{

    public function getAddressFromId($address_id)
    {
        return Address::where('id', $address_id)->first();
    }
}