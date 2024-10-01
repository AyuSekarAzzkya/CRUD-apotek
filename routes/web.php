<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicinesController;
use App\Http\Controllers\UserController;
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

// Struktur routing laravel
// Route::httpMethod('/nama-path', [NamaController::class, 'namaFunc'])->name('identitas_route');
// http Methods :
// 1. get = mengambil data/menampilkan halaman
// 2. post = menambahkan data baru ke db
// 3. patch/put = mengubah data di db
// 4. delete = menghapus data di db

Route::get('/landing-page', [LandingPageController::class, 'index'])->name
('landing_page');

Route::prefix('/medicine')->name('medicine.')->group(function() {
    Route::get('/create', [MedicinesController::class, 'create'])->name('create');
    Route::post('/store', [MedicinesController::class, 'store'])->name('store');
    Route::get('/',[MedicinesController::class, 'index'])->name('home');
    Route::get('/{id}', [MedicinesController::class, 'edit'])->name('edit');
    Route::patch('/{id}', [MedicinesController::class, 'update'])->name('update');
    Route::delete('/{id}', [MedicinesController::class, 'destroy'])->name('delete');

    Route::get('/data/stock', [MedicinesController::class, 'stock'])->name('stock');
    Route::get('/data/stock/{id}', [MedicinesController::class, 'stockEdit'])->name('stock.edit');
    Route::patch('/data/stock/{id}', [MedicinesController::class, 'stockUpdate'])->name('stock.update');
});

Route::get('/user', [UserController::class, 'index'])->name
('user.index');

Route::prefix('/user')->name('user.')->group(function() {
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy'); // Add this line
});
