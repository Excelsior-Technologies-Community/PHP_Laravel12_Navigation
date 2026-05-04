<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');

Route::prefix('services')->group(function () {
    Route::view('/', 'services')->name('services');
    Route::view('/web', 'services-web')->name('services.web');
    Route::view('/mobile', 'services-mobile')->name('services.mobile');
});

Route::view('/contact', 'contact')->name('contact');