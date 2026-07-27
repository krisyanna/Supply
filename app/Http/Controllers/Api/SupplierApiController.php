<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;

class SupplierApiController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();

        return response()->json([
            'status' => 'success',
            'module' => 'Procurement Suppliers',
            'count' => $suppliers->count(),
            'data' => $suppliers,
        ], 200, [], JSON_PRETTY_PRINT);
    }
}
