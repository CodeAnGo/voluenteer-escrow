<?php
/**
 * Created by PhpStorm.
 * User: lurob
 * Date: 2020-04-30
 * Time: 02:31
 */

namespace App\Repositories\Interfaces;


interface AddressRepositoryInterface
{
    public function getAddressFromId($address_id);
}