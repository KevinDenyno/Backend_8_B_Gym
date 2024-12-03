<?php

use Illuminate\Http\Request;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PersonalTrainerController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('customer', CustomerController::class);
Route::post('/customer/register', [CustomerController::class, 'register'])->name('customers.register');
Route::post('/customer/login', [CustomerController::class, 'login'])->name('customers.login');
Route::post('/customer/logout', [CustomerController::class, 'logout'])->middleware('auth:sanctum')->name('customers.logout');
Route::resource('pesanan', PesananController::class);
Route::resource('layanan', LayananController::class);
Route::resource('alat-gym', AlatGymController::class)->only(['store']);
Route::resource('kelas-olahraga', KelasOlahragaController::class)->only(['store']);
Route::resource('personal-trainer', PersonalTrainerController::class)->only(['store']);
Route::delete('layanan/{id}', [LayananController::class, 'destroy']);
Route::get('/layanan/tipe/{tipe_layanan}', [LayananController::class, 'getByType'])->name('layanan.getByType');
Route::resource('personal-trainer', PersonalTrainerController::class);
// Route::resource('kelas', KelasController::class);
Route::resource('history', HistoryController::class);
Route::resource('review', ReviewController::class);