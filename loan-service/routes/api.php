<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;

Route::get('/loans', [LoanController::class, 'index']);
Route::get('/loans/{id}', [LoanController::class, 'show']);
Route::post('/loans', [LoanController::class, 'store']);
