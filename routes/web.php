<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogisticsController;

Route::view('/', 'home.home')->name('home');
/*
|--------------------------------------------------------------------------
| Web Routes - Logistics Sub-Module (Standalone Mode)
|--------------------------------------------------------------------------
*/

// Redirect root & dashboard directly to Logistics
Route::get('/', function () {
    return redirect()->route('logistics.dashboard');
});

Route::get('/dashboard', function () {
    return redirect()->route('logistics.dashboard');
})->name('dashboard');

// Main Logistics Route
Route::get('/logistics', [LogisticsController::class, 'index'])->name('logistics.dashboard');

// Safe Stubs for Sidebar Links (Prevents Route Not Found errors)
Route::get('/forecasting/demand', fn() => redirect()->route('logistics.dashboard'))->name('forecasting.demand');
Route::get('/forecasting/historical', fn() => redirect()->route('logistics.dashboard'))->name('forecasting.historical');
Route::get('/procurement', fn() => redirect()->route('logistics.dashboard'))->name('suppliers.index');
Route::get('/inventory', fn() => redirect()->route('logistics.dashboard'))->name('inventory');