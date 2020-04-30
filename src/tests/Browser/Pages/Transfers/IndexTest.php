<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Assert;
use Tests\DuskTestCase;
use App\Models\Account;

class IndexTest extends DuskTestCase
{
//    use RefreshDatabase;

    public function testIncorrectTransferUrlUnableToDisplay()
    {
        $account = factory(Account::class)->create();
        $user = User::where('id', $account->user_id)->first();

        // Correct login
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('login_btn');

            $browser->visit('/transfers/dqqwdqw')
                ->assertSee("Unable to display");

            $browser->visit('logout');
        });
    }

    public function testCreateTransfer(){
        $account = factory(Account::class)->create();
        $user = User::where('id', $account->user_id)->first();

        // Correct login
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('login_btn');

            $browser->visit('/transfers')
                ->assertSee("No Active Transfers")
                ->assertSeeLink("Create Transfer")
                ->clickLink('Create Transfer')
                ->assertPathIs('/transfers/create');

            $browser->assertSee("Create Address");

            $browser->visit('logout');
        });
    }

    public function testCreateTransferNotShownAsVolunteer(){
        $account = factory(Account::class)->create();
        $user = User::where('id', $account->user_id)->first();

        // Correct login
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('login_btn');

            $browser->visit('/transfers')
                ->assertSee("Create Transfer");

            $user->volunteer = true;
            $user->save();

            $browser->visit('/transfers')
                ->assertDontSee("Create Transfer");

            $browser->visit('logout');
        });
    }
}
