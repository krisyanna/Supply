<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogisticsController;
use App\Http\Controllers\ProcurementController;





/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::view('/', 'welcome')
    ->name('welcome');

/*
|--------------------------------------------------------------------------
| Dashboard / Home
|--------------------------------------------------------------------------
*/
Route::view('/home', 'home')
    ->name('home');

Route::view('/dashboard', 'home')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Forecasting
|--------------------------------------------------------------------------
*/
Route::view('/forecasting-demand', 'forecasting.forecasting-demand')
    ->name('forecasting.demand');

/*
|--------------------------------------------------------------------------
| Procurement Module
|--------------------------------------------------------------------------
*/
Route::prefix('procurement')->group(function () {
    Route::get('/', [ProcurementController::class, 'index'])
        ->name('procurement.index');

    Route::get('/suppliers', [ProcurementController::class, 'suppliers'])
        ->name('procurement.suppliers');

    Route::get('/po-management', [ProcurementController::class, 'poManagement'])
        ->name('procurement.po-management');

    Route::get('/goods-receipt', [ProcurementController::class, 'goodsReceipt'])
        ->name('procurement.goods-receipt');

    Route::get('/reorder', [ProcurementController::class, 'reorder']) // <-- Fixed path
        ->name('procurement.reorder');
});
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

use App\Http\Controllers\InventoryController;

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::view('/inventory', 'inventory.index')
    ->name('inventory');


/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
*/
Route::view('/reports', 'reports.index')
    ->name('reports');