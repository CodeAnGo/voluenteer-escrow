<?php
/**
 * Created by PhpStorm.
 * User: lurob
 * Date: 2020-04-30
 * Time: 02:29
 */

namespace App\Repositories;


use App\Models\Charity;
use App\Repositories\Interfaces\CharityRepositoryInterface;

class CharityRepository implements CharityRepositoryInterface
{

    public function getCharityFromId($charity_id)
    {
        return Charity::where('id', $charity_id)->first();
    }

    public function getAllActiveCharities()
    {
        return Charity::where('active', true)->orderBy('name', 'asc')->get();
    }
}