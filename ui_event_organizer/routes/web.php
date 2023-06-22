<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\api;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\staffController;
use App\Http\Controllers\clientController;
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

Route::get('/', [LoginController::class, 'showLoginForm']);
// client punya
Route::get('/register', [RegisterController::class, 'showRegistrationForm']);
Route::get('/home', [clientController::class, 'home']);
Route::get('/edit', [clientController::class, 'edit']);
Route::get('/details', [clientController::class, 'details']);
Route::get('/makeOrder', [clientController::class, 'makeOrder']);
// staff punya
Route::get('/staff',[staffController::class, 'home']);
Route::get('/staff/add', [staffController::class,'add']);
Route::get('/staff/edit',[staffController::class,'edit']);
Route::get('/staff/details',[staffController::class,'details']);

//curl api call
Route::get('/api/login', [api::class, 'login']);
Route::get('/api/register', [api::class], 'register');
