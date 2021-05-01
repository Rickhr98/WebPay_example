<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebpayPlusController;

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
    return redirect('/order/webpay/create');
});

//Pago Por WebPay
Route::get('/order/webpay/create', [WebpayPlusController::class, 'index'])->name('createWebpay');

Route::post('/order/webPay/init', [WebpayPlusController::class, 'createdTransaction']);

Route::get('/webpayplus/returnUrl', [WebpayPlusController::class, 'commitTransaction']);
