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

Route::any('result/payment','HomeController@ResultPayment')->name('PaymentResult');
Route::any('account/result/payment','HomeController@AccountPaymentResult')->name('AccountPaymentResult');
