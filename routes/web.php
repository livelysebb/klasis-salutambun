<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\AnggotaJemaatController;
use App\Http\Controllers\BaptisanController;
use App\Http\Controllers\SidiController;
use App\Http\Controllers\NikahController;
use App\Http\Controllers\AuthController;
Route::get('/', function () {
    return view('login.login');
})->middleware('guest');




// Bungkus semua route yang memerlukan autentikasi dalam grup middleware 'auth'
Route::middleware(['auth'])->group(function () {
    Route::resource('jemaats', JemaatController::class);
    Route::resource('anggota-jemaat', AnggotaJemaatController::class);
    Route::resource('baptisans', BaptisanController::class);
    Route::resource('sidis', SidiController::class);
    Route::resource('nikahs', NikahController::class);
});




Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
