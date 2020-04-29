<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Generator as Faker;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $faker = new Faker();

        $this->browse(function ($browser) use ($faker) {
            $browser->visit('/register')
                ->type('fname', $faker->firstName)
                ->type('lname', $faker->lastName)
                ->type('email', $faker->unique()->safeEmail)
                ->type('password', 'password')
                ->type('password-confirm', 'password')
                ->press('register_btn')
                ->assertPathIsNot('/login')
                ->assertAuthenticated();
        });
    }
}
