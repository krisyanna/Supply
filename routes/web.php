<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogisticsController;
use App\Http\Controllers\ProcurementController;

// Redirect root & dashboard directly to Logistics
Route::get('/', function () {
    return redirect()->route('logistics.dashboard');
});

Route::view('/welcome', 'welcome')->name('welcome');

Route::view('/home', 'home')->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('logistics.dashboard');
})->name('dashboard');

// Main Logistics Route
Route::get('/logistics', [LogisticsController::class, 'index'])->name('logistics.dashboard');

// Safe Stubs for Sidebar Links (Prevents Route Not Found errors)
Route::get('/forecasting/demand', fn() => redirect()->route('logistics.dashboard'))->name('forecasting.demand');
Route::get('/forecasting/historical', fn() => redirect()->route('logistics.dashboard'))->name('forecasting.historical');
Route::get('/inventory', fn() => redirect()->route('logistics.dashboard'))->name('inventory');

// Procurement Routes (real controller, not stubbed anymore)
Route::get('/procurement', [ProcurementController::class, 'index'])->name('procurement.index');
Route::get('/procurement/suppliers', [ProcurementController::class, 'suppliers'])->name('procurement.suppliers');
Route::get('/procurement/po-management', [ProcurementController::class, 'poManagement'])->name('procurement.po-management');
Route::get('/procurement/goods-receipt', [ProcurementController::class, 'goodsReceipt'])->name('procurement.goods-receipt');