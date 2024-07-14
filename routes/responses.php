<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponseController;

Route::middleware(['auth'])->group(function () {
    Route::get('/response/{id}', [ResponseController::class, 'index'])->name('response.show');
});
