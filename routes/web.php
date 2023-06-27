<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MasjidController;
use App\Http\Controllers\PengurusMasjidController;
use Database\Seeders\AdminSeeder;
use Database\Seeders\PengurusMasjidSeeder;
use Illuminate\Support\Facades\Auth;
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
Route::get('/login-pengurus', [PengurusMasjidController::class, 'login']);
Route::post('/login-pengurus', [PengurusMasjidController::class, 'validateLogin']);
Route::get('/masjid', [MasjidController::class, 'index']);
Route::get('/masjid/{id}/detail', [MasjidController::class, 'show']);


Route::middleware(['user'])->group(function(){

Route::get('masjid/{id}/pembayaran', [MasjidController::class, 'pembayaran']);
Route::post('/pembayaran/{idPenerima}/oleh/{idPengirim}', [MasjidController::class, 'pengiriman']);
Route::get('/pembayaran/{id}', [MasjidController::class, 'metode']);
Route::get('/history', [MasjidController::class, 'history']);
Route::post('/sudah-transfer/{id}', [MasjidController::class, 'transfer']);
});
//User

//Enduser

// Admin
Route::middleware(['admin'])->group(function(){
Route::get('/admin-dashboard', [AdminController::class, 'index']);
Route::get('/admin-dashboard/pending', [AdminController::class, 'pending']);
Route::get('/admin-dashboard/declined', [AdminController::class, 'declined']);
Route::get('/admin-dashboard/approved', [AdminController::class, 'approved']);
Route::post('/admin-dashboard/approve/{id}', [AdminController::class, 'approve']);
Route::post('/admin-dashboard/decline/{id}', [AdminController::class, 'decline']);
Route::post('/admin-dashboard/delete/{id}', [AdminController::class, 'destroy']);
Route::get('/admin-dashboard/masjid', [AdminController::class, 'getMasjid']);
Route::get('/admin-dashboard/donatur', [AdminController::class, 'getDonatur']);
Route::get('/admin-dashboard/donatur/delete/{id}', [AdminController::class, 'deleteUser']);
Route::get('/admin-dashboard/pencairan', [AdminController::class, 'pencairan']);
Route::post('/admin-dashboard/terima-pencairan/{id}', [AdminController::class, 'terimaPencairan']);
Route::post('/admin-dashboard/tolak-pencairan/{id}', [AdminController::class, 'tolakPencairan']);
Route::get('/admin-dashboard/request-donasi', [AdminController::class, 'requestDonasi']);
Route::post('/admin-dashboard/approve-donasi/{id}', [AdminController::class, 'terimaDonasi']);
Route::post('/admin-dashboard/decline-donasi/{id}', [AdminController::class, 'tolakDonasi']);
Route::get('/admin-dashboard/total-donasi', [AdminController::class, 'totalDonasi']);
});
// EndAdmin

// Pengurus
Route::middleware(['pengurus'])->group(function(){

Route::middleware(['approved'])->group(function(){
    Route::get('/pengurus-dashboard', [PengurusMasjidController::class, 'index']);
    Route::get('/pengurus-dashboard/data-donasi', [PengurusMasjidController::class, 'getDataDonasi']);
    Route::get('/pengurus-dashboard/permintaan-pencairan', [PengurusMasjidController::class, 'getDataPencairanRequest']);
    Route::get('/pengurus-dashboard/data-donasi/cetak_pdf', [PengurusMasjidController::class, 'cetakPdfDataDonasi']);
    Route::post('/tarik-dana', [PengurusMasjidController::class, 'tarikDana']);
});
Route::get('/not-approved', function(){
    return view('masjid.tidak_bisa_diakses');
});
Route::get('/pending', function(){
    return view('masjid.halaman_pending');
});
});
// EndPengurus