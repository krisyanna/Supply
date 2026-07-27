<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SupplierSyncController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\SalesApiController;
use App\Http\Controllers\Api\ShipmentApiController;
use App\Http\Controllers\Api\PurchaseOrderApiController;
use App\Http\Controllers\Api\WarehouseApiController;
use App\Http\Controllers\Api\ForecastDemandApiController;

Route::get('/forecast-demand', [ForecastDemandApiController::class, 'index']);
Route::get('/shipments', [ShipmentApiController::class, 'index']);
Route::patch('/shipments/{orderId}', [ShipmentApiController::class, 'update']);
Route::get('/purchase-orders', [PurchaseOrderApiController::class, 'index']);
Route::get('/warehouses', [WarehouseApiController::class, 'index']);

Route::post('/sync-suppliers', [SupplierSyncController::class, 'sync']);

Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/sales', [SalesApiController::class, 'index']);