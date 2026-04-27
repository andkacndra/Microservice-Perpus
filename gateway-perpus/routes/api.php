<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/books', function () {
    return Http::get('http://127.0.0.1:8002/api/books')->json();
});

Route::get('/users', function () {
    return Http::get('http://127.0.0.1:8001/api/users')->json();
});

Route::get('/loans', function () {
    return Http::get('http://127.0.0.1:8003/api/loans')->json();
});