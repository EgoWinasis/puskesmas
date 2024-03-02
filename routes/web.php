<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\AntrianDokterController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\PemeriksaanController;
use Illuminate\Support\Facades\Auth;

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



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// users
Route::resource('user', UserController::class);
// profile
Route::resource('profile', ProfileController::class);
// cuti
Route::group(['middleware' => 'profile.check'], function () {
    // Routes that require profile check
    Route::resource('pasien', PasienController::class);
    Route::resource('antrian', AntrianController::class);
    Route::resource('pelayanan', PelayananController::class);
    Route::resource('pemeriksaan', PemeriksaanController::class);
    Route::resource('antrianDokter', AntrianDokterController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('cetak', CetakController::class);
    
});
