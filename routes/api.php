<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\ApiBookController;

Route::get('/books', [ApiBookController::class, 'index']);
Route::post('/books', [ApiBookController::class, 'store']);
Route::get('/books/{id}', [ApiBookController::class, 'show']);
Route::put('/books/{id}', [ApiBookController::class, 'update']);
Route::delete('/books/{id}', [ApiBookController::class, 'destroy']);
