<?php

use Illuminate\Support\Facades\Route;


Route::get('/maintenance', function () {
    return view('errors.503');
})->name('maintenance');
