<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SupplierSyncController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\SalesApiController;

Route::post('/sync-suppliers', [SupplierSyncController::class, 'sync']);

Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/sales', [SalesApiController::class, 'index']);