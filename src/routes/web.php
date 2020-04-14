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
    return view('welcome');
})->name('home');

Auth::routes();

Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/oauth/redirect', 'Stripe\OAuthRedirectController@onboardingResponse');

Route::get('/onboarding', 'OnBoarding@edit')->name('onboarding.edit')->middleware('auth');
Route::post('/onboarding', 'OnBoarding@store')->name('onboarding.store')->middleware('auth');

Route::resource('transfers', 'TransfersController')->middleware('auth');

Route::resource('transfers.evidence', 'TransferEvidencesController')->except([
    'edit', 'update'
])->middleware(['auth', 'canViewTransferEvidence']);
