<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\userController;
use App\Http\Controllers\eloCustController;

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
    return view('welcome');
});
// route machine
Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showFormRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::group(['middleware' => 'auth'], function () {
    Route::get('roles/index', [RoleController::class, 'index'])->name('role');
    Route::get('users/index', [userController::class, 'index'])->name('users');
    Route::get('customers/index', [eloCustController::class, 'index'])->name('customers');
    Route::get('customers/trash', [eloCustController::class, 'index'])->name('trashed');
    Route::post('customers/restore', [eloCustController::class, 'restore']);
    Route::post('customers/truedelete', [eloCustController::class, 'truedelete']);
    Route::post('/save-token', [userController::class, 'saveToken'])->name('save-token');
    Route::post('roles/pages', [RoleController::class, 'addPages']);
    Route::resource('users', userController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('customers', eloCustController::class);
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});