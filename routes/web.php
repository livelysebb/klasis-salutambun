<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\AnggotaJemaatController;
use App\Http\Controllers\BaptisanController;
use App\Http\Controllers\SidiController;
use App\Http\Controllers\NikahController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiKeuanganController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\UserController ;


Route::get('/', function () {
    return view('login.login');
})->middleware('guest');



Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:super_admin|admin_klasis'])->group(function () {
        Route::resource('jemaats', JemaatController::class);

    });
    Route::get('/transaksi_keuangans/laporan-pdf', [TransaksiKeuanganController::class, 'laporanPdf'])->name('transaksi_keuangans.laporan_pdf');
    // Route::resource('jemaats', JemaatController::class);
    Route::resource('anggota-jemaat', AnggotaJemaatController::class);
    Route::resource('baptisans', BaptisanController::class);
    Route::resource('sidis', SidiController::class);
    Route::resource('nikahs', NikahController::class);
    Route::resource('transaksi_keuangans', TransaksiKeuanganController::class);
    Route::resource('surats', SuratController::class);
    Route::resource('penguruses', PengurusController::class);
    Route::resource('users', UserController::class);

});




Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
