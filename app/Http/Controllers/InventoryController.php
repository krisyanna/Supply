<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\StockItem;
use App\Models\WarehouseLocation;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display the Inventory & Warehouse Management index page.
     *
     * IMPORTANT — DATA OWNERSHIP NOTE:
     * The `stock_items` table here is a LOCAL REFLECTION, not the
     * source of truth. Right now it's filled by StockItemSeeder for
     * development/demo purposes. Once the actual IWM team's API is
     * ready, replace manual seeding with the SyncStockItems command,
     * which pulls data from their API and writes only the fields
     * this SCM view actually needs into this table.
     */
    public function index()
    {
        $items = StockItem::orderByDesc('created_at')->get();

        $stats = [
            'total_skus'             => $items->count(),
            'in_stock'               => $items->where('status', 'in-stock')->count(),
            'low_out_of_stock'       => $items->whereIn('status', ['low-stock', 'out-stock'])->count(),
            'reserved'               => $items->where('status', 'reserved')->count(),
            'inventory_value'        => $items->sum(fn ($item) => $item->quantity * $item->cost),
            'synced_purchase_orders' => PurchaseOrder::count(),
        ];

        $categories = $items->pluck('category')->unique()->sort()->values();

        return view('inventory.index', compact('stats', 'items', 'categories'));
    }

    /**
     * Display the Warehouse Locations page.
     */
    public function warehouseLocations()
    {
        $warehouses = WarehouseLocation::orderByDesc('created_at')->get();

        $stats = [
            'total_warehouses' => $warehouses->count(),
            'active'           => $warehouses->where('status', 'active')->count(),
            'inactive'         => $warehouses->where('status', 'inactive')->count(),
            'total_capacity'   => $warehouses->sum('capacity'),
        ];

        $cities = $warehouses->pluck('city')->unique()->sort()->values();

        return view('inventory.warehouse-locations', compact('warehouses', 'stats', 'cities'));
    }

    /**
     * Display a single stock item.
     */
    public function show($id)
    {
        $item = StockItem::findOrFail($id);

        return view('inventory.show', compact('item'));
    }

    /**
     * Show the form for editing a stock item.
     */
    public function edit($id)
    {
        $item = StockItem::findOrFail($id);

        return view('inventory.edit', compact('item'));
    }

    /**
     * Update a stock item.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer|min:0',
            'unit'     => 'sometimes|string|max:50',
            'cost'     => 'sometimes|numeric|min:0',
            'status'   => 'sometimes|in:in-stock,low-stock,out-stock,reserved',
        ]);

        StockItem::findOrFail($id)->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Stock item updated successfully.');
    }

    /**
     * Remove a stock item.
     */
    public function destroy($id)
    {
        StockItem::findOrFail($id)->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Stock item removed.');
    }

    /**
     * ------------------------------------------------------------
     * API INTEGRATION PLACEHOLDER
     * ------------------------------------------------------------
     * Left empty on purpose. Other groups' modules (Logistics,
     * Procurement, Forecasting, etc.) will call into or feed data
     * through this endpoint once their APIs are ready. Expected to
     * return JSON consumed by the front-end sub-module page.
     */
    public function api(Request $request)
    {
        // 1. Confirm the request is really from the IWM team, not a stranger.
        if ($request->header('X-IWM-Key') !== config('services.iwm.push_key')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // 2. Validate the shape of the data they're sending.
        $validated = $request->validate([
            'code'     => 'required|string|max:255',
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit'     => 'required|string|max:50',
            'max_qty'  => 'sometimes|integer|min:0',
            'cost'     => 'required|numeric|min:0',
            'status'   => 'required|in:in-stock,low-stock,out-stock,reserved',
        ]);

        $validated['max_qty'] = $validated['max_qty'] ?? $validated['quantity'];

        // 3. Save it — update if this item code already exists, create if not.
        $item = StockItem::updateOrCreate(
            ['code' => $validated['code']],
            $validated
        );

        return response()->json([
            'message' => 'Stock item synced successfully.',
            'item'    => $item,
        ], 200);
    }
}