<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MpesatransactionController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    // pay with mpesa
Route::get('/mpesa/password', [MpesatransactionController::class,'lipanampesapassword'])->name('lipanampesapassword');

Route::post('/mpesa/newaccesstoken', [MpesatransactionController::class,'newaccesstoken'])->name('newaccesstoken');

Route::post('/mpesa/stkpush', [MpesatransactionController::class,'stkpush'])->name('stkpush');

Route::post('/mpesa/storedb', [MpesatransactionController::class,'mpesaresponse'])->name('mpesaresponse');
