<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemSupplierController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
	return redirect('/dashboard');
})->middleware('auth');
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
// Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
	
	// user
	Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');
	Route::get('/user', [RegisterController::class, 'index'])->name('user');
	Route::get('/user/create', [RegisterController::class, 'create'])->name('user.create');
	Route::get('/user/edit/{id}', [RegisterController::class, 'edit'])->name('user.edit');
	Route::post('/user/update/{id}', [RegisterController::class, 'update'])->name('user.update');
	Route::get('/user/delete/{id}', [RegisterController::class, 'destroy'])->name('user.destroy');


	// item
	Route::get('/item', [ItemController::class, 'index'])->name('item');
	Route::get('/item/create', [ItemController::class, 'create'])->name('item.create');
	Route::post('/item/store', [ItemController::class, 'store'])->name('item.store');
	Route::get('/item/show/{id}', [ItemController::class, 'show'])->name('item.show');
	Route::get('/item/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
	Route::post('/item/update/{id}', [ItemController::class, 'update'])->name('item.update');
	Route::get('/item/delete/{id}', [ItemController::class, 'destroy'])->name('item.delete');

	// customer
	Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
	Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
	Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
	Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
	Route::post('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
	Route::get('/customer/show/{id}', [CustomerController::class, 'show'])->name('customer.show');
	Route::get('/customer/showOrder/{id}', [CustomerController::class, 'showOrder'])->name('customer.showOrder');

	// supplier
	Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
	Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
	Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
	Route::get('/supplier/show/{id}', [SupplierController::class, 'show'])->name('supplier.show');
	Route::get('/supplier/itemList/{id}', [SupplierController::class, 'itemList'])->name('supplier.itemList');
	Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
	Route::post('/supplier/update{id}', [SupplierController::class, 'update'])->name('supplier.update');
	
	//item supplier
	Route::post('/itemsupplier/store/{id}', [ItemSupplierController::class, 'store'])->name('itemSupplier.store');
	Route::get('/itemsupplier/{id}', [ItemSupplierController::class, 'destroy'])->name('itemSupplier.destroy');

	// order
	Route::get('/salesorder', [SalesOrderController::class, 'index'])->name('salesorder');
	Route::get('/salesorder/create', [SalesOrderController::class, 'create'])->name('salesorder.create');
	Route::post('/salesorder/store', [SalesOrderController::class, 'store'])->name('salesorder.store');
	Route::get('/imagelabel', [SalesOrderController::class, 'imagelabel'])->name('imagelabel');
	Route::post('/salesorder/addItem/{id}', [SalesOrderController::class, 'addItem'])->name('salesorder.addItem');
	Route::post('/salesorder/updateOrderItem/{id}', [SalesOrderController::class, 'updateOrderItem'])->name('salesorder.updateOrderItem');
	Route::get('/salesorder/editOrderInfo1/{id}', [SalesOrderController::class, 'editOrderInfo1'])->name('salesorder.editOrderInfo1');
	Route::post('/salesorder/updateOrderInfo1/{id}', [SalesOrderController::class, 'updateOrderInfo1'])->name('salesorder.updateOrderInfo1');
	Route::get('/salesorder/editOrderInfo2/{id}', [SalesOrderController::class, 'editOrderInfo2'])->name('salesorder.editOrderInfo2');
	Route::post('/salesorder/updateOrderInfo2/{id}', [SalesOrderController::class, 'updateOrderInfo2'])->name('salesorder.updateOrderInfo2');
	Route::get('/salesorder/deleteOrderItem/{id}', [SalesOrderController::class, 'deleteOrderItem'])->name('salesorder.deleteOrderItem');

	Route::get('/salesorder/show/{id}', [SalesOrderController::class, 'show'])->name('salesorder.show');
	Route::post('/save-temporary', [SalesOrderController::class, 'saveTemporarily'])->name('save.temporary');
	Route::post('/save-permanent', [SalesOrderController::class, 'savePermanently'])->name('save.permanent');
	// Route::post('/trysee2', [SalesOrderController::class, 'trysee2'])->name('trysee2');

	Route::get('/{page}', [PageController::class, 'index'])->name('page');
});
