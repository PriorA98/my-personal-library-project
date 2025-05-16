<?php

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'homepage']);
Route::post('/books', [HomeController::class, 'store'])->name('books.store');