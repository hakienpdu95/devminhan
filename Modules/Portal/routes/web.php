<?php

use Illuminate\Support\Facades\Route;
use Modules\Portal\Http\Controllers\HomeController;

Route::middleware('theme:portal,blank')
    ->get('/', HomeController::class)
    ->name('home');
