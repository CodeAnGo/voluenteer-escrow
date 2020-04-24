<?php

use App\Models\Account;
use App\Models\Charity;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $indiv = User::create([
            'first_name' => 'Indiv',
            'last_name' => 'Idual',
            'email' => 'test@test.com',
            'password' => '$2y$10$Nq8jXmAkT/He0YRSwoiVxuehHKDhl5ro4EcwdUy6mRlLZT4xkfijG',
            'volunteer' => false
        ]);

        Account::create([
            'user_id' => $indiv->id,
            'access_token' => 'sk_test_dv34RVgDbUTYj80hzPFm7RU2002JCGEwyH',
            'refresh_token' => 'rt_H91hbQTr3nWbKZWvKdmTgKDbEaHyO4eEe2JVrrZgXZxNtywc',
            'token_type' => 'bearer',
            'stripe_publishable_key' => 'pk_test_3d9LYi0e4VD80ez0flBhogn500haGoqt8M',
            'stripe_user_id' => 'acct_1GajczAYVdl4P1A7',
            'scope' => 'express'
        ]);

        $volun = User::create([
            'first_name' => 'Volun',
            'last_name' => 'Teer',
            'email' => 'volun@test.com',
            'password' => '$2y$10$Nq8jXmAkT/He0YRSwoiVxuehHKDhl5ro4EcwdUy6mRlLZT4xkfijG',
            'volunteer' => true
        ]);

        Account::create([
            'user_id' => $volun->id,
            'access_token' => 'sk_test_dv34RVgDbUTYj80hzPFm7RU2002JCGEwyH',
            'refresh_token' => 'rt_H91hbQTr3nWbKZWvKdmTgKDbEaHyO4eEe2JVrrZgXZxNtywc',
            'token_type' => 'bearer',
            'stripe_publishable_key' => 'pk_test_3d9LYi0e4VD80ez0flBhogn500haGoqt8M',
            'stripe_user_id' => 'acct_1GajczAYVdl4P1A7',
            'scope' => 'express'
        ]);

    }

}
