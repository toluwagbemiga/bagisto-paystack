
<?php
 
use Illuminate\Support\Facades\Route;
use Webkul\Paystack\Http\Controllers\PaymentController;
 
Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'checkout/paystack'], function () {
    Route::controller(PaymentController::class)->group(function () {
        Route::get('redirect', 'redirect')->name('paystack.redirect');
 
        Route::post('pay', 'pay')->name('paystack.pay');
 
        Route::post('cancel', 'cancelPayment')->name('paystack.cancel');
        Route::get('callback', 'callback')->name('paystack.callback');
    });
});
