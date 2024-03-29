<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $url = 'https://connect.stripe.com/express/oauth/authorize?client_id=ca_H1XhDNnf1jkjAcXOBHhEqNpPLtUwuVwI&state='. csrf_token()
        ."&stripe_user[email]=${data['email']}"
        ."&stripe_user[first_name]=${data['fname']}"
        ."&stripe_user[last_name]=${data['lname']}"
        ."&stripe_user[url]=netcompany.com"
        ."&stripe_user[country]=GB"
        ."&stripe_user[business_type]=individual";

        $this->redirectTo = $url;

        return User::create([
            'first_name' => $data['fname'],
            'last_name' => $data['lname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'volunteer' => array_key_exists("volunteercheck", $data)
        ]);
    }
}
