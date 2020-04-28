<?php

use App\Models\Charity;
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

            Charity::create([
                'name' => $faker->company,
                'active' => true,
                'domain' => 'netcompanyaid',
                'api_key' => 'Zw9SNcS2Oyr9JxnCrp6',
            ]);
        }
    }
}
