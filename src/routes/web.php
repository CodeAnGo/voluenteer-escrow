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

Route::get('dashboard', 'DashboardController@index')->name('dashboard')->middleware('auth','hasStripeId');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/oauth/redirect', 'Stripe\OAuthRedirectController@onboardingResponse');

Route::get('/onboarding', 'OnBoarding@edit')->name('onboarding.edit')->middleware('auth');
Route::post('/onboarding', 'OnBoarding@store')->name('onboarding.store')->middleware('auth');

Route::resource('transfers', 'TransfersController')->middleware('auth','hasStripeId');

Route::resource('transfers.evidence', 'TransferEvidencesController')->except([
    'edit', 'update'
])->middleware(['auth', 'canViewTransferEvidence']);

Route::get('/profile', 'UserProfile@index')->name('profile.index')->middleware('auth','hasStripeId');
Route::get('/profile/edit', 'UserProfile@edit')->name('profile.edit')->middleware('auth');
Route::put('/profile/edit', 'UserProfile@update')->name('profile.update')->middleware('auth');

Route::resource('addresses', 'UserAddress')->middleware('auth');

Route::get('stripe_continue', function() {
    return view('auth.stripe_continue');
});
