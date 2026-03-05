<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () { return view('home'); })->name('home');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/services', function () { return view('services'); })->name('services');
Route::get('/services/web', function () { return view('services-web'); })->name('services.web');
Route::get('/services/mobile', function () { return view('services-mobile'); })->name('services.mobile');
Route::get('/contact', function () { return view('contact'); })->name('contact');

// Route::get('/', function () {
//     return view('welcome');
// });
