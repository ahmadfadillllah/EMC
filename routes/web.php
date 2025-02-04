<?php

use App\Http\Controllers\AreaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/area/getData', [AreaController::class, 'getData']);
