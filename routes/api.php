<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FrontController;
use App\Http\Controllers\API\GetStatusController;
use App\Http\Controllers\API\SmsController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', [FrontController::class, 'index']);
Route::post('/register', [FrontController::class, 'register']);
Route::get('/create_order', [FrontController::class, 'create_order']);
Route::get('/orders', [FrontController::class, 'orders']);
Route::get('/order_update', [FrontController::class, 'order_update']);

// Route::get('/getStatus', [GetStatusController::class, 'get']);

Route::post('/getPayment', [GetStatusController::class, 'getPayment']);

Route::post('/payment/uzum/check', [GetStatusController::class, 'check']);
Route::post('/payment/uzum/pay', [GetStatusController::class, 'pay']);

Route::post('/before_register', [FrontController::class, 'before_register']);
Route::post('/after_register', [FrontController::class, 'after_register']);

// Route::get('/send', [SmsController::class, 'send']);


