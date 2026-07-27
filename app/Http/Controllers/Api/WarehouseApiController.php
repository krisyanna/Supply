<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WarehouseLocation;

class WarehouseApiController extends Controller
{
    public function index()
    {
        $warehouses = WarehouseLocation::select('id', 'code', 'name', 'city', 'status', 'capacity')
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => 'success',
            'module' => 'Warehouse Locations',
            'count' => $warehouses->count(),
            'data' => $warehouses,
        ], 200, [], JSON_PRETTY_PRINT);
    }
}
