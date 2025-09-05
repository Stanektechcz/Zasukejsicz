<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/profiles');
});

Route::get('/', [ProfileController::class, 'index'])->name('profiles.index');
