<?php

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
Route::get('/oauth/redirect', 'Stripe\OAuthRedirectController@onboardingResponse')->middleware('auth');

Route::middleware(['auth', 'striped'])->group(function (){

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');


    Route::get('/onboarding', 'OnBoarding@edit')->name('onboarding.edit');
    Route::post('/onboarding', 'OnBoarding@store')->name('onboarding.store');

    Route::resource('transfers', 'TransfersController')->middleware('auth');
    Route::post('transfers/{transfer}/status/{id}', 'TransfersController@statusUpdate')->name('transfers.update.status');

    Route::resource('transfers.evidence', 'TransferEvidencesController')->except([
        'edit', 'update'
    ])->middleware(['canViewTransferEvidence']);

    Route::resource('transfers.dispute', 'TransferDisputesController')->except([
        'edit', 'update'
    ]);

    Route::get('/profile', 'UserProfile@index')->name('profile.index');
    Route::get('/profile/edit', 'UserProfile@edit')->name('profile.edit');
    Route::put('/profile/edit', 'UserProfile@update')->name('profile.update');

    Route::resource('addresses', 'UserAddress');

    Route::get('/notification/{transfer_id}', 'Notification@delete')->name('notification.delete');
});

Route::get('logout', function() {
    Auth::logout();
    return redirect()->route('home');
});


