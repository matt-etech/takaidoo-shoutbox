<?php

use App\Http\Controllers\ShoutController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('shouts.index');
});

Route::get('/shoutbox', [ShoutController::class, 'index'])->name('shouts.index');
Route::post('/shoutbox', [ShoutController::class, 'store'])->name('shouts.store');
Route::delete('/shoutbox/{shout}', [ShoutController::class, 'destroy'])->name('shouts.destroy');
