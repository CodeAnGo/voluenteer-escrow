<?php

use App\Mail\TransferAcceptedMail;
use App\Transfer;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/oauth/redirect', 'Stripe\OAuthRedirectController@onboardingResponse');

Route::resource('transfers', 'TransfersController')->middleware('auth');


// TESTING ROUTES
Route::get('/test', function() {
    $transfer = Transfer::first();
    return view('emails.transfer.accepted')->with([
        'sending_party_name' => $transfer['delivery_first_name'],
        'receiving_party_name' => User::where('id', $transfer['receiving_party_id'])->pluck('first_name')
    ]);
});

Route::get('/test1', function() {
    $transfer = Transfer::first();
    return view('emails.transfer.dispute')->with([
            'disputer' => User::where('id', $transfer['receiving_party_id'])->pluck('first_name'),
            'disputee' => $transfer['delivery_first_name']
    ]);
});
