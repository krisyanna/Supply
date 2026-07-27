<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;

class PurchaseOrderApiController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::select('id', 'po_number', 'supplier_id', 'status', 'total_amount', 'order_date')
            ->orderByDesc('order_date')
            ->limit(100)
            ->get();

        return response()->json([
            'status' => 'success',
            'module' => 'Purchase Orders',
            'count' => $purchaseOrders->count(),
            'data' => $purchaseOrders,
        ], 200, [], JSON_PRETTY_PRINT);
    }
}
