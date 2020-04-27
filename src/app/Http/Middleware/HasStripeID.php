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
        $account = Account::where('user_id', Auth::id())->first();
        if ($account === null) {
            return redirect('stripe_continue');
        }
        return $next($request);
    }
}
