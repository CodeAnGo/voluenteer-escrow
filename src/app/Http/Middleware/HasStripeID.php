<?php

namespace App\Http\Middleware;

use App\Models\Account;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HasStripeID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $User = User::where('id', Auth::id())->first();
        $Account = Account::where('user_id', Auth::id())->first();
        if ($Account === null) {
            return Redirect::intended('https://connect.stripe.com/express/oauth/authorize?client_id=ca_H1XhDNnf1jkjAcXOBHhEqNpPLtUwuVwI&state='. csrf_token() .'&stripe_user[email]='.$User->email);
        }
    }
}
