<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\BayarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\StrukController;
use App\Http\Controllers\UnitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/area/getData', [AreaController::class, 'getData']);
Route::post('/area/postData', [AreaController::class, 'postData']);
Route::put('/area/updateData/{id_area}', [AreaController::class, 'updateData']);
Route::delete('/area/deleteData/{id_area}', [AreaController::class, 'deleteData']);

//Unit
Route::get('/unit/getData', [UnitController::class, 'getData']);
Route::post('/unit/postData', [UnitController::class, 'postData']);
Route::put('/unit/updateData/{id_unit}', [UnitController::class, 'updateData']);
Route::delete('/unit/deleteData/{id_unit}', [UnitController::class, 'deleteData']);

//Bayar
Route::get('/bayar/getData', [BayarController::class, 'getData']);
Route::post('/bayar/postData', [BayarController::class, 'postData']);
Route::put('/bayar/updateData/{id_bayar}', [BayarController::class, 'updateData']);
Route::delete('/bayar/deleteData/{id_bayar}', [BayarController::class, 'deleteData']);
Route::get('/bayar/previewData/{nmr_struk}', [BayarController::class, 'previewData']);

//Struk
Route::get('/struk/invoice/{nmr_struk}', [StrukController::class, 'invoice']);

Route::get('/laporan/{startDate}/{endDate}', [LaporanController::class, 'laporan']);
