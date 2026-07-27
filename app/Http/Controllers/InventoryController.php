<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use App\Models\WarehouseLocation;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display the Inventory & Warehouse Management index page.
     */
    public function index(Request $request)
    {
        // 1. Calculate overall KPI stats (unfiltered)
        $all_items = StockItem::all();

        $stats = [
            'total_skus'       => $all_items->count(),
            'in_stock'         => $all_items->where('status', 'in-stock')->count(),
            'low_out_of_stock' => $all_items->whereIn('status', ['low-stock', 'out-stock'])->count(),
            'reserved'         => $all_items->where('status', 'reserved')->count(),
            'inventory_value'  => $all_items->sum(fn ($item) => $item->quantity * $item->cost),
        ];

        $categories = $all_items->pluck('category')->filter()->unique()->sort()->values();

        // 2. Build Query for Search, Filter, and Server-Side Pagination
        $query = StockItem::query();

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(code) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Appends query parameters to pagination links so filters persist
        $items = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('inventory.index', compact('stats', 'items', 'categories'));
    }

    /**
     * Display the Warehouse Locations page.
     */
    public function warehouseLocations(Request $request)
    {
        // 1. Calculate overall KPI stats (unfiltered)
        $all_warehouses = WarehouseLocation::all();

        $stats = [
            'total_warehouses' => $all_warehouses->count(),
            'active'           => $all_warehouses->where('status', 'active')->count(),
            'inactive'         => $all_warehouses->where('status', 'inactive')->count(),
            'total_capacity'   => $all_warehouses->sum('capacity'),
        ];

        $cities = $all_warehouses->pluck('city')->filter()->unique()->sort()->values();

        // 2. Build Query for Search, Filter, and Server-Side Pagination
        $query = WarehouseLocation::query();

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(code) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Appends query parameters to pagination links so filters persist
        $warehouses = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

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
     * API INTEGRATION PLACEHOLDER
     */
    public function api(Request $request)
    {
        if ($request->header('X-IWM-Key') !== config('services.iwm.push_key')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

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