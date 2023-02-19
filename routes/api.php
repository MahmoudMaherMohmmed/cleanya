<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* |-------------------------------------------------------------------------- | API Routes |-------------------------------------------------------------------------- | | Here is where you can register API routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | is assigned the "api" middleware group. Enjoy building your API! | */

Route::middleware('localization')->namespace('Api')->group(function () {
    Route::get('cities', 'CityController@index');
    Route::post('register', 'ClientController@register');
    Route::post('login', 'ClientController@login');
    Route::post('profile/forget_password', 'ClientController@forgetPassword');
    Route::post('profile/resend_code', 'ClientController@resendCode');
    Route::post('neighborhood/check', 'NeighborhoodController@check');
    Route::get('application', 'ApplicationController@application');
    Route::get('softopening', 'ApplicationController@softOpening');
    Route::get('sliders', 'ApplicationController@sliders');
    Route::get('terms_and_conditions', 'ApplicationController@termsAndConditions');
    Route::post('contact', 'ApplicationController@contact');
    Route::get('banks', 'BankAccountController@index');

    //Services
    Route::get('services', 'ServiceController@index');
    Route::get('service/{service}/show', 'ServiceController@show');

    Route::post('appointments/receipt', 'AppointmentController@index');
    Route::post('appointments/sending', 'AppointmentController@index');

    Route::middleware('auth:api')->group(function () {
        Route::post('profile/verify_code', 'ClientController@verifyCode');
        Route::post('profile/change_password', 'ClientController@changePassword');
        Route::get('profile', 'ClientController@profile');
        Route::post('profile/update', 'ClientController@UpdateProfile');
        Route::post('profile/update/image', 'ClientController@updateProfileImage');
        Route::post('profile/update_password', 'ClientController@updatePassword');
        Route::post('balance/add', 'ClientController@addBalance');
        Route::get('balance', 'ClientController@balance');
        Route::get('transactions', 'ClientController@transactions');
        Route::post('logout', 'ClientController@logout');
        Route::post('profile/delete', 'ClientController@delete');

        //Client Addresses
        Route::get('client/addresses', 'AddressController@index');
        Route::post('client/address/store', 'AddressController@store');
        Route::get('client/address/{address}', 'AddressController@show');
        Route::post('client/address/{address}/update', 'AddressController@update');
        Route::post('client/address/delete', 'AddressController@delete');

        //Client notifications
        Route::get('notifications', 'NotificationController@index');
        Route::post('notification/delete', 'NotificationController@delete');

        //Reservations
        Route::post('reservation/store', 'ReservationController@store');
        Route::get('reservation/{reservation}/cancel', 'ReservationController@cancel');
        Route::post('reservation/{id}/review', 'ReservationController@review');
        Route::post('coupon/apply', 'CouponController@apply');
        Route::get('reservation/{reservation}/complete', 'ReservationController@complete');
        route::get('reservations/current', 'ReservationController@current');
        route::get('reservations/finished', 'ReservationController@finished');
        route::get('reservations/cancelled', 'ReservationController@cancelled');
        Route::get('reservation/{reservation}/show', 'ReservationController@show');

        //Representative Reservations
        route::post('representative/reservations/status/{reservation}/update', 'RepresentativeReservationController@updateStatus');
        route::get('representative/reservations/in_receive', 'RepresentativeReservationController@InReceive');
        route::get('representative/reservations/received', 'RepresentativeReservationController@Received');
        route::get('representative/reservations/in_delivery', 'RepresentativeReservationController@InDelivery');
        route::get('representative/reservations/delivered', 'RepresentativeReservationController@Delivered');
    });
});
