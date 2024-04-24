
<?php
 
use Illuminate\Support\Facades\Route;
use Webkul\CyberSource\Http\Controllers\CyberSourceController;
 
Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'checkout/paystack'], function () {
    Route::controller(PaymentController::class)->group(function () {
        Route::get('redirect', 'redirect')->name('cyber_source.redirect');
 
        Route::post('pay', 'pay')->name(paystack.pay);
 
        Route::post('cancel', 'cancelPayment');
        Route::get('callback', 'callback');
    });
});
