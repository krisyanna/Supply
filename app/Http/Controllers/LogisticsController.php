<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Shipment;
use App\Models\StockItem;
use App\Models\WarehouseLocation;
use Illuminate\Http\Request;

class LogisticsController extends Controller
{
    public function index()
    {
        $approvalOrders = PurchaseOrder::query()
            ->with('supplier')
            ->orderByDesc('order_date')
            ->orderByDesc('id')
            ->paginate(8);

        $liveOrders = PurchaseOrder::query()
            ->with('supplier')
            ->whereIn('status', ['Pending Approval', 'Delayed'])
            ->orderByDesc('updated_at')
            ->take(6)
            ->get();

        $shipments = Shipment::query()
            ->orderByDesc('created_at')
            ->paginate(8);

        $trackingShipments = Shipment::query()
            ->whereIn('status', ['In Transit', 'Delayed'])
            ->orderByDesc('updated_at')
            ->take(6)
            ->get();

        $routeShipments = Shipment::query()
            ->orderBy('city')
            ->take(6)
            ->get();

        $stats = [
            'total_orders' => PurchaseOrder::count(),
            'pending_approval' => PurchaseOrder::where('status', 'Pending Approval')->count(),
            'approved_orders' => PurchaseOrder::where('status', 'Approved')->count(),
            'delayed_responses' => PurchaseOrder::where('status', 'Delayed')->count(),
            'shipment_count' => Shipment::count(),
            'in_transit' => Shipment::where('status', 'In Transit')->count(),
            'delayed_shipments' => Shipment::where('status', 'Delayed')->count(),
        ];

        $inventoryItems = StockItem::count();
        $warehouses = WarehouseLocation::count();

        return view('logistics-dashboard', compact('approvalOrders', 'liveOrders', 'shipments', 'trackingShipments', 'routeShipments', 'stats', 'inventoryItems', 'warehouses'));
    }

    public function reviewPurchaseOrder(Request $request, PurchaseOrder $purchaseOrder)
    {
        $decision = $request->input('decision', 'approved');

        if (! in_array($decision, ['approved', 'declined'], true)) {
            return back()->with('error', 'Unable to process the logistics decision.');
        }

        $purchaseOrder->status = $decision === 'approved' ? 'Approved' : 'Delayed';
        $purchaseOrder->save();

        if ($decision === 'approved') {
            StockItem::updateOrCreate(
                ['code' => 'PO-' . $purchaseOrder->po_number],
                [
                    'name' => 'Procurement purchase order ' . $purchaseOrder->po_number,
                    'location' => 'Main Warehouse',
                    'category' => 'Procurement',
                    'quantity' => 1,
                    'unit' => 'pcs',
                    'max_qty' => 1,
                    'cost' => max(1000, (float) $purchaseOrder->total_amount / 10),
                    'status' => 'in-stock',
                ]
            );
        }

        return back()->with(
            'success',
            $decision === 'approved'
                ? 'Purchase order approved, synced into inventory, and marked for procurement handoff.'
                : 'Purchase order held and returned to procurement for review.'
        );
    }

    public function storeShipment(Request $request)
    {
        $validated = $request->validate([
            'orderID' => 'required|string|max:255',
            'Name' => 'required|string|max:255',
            'product' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'items' => 'required|integer|min:1',
            'total' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        Shipment::updateOrCreate(
            ['orderID' => $validated['orderID']],
            $validated
        );

        if ($request->wantsJson()) {
            return response()->json(['success' => true], 201);
        }

        return back()->with('success', 'Shipment schedule saved successfully.');
    }
}
