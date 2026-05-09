<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/books', function () {
    return Http::get('http://book-service:8000/api/books')->json();
});

Route::get('/users', function () {
    return Http::get('http://user-service:8000/api/users')->json();
});

Route::get('/loans', function () {
    return Http::get('http://loan-service:8000/api/loans')->json();
});
