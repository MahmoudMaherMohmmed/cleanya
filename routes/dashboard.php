<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register dashboard routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){ 
    Route::get('/home', 'HomeController@home')->name('home');
    Route::resource('users', 'UserController');
    Route::resource('clients', 'ClientController');
    Route::resource('addresses', 'AddressController')->only(['index', 'show']);
    Route::resource('representatives', 'RepresentativeController');
    Route::resource('clothes', 'ClothController');
    Route::resource('services', 'ServiceController');
    Route::resource('coupons', 'CouponController');
    Route::resource('reservations', 'ReservationController')->except(['create', 'store']);
    Route::post('reservations/{id}/representative', 'ReservationController@representative')->name('reservations.update.representative');
    Route::get('reservations/{id}/invoice', 'ReservationController@invoice')->name('reservations.invoice');
    Route::resource('application', 'ApplicationController');
    Route::resource('bank-accounts', 'BankAccountController');
    Route::resource('bank-transfers', 'BankTransferController');
    Route::post('bank-transfers/{id}/update/status', 'BankTransferController@updateStatus')->name('bank-transfers.update.status');	
    Route::resource('cities', 'CityController');
    Route::resource('neighborhoods', 'NeighborhoodController');
    Route::resource('terms-and-conditions', 'TermController');
    Route::resource('notifications', 'NotificationController');
    Route::resource('sliders', 'SliderController');
    Route::resource('contact-messages', 'ContactMessageController');
});
