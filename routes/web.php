<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutfitController;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/upload', [OutfitController::class, 'index'])->middleware('nocache')->name('upload');
Route::post('/upload', [OutfitController::class, 'store'])->name('upload.store');
