<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/kelola-peminjaman', function () {
    return view('kelola-peminjaman');
});