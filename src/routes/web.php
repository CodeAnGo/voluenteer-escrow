<?php

use App\Mail\TransferGenericMail;
use App\Models\Transfer;
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
    return view('landing.index');
})->name('home');

Auth::routes();

Route::get('dashboard', 'DashboardController@index')->name('dashboard')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/oauth/redirect', 'Stripe\OAuthRedirectController@onboardingResponse');

Route::get('/onboarding', 'OnBoarding@edit')->name('onboarding.edit')->middleware('auth');
Route::post('/onboarding', 'OnBoarding@store')->name('onboarding.store')->middleware('auth');

Route::get('/notification/{transfer_id}', 'Notification@delete')->name('notification.delete');

Route::resource('transfers', 'TransfersController')->middleware('auth');



// TESTING ROUTES
Route::get('/test', function() {
    $transfer = Transfer::first();
    return view('emails.transfer.generic')->with([
        'sending_party_name' => $transfer['delivery_first_name'],
        'transfer_id' => $transfer->id,
        'status' => 'Accepted'
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


Route::resource('transfers.evidence', 'TransferEvidencesController')->except([
    'edit', 'update'
])->middleware(['auth', 'canViewTransferEvidence']);

Route::get('/profile', 'UserProfile@index')->name('profile.index')->middleware('auth');
Route::get('/profile/edit', 'UserProfile@edit')->name('profile.edit')->middleware('auth');
Route::put('/profile/edit', 'UserProfile@update')->name('profile.update')->middleware('auth');

Route::resource('addresses', 'UserAddress')->middleware('auth');

