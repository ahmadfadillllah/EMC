<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\BayarController;
use App\Http\Controllers\UnitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/area/getData', [AreaController::class, 'getData']);
Route::post('/area/postData', [AreaController::class, 'postData']);

//Unit
Route::get('/unit/getData', [UnitController::class, 'getData']);
Route::post('/unit/postData', [UnitController::class, 'postData']);

//Bayar
Route::get('/bayar/getData', [BayarController::class, 'getData']);
Route::post('/bayar/postData', [BayarController::class, 'postData']);
