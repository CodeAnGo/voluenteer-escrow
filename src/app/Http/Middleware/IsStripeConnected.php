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
                $user = Auth::user();
                $url = 'https://connect.stripe.com/express/oauth/authorize?client_id=ca_H1XhDNnf1jkjAcXOBHhEqNpPLtUwuVwI&state='. csrf_token()
                    ."&stripe_user[email]=$user->email"
                    ."&stripe_user[first_name]=$user->first_name"
                    ."&stripe_user[last_name]=$user->last_name"
                    ."&stripe_user[url]=netcompany.com"
                    ."&stripe_user[country]=GB"
                    ."&stripe_user[business_type]=individual";
                return redirect($url);
            }
        } else {
            return redirect('/login');
        }
    }
}
