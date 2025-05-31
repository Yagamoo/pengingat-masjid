<?php

use App\Http\Controllers\MasyarakatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/daftar', [MasyarakatController::class, 'create'])->name('masyarakat.create');
Route::post('/daftar', [MasyarakatController::class, 'store'])->name('masyarakat.store');
