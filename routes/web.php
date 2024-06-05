<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;


Route::group(['middleware' => 'guest'], function () {
  Route::get('/', function () {
      return view('welcome');
  })->name('home');
  Route::get('/register', [AuthController::class, 'register'])->name('register');
  Route::post('/register', [AuthController::class, 'regPost'])->name('register');
  Route::get('/login', [AuthController::class, 'login'])->name('login');
  Route::post('/login', [AuthController::class, 'logPost'])->name('login');
  });


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('layout.master');
    })->name('dashboard');
    Route::delete('logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('products', ProductController::class);
    // Route::resource('categories', KategoriController::class);
  });