<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;

class LogisticsController extends Controller
{
    public function index()
    {
        $shipments = Shipment::all()->toArray();
        return view('logistics-dashboard', [
            'shipments' => $shipments,
            'purchaseOrders' => [],
            'warehouses' => [],
            'products' => [],
            'customerOrders' => []
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'orderID' => 'required|string|unique:shipments,orderID',
            'Name' => 'required|string',
            'product' => 'required|string',
            'amount' => 'required|string',
            'items' => 'required|integer',
            'total' => 'required|string',
            'city' => 'required|string',
            'status' => 'required|string',
        ]);

        $shipment = Shipment::create($data);

        return response()->json(['success' => true, 'shipment' => $shipment]);
    }

    public function updateStatus(Request $request, $orderID)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $shipment = Shipment::where('orderID', $orderID)->firstOrFail();
        $shipment->status = $request->status;
        $shipment->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }
}