<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{cpf}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{cpf}', [UserController::class, 'update']);
    Route::delete('/{cpf}', [UserController::class, 'destroy']);

 
});
