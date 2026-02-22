<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
    // return view('welcome');
});

Route::middleware(['auth'])->group(function() {
    Route::resource('jenis-surat', JenisSuratController::class);    
    Route::post('surat/preview', [SuratController::class, 'preview'])->name('surat.preview');
    Route::resource('surat', SuratController::class);
    Route::resource('user', UserController::class);

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

    
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');