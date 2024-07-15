<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;


Route::middleware(['auth'])->group(function () {
    // Route::get('/create-form',[FormController::class,'index'])->name('form.index');
    Route::post('/create-form', [FormController::class, 'store'])->name('form.store');
    Route::post('/form/{id}/publish/toggle', [FormController::class, 'toggle'])->name('form.publish.toggle');
    Route::get('form/{id}/responses', [FormController::class, 'response'])->name('form.response');
    Route::get('/form/{id}', [FormController::class, 'getResponse'])->name('form.getResponse');
    Route::post('form/{id}', [FormController::class, 'saveResponse'])->name('form.saveResponse');
    Route::delete('/form/{id}', [FormController::class, 'destroy'])->name('form.destroy');
    Route::get('/form/{id}/edit',[FormController::class, 'edit'])->name('form.edit');
    Route::post('/form/{id}/update',[FormController::class, 'update'])->name('form.update');
});
