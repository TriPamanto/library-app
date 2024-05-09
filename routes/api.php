<?php

use App\Http\Controllers\ApiBookController;
use Illuminate\Support\Facades\Route; // Add this line

Route::get('/books', [ApiBookController::class, 'index']);
Route::post('/books', [ApiBookController::class, 'store']);
Route::get('/books/{id}', [ApiBookController::class, 'show']);
Route::put('/books/{id}', [ApiBookController::class, 'update']);
Route::delete('/books/{id}', [ApiBookController::class, 'destroy']);
