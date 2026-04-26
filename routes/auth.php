<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::view('/login', 'auth.login')
        ->name('login');

    Route::post('/login', LoginController::class)
        ->name('login.post');

});
