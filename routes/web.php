<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;

Route::get('/', function () {
    return view('layout.master');
});
Route::resource('products', ProductController::class);
Route::resource('categories', KategoriController::class);