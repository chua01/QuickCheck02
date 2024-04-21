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
	Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');
	Route::get('/user', [RegisterController::class, 'index'])->name('user');
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
	Route::get('/user/create', [RegisterController::class, 'create'])->name('user.create');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');

	// item
	Route::get('/item', [ItemController::class, 'index'])->name('item');
	Route::get('/item/create', [ItemController::class, 'create'])->name('item.create');
	Route::post('/item/store', [ItemController::class, 'store'])->name('item.store');
	Route::get('/item/show', [ItemController::class, 'show'])->name('item.show');

	// customer
	Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
	Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
	Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');

	// supplier
	Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
	Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
	Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
	
	// order
	Route::get('/salesorder', [SalesOrderController::class, 'index'])->name('salesorder');
	Route::get('/salesorder/create', [SalesOrderController::class, 'create'])->name('salesorder.create');
	Route::post('/salesorder/store', [SupplierController::class, 'store'])->name('salesorder.store');
	

	Route::get('/{page}', [PageController::class, 'index'])->name('page');
});
