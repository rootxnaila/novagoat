<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/katalog', function () {
    return view('katalog.katalog');
});

Route::get('/katalog/detail/{id}', function ($id) {
    return view('katalog.detail');
});