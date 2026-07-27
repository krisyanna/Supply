<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;

class ShipmentApiController extends Controller
{
    public function index()
    {
        $shipments = Shipment::all();

        return response()->json([
            'status' => 'success',
            'module' => 'Supply Chain',
            'count' => $shipments->count(),
            'data' => $shipments
        ], 200, [], JSON_PRETTY_PRINT);
    }
}