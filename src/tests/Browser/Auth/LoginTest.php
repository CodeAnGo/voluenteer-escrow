<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Assert;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = factory(User::class)->create();

        // Correct login
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('login_btn')
                ->assertPathIsNot('/login')
                ->assertAuthenticated()
                ->assertAuthenticatedAs($user);

            $browser->visit('logout');

            // Wrong email
            $browser->visit('/login')
                ->type('email', 'wrong_email@test.com')
                ->type('password', 'password')
                ->press('login_btn')
                ->assertGuest();

            // Wrong password
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'wrong_password')
                ->press('login_btn')
                ->assertGuest();


            // Wrong email and password
            $browser->visit('/login')
                ->type('email', 'wrong_email@test.com')
                ->type('password', 'wrong_password')
                ->press('login_btn')
                ->assertGuest();

            $browser->visit('/login')
                ->assertSeeLink('Forgot your password?')
                ->clickLink('Forgot your password?')
                ->assertPathIs('/password/reset');

            $browser->visit('/login')
                ->assertSeeLink("Don\'t have an account? Register here")
                ->clickLink("Don\'t have an account? Register here")
                ->assertPathIs('/register');
        });


    }
}
