<?php

use Illuminate\Support\Facades\Route;

// Home → default theme (set by global web middleware, no override)
Route::get('/', fn () => view('home'));

// Blog + Contact → luxury theme (route middleware overrides the global default)
Route::middleware('theme:luxury')->group(function () {
    Route::get('/blog', fn () => view('blog.index'));
    Route::get('/contact', fn () => view('contact'));
});
