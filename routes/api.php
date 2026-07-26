<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SupplierSyncController;

Route::post('/sync-suppliers', [SupplierSyncController::class, 'sync']);