<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\Admin2Controller;
use App\Http\Controllers\Admin2\Service_categoryController;
use App\Http\Controllers\Admin2\ServiceController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\Order_moderatorController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/','/uz');

Route::group(['prefix' => '{language?}'], function (){
	Route::get('/logout', [UserController::class, 'logout'])->name('logout');

	Route::group(['middleware' => 'guest'], function () {
	  	// Route::get('/register', [UserController::class, 'register'])->name('register');
		// Route::post('/register', [UserController::class, 'store'])->name('register.store');
		Route::get('/', [UserController::class, 'login'])->name('login');
		Route::post('/login', [UserController::class, 'login_store'])->name('login.store');
	});

	Route::group(['prefix' => 'superadmin', 'middleware' => 'superadmin'], function () {
		Route::get('/profile/{user?}', [SuperadminController::class, 'profile'])->name('admin.profile');
		Route::put('/profile/save/{user?}', [SuperadminController::class, 'profile_save'])->name('admin.profile_save');
		Route::get('/', [SuperadminController::class, 'index'])->name('admin');
		Route::get('/users', [SuperadminController::class, 'users'])->name('users');
		Route::get('/users/edit/{user?}', [SuperadminController::class, 'users_edit'])->name('users.edit');
		Route::any('/users/update/{user?}', [SuperadminController::class, 'users_update'])->name('users.update');
		Route::get('/users/create', [SuperadminController::class, 'users_create'])->name('users.create');
		Route::post('/users/create', [SuperadminController::class, 'users_store'])->name('users.store');
		Route::post('/apply', [SuperadminController::class, 'apply'])->name('admin.users.apply');
		Route::post('/delete', [SuperadminController::class, 'delete'])->name('admin.users.delete');
		Route::post('/block', [SuperadminController::class, 'block'])->name('admin.users.block');
	});

	Route::group(['prefix' => 'admin2', 'middleware' => 'admin2'], function () {
		Route::get('/profile/{user?}', [Admin2Controller::class, 'profile'])->name('admin2.profile');
		Route::put('/profile/save/{user?}', [Admin2Controller::class, 'profile_save'])->name('admin2.profile_save');
		Route::get('/', [Admin2Controller::class, 'index'])->name('admin2');
		Route::resource('/categories', 'App\Http\Controllers\Admin2\Service_categoryController');
		Route::resource('/services', 'App\Http\Controllers\Admin2\ServiceController');
	});

	Route::group(['prefix' => 'order_moderator', 'middleware' => 'order_moderator'], function () {
		Route::get('/profile/{user?}', [Order_moderatorController::class, 'profile'])->name('order_moderator.profile');
		Route::put('/profile/save/{user?}', [Order_moderatorController::class, 'profile_save'])->name('order_moderator.profile_save');
		Route::get('/', [Order_moderatorController::class, 'index'])->name('order_moderator');
		Route::get('/orders', [Order_moderatorController::class, 'orders'])->name('order_moderator.orders');
		Route::get('/order_detail/{id?}', [Order_moderatorController::class, 'order_detail'])->name('order_moderator.order_detail');
		Route::post('/orders/in_progress', [Order_moderatorController::class, 'in_progress'])->name('order_moderator.in_progress');
		Route::post('/orders/canceled', [Order_moderatorController::class, 'canceled'])->name('order_moderator.canceled');
		Route::post('/orders/done', [Order_moderatorController::class, 'done'])->name('order_moderator.done');
		Route::post('/orders/sent', [Order_moderatorController::class, 'sent'])->name('order_moderator.sent');
		Route::post('/orders/delivered', [Order_moderatorController::class, 'delivered'])->name('order_moderator.delivered');
	});

	Route::group(['prefix' => 'courier', 'middleware' => 'courier'], function () {
		Route::get('/profile/{user?}', [CourierController::class, 'profile'])->name('courier.profile');
		Route::put('/profile/save/{user?}', [CourierController::class, 'profile_save'])->name('courier.profile_save');
		Route::get('/', [CourierController::class, 'index'])->name('courier');
		Route::get('/points', [CourierController::class, 'points'])->name('courier.points');
		Route::post('/points/canceled', [CourierController::class, 'canceled'])->name('courier.canceled');
		Route::post('/points/delivered', [CourierController::class, 'delivered'])->name('courier.delivered');
	});

	Route::group(['prefix' => 'accountant', 'middleware' => 'accountant'], function () {
		Route::get('/', [AccountantController::class, 'index'])->name('accountant');
	});
});


