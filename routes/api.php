<?php

use App\Http\Controllers\AreaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/area/getData', [AreaController::class, 'getData']);
Route::post('/area/postData', [AreaController::class, 'postData']);
