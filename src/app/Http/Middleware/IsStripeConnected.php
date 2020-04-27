<?php

namespace App\Http\Middleware;

use App\Models\Account;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsStripeConnected
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
        if (Auth::check()){
            if (Account::where('user_id', Auth::id())->count() > 0){
                return $next($request);
            } else {
                return redirect('https://connect.stripe.com/express/oauth/authorize?client_id=ca_H1XhDNnf1jkjAcXOBHhEqNpPLtUwuVwI&state=' . csrf_token() . '&stripe_user[email]=' . Auth::user()->email);
            }
        } else {
            return redirect('/login');
        }
    }
}
