<?php

use Illuminate\Database\Seeder;

class CharitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ([1,2,3,4,5,6,7,8,9] as $i){
            $faker = Faker\Factory::create();

            \App\Models\Charity::create([
                'name' => $faker->company,
                'active' => true
            ]);
        }
    }
}
