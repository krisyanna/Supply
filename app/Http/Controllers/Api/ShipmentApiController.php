<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Services\ShipmentMockService;
use Illuminate\Http\Request;

class ShipmentApiController extends Controller
{
    public function index()
    {
        $shipments = Shipment::all();
        if ($shipments->isEmpty()) {
            $shipments = ShipmentMockService::getMockShipments();
        }

        return response()->json([
            'status' => 'success',
            'module' => 'Supply Chain',
            'count' => $shipments->count(),
            'data' => $shipments
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $orderId)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $shipment = Shipment::firstWhere('orderID', $orderId);

        if (! $shipment) {
            $mockShipment = ShipmentMockService::getMockShipments()->firstWhere('orderID', $orderId);
            $shipment = Shipment::create([
                'orderID' => $orderId,
                'product' => $mockShipment->product ?? 'Unknown product',
                'items' => $mockShipment->items ?? 0,
                'city' => $mockShipment->city ?? 'Unknown',
                'status' => $validated['status'],
                'amount' => $mockShipment->amount ?? 0,
                'total' => $mockShipment->total ?? '0',
            ]);
        } else {
            $shipment->status = $validated['status'];
            $shipment->save();
        }

        return response()->json([
            'status' => 'success',
            'data' => $shipment,
        ], 200, [], JSON_PRETTY_PRINT);
    }
}