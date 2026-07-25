<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogisticsController;
use App\Http\Controllers\ProcurementController;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('welcome');

/*
|--------------------------------------------------------------------------
| Dashboard / Home
|--------------------------------------------------------------------------
*/

Route::view('/home', 'home')->name('home');

Route::view('/dashboard', 'home')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Forecasting
|--------------------------------------------------------------------------
*/

Route::view('/forecasting-demand', 'forecasting.forecasting-demand')
    ->name('forecasting.demand');
/*
|--------------------------------------------------------------------------
| Procurement
|--------------------------------------------------------------------------
*/

Route::get('/procurement', [ProcurementController::class, 'index'])
    ->name('procurement.index');

Route::get('/procurement/suppliers', [ProcurementController::class, 'suppliers'])
    ->name('procurement.suppliers');

Route::get('/procurement/po-management', [ProcurementController::class, 'poManagement'])
    ->name('procurement.po-management');

Route::get('/procurement/goods-receipt', [ProcurementController::class, 'goodsReceipt'])
    ->name('procurement.goods-receipt');

/*
|--------------------------------------------------------------------------
| Logistics
|--------------------------------------------------------------------------
*/

Route::get('/logistics', [LogisticsController::class, 'index'])
    ->name('logistics.dashboard');

/*
|--------------------------------------------------------------------------
| Inventory
|--------------------------------------------------------------------------
*/

Route::view('/inventory', 'inventory.index')
    ->name('inventory');

/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
*/

Route::view('/reports', 'reports.index')
    ->name('reports');