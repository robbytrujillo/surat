<?php

use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
    // return view('welcome');
});

Route::resource('jenis-surat', JenisSuratController::class);

Route::resource('surat', SuratController::class);
    