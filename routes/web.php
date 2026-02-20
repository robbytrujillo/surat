<?php

use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
    // return view('welcome');
});

Route::resource('jenis-surat', JenisSuratController::class);

Route::post('surat/preview', [SuratController::class, 'preview'])->name('surat.preview');
Route::resource('surat', SuratController::class);
    
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
