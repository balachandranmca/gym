<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', 'API\UserController@login');

Route::middleware('auth:api')->group( function () {
    Route::post('register', 'API\UserController@register');
    Route::put('details', 'API\UserController@details');
    Route::get('getSubscriptionExpire', 'API\DashboardController@getSubscriptionWillExpire');
    Route::get('getSubscriptionExpired', 'API\DashboardController@getSubscriptionExpired');
    Route::get('getBirthDayRemainder', 'API\DashboardController@getBirthDayRemainder');
	Route::resource('subscriptions', 'API\SubscriptionController');
	Route::resource('customers', 'API\CustomerController');
	Route::resource('customersubscriptions', 'API\CustomerSubscriptionController');
	Route::resource('payments', 'API\PaymentController');
});
