<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('paystack')->group(function () {

        Route::get('/redirect', 'Webkul\Paystack\Http\Controllers\PaymentController@redirect')->name('paystack.redirect');

        Route::post('/pay', 'Webkul\Paystack\Http\Controllers\PaymentController@pay')->name('paystack.pay');

        Route::get('/callback', 'Webkul\Paystack\Http\Controllers\PaymentController@callback')->name('paystack.callback');
    });
});
