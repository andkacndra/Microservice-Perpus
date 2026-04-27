<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/kelola-buku', function () {
    return view('kelola-buku');
});