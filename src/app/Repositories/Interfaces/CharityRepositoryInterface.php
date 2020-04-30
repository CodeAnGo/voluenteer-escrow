<?php
/**
 * Created by PhpStorm.
 * User: lurob
 * Date: 2020-04-30
 * Time: 02:29
 */

namespace App\Repositories\Interfaces;


interface CharityRepositoryInterface
{
    public function getCharityFromId($charity_id);

    public function getAllActiveCharities();
}