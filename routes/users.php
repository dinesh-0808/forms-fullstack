<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::middleware(['auth'])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('user.home');
    Route::post('/user/create-form',[UserController::class, 'create'])->name('user.create.form');
    // Route::get('/user/responses',[UserController::class, 'response'])->name('user.response');
});

