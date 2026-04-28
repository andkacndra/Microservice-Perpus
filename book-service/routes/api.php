<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::put('/books/{id}/reduce-stock', [BookController::class, 'reduceStock']);
Route::put('/books/{id}/add-stock', [BookController::class, 'addStock']);
Route::put('/books/{id}', [BookController::class, 'update']);