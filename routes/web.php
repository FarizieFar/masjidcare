<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MasjidController;
use App\Http\Controllers\PengurusMasjidController;
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

Route::get('/', [LandingPageController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('logout', [LoginController::class, 'logout']);

Route::get('/register-pengurus', [MasjidController::class, 'register']);

Route::post('/register-pengurus', [PengurusMasjidController::class, 'postRegister']);
