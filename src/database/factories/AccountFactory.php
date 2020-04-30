<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\Account;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Account::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'access_token' => 'sk_test_dv34RVgDbUTYj80hzPFm7RU2002JCGEwyH',
        'refresh_token' => 'rt_H91hbQTr3nWbKZWvKdmTgKDbEaHyO4eEe2JVrrZgXZxNtywc',
        'token_type' => 'bearer',
        'stripe_publishable_key' => 'pk_test_3d9LYi0e4VD80ez0flBhogn500haGoqt8M',
        'stripe_user_id' => 'acct_1GajczAYVdl4P1A7',
        'scope' => 'express'
    ];
});
