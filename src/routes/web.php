<?php

use App\Mail\TransferGenericMail;
use App\Transfer;
use App\TransferStatus;
use App\TransferStatusTemp;
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
})->name('home');

Auth::routes();

Route::get('/dashboard', 'TransfersController@index')->name('dashboard')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/oauth/redirect', 'Stripe\OAuthRedirectController@onboardingResponse');

Route::get('/onboarding', 'OnBoarding@edit')->name('onboarding.edit')->middleware('auth');
Route::post('/onboarding', 'OnBoarding@store')->name('onboarding.store')->middleware('auth');

Route::resource('transfers', 'TransfersController')->middleware('auth');


// TESTING ROUTES
Route::get('/test', function() {
    $transfer = Transfer::first();
    return view('emails.transfer.generic')->with([
        'sending_party_name' => $transfer['delivery_first_name'],
        'transfer_id' => $transfer->id,
        'transfer_status' => TransferStatusTemp::Rejected
    ]);
});

Route::get('/test1', function() {
    $transfer = Transfer::first();
    return view('emails.transfer.dispute')->with([
            'disputer' => User::where('id', $transfer['receiving_party_id'])->pluck('first_name'),
            'disputee' => $transfer['delivery_first_name'],
            'transfer_id' => $transfer->id,
    ]);
});

