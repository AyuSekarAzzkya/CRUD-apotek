<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicinesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsGuest;
use App\Http\Middleware\isKasir;
use FontLib\Table\Type\name;
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
// Route::post('/login,', function(){
//     return view('/login');
// })->name('login');


// diakses sebelum login
Route::middleware(['IsGuest'])->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
});

// Route::get('/error-permission', function () {
//     return view('errors.permission');
// })->name('error.permission');

Route::middleware(['IsLogin'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');   
    Route::get('/home', function () {
        return view('home');
    })->name('home.page');

   

    Route::middleware(['IsAdmin'])->group(function () {

        Route::prefix('/medicine')->name('medicine.')->group(function () {
            Route::get('/create', [MedicinesController::class, 'create'])->name('create');
            Route::post('/store', [MedicinesController::class, 'store'])->name('store');
            Route::get('/', [MedicinesController::class, 'index'])->name('home');
            Route::get('/{id}', [MedicinesController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [MedicinesController::class, 'update'])->name('update');
            Route::delete('/{id}', [MedicinesController::class, 'destroy'])->name('delete');

            Route::get('/data/stock', [MedicinesController::class, 'stock'])->name('stock');
            Route::get('/data/stock/{id}', [MedicinesController::class, 'stockEdit'])->name('stock.edit');
            Route::patch('/data/stock/{id}', [MedicinesController::class, 'stockUpdate'])->name('stock.update');
        });

        Route::get('/user', [UserController::class, 'index'])->name('user.index');

        Route::prefix('/user')->name('user.')->group(function () {
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/order')->name('order.')->group(function(){
            Route::get('/data', [OrderController::class, 'data'])->name('data');
            Route::get('/export-excel', [OrderController::class, 'exportExcel'])->name('export-excel');

            
        });
       
    });

    Route::middleware(['iskasir'])->group(function () {
        Route::get('/pembelian', [OrderController::class, 'index'])->name('pembelian');
        Route::get('/create/pembelian', [OrderController::class, 'create'])->name('tambah.pembelian');
        Route::post('/store/pembelian', [OrderController::class, 'store'])->name('store.pembelian');
        Route::get('/print/{id}', [OrderController::class, 'show'])->name('print');
        Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
        Route::get('/download/{id}', [OrderController::class, 'downloadPDF'])->name('download');

        
    });

});
    // Struktur routing laravel
    // Route::httpMethod('/nama-path', [NamaController::class, 'namaFunc'])->name('identitas_route');
    // http Methods :
    // 1. get = mengambil data/menampilkan halaman
    // 2. post = menambahkan data baru ke db
    // 3. patch/put = mengubah data di db
    // 4. delete = menghapus data di db
