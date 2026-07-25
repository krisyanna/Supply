<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display the Inventory & Warehouse Management index page.
     *
     * For now this uses static placeholder data so the UI can be
     * built and demoed without a database. Once the model/migration
     * is ready, swap the arrays below for real Eloquent queries
     * (e.g. StockItem::all()) and this method won't need to change
     * anywhere else in the app.
     */
    public function index()
    {
        $stats = [
            'total_skus'       => 128,
            'in_stock'         => 104,
            'low_out_of_stock' => 9,
            'inventory_value'  => 1842300.00,
        ];

        $items = [
            [
                'code'     => '#INV-3301',
                'name'     => 'Copper Wiring Spool',
                'location' => 'Cavite Depot – Rack A2',
                'category' => 'Electronics & Components',
                'quantity' => 420,
                'unit'     => 'pcs',
                'max_qty'  => 500,
                'cost'     => 310.00,
                'status'   => 'in-stock',
            ],
            [
                'code'     => '#INV-3302',
                'name'     => 'Hydraulic Pump Unit',
                'location' => 'Manila Port – Bay 5',
                'category' => 'Heavy Machinery',
                'quantity' => 6,
                'unit'     => 'pcs',
                'max_qty'  => 75,
                'cost'     => 24500.00,
                'status'   => 'low-stock',
            ],
            [
                'code'     => '#INV-3303',
                'name'     => 'Galvanized Steel Sheets',
                'location' => 'Bulacan Hub – Rack C1',
                'category' => 'Raw Materials',
                'quantity' => 0,
                'unit'     => 'pcs',
                'max_qty'  => 300,
                'cost'     => 1150.00,
                'status'   => 'out-stock',
            ],
            [
                'code'     => '#INV-3304',
                'name'     => 'Industrial Ball Bearings',
                'location' => 'Laguna Hub – Rack B4',
                'category' => 'Spare Parts',
                'quantity' => 980,
                'unit'     => 'pcs',
                'max_qty'  => 1030,
                'cost'     => 85.00,
                'status'   => 'in-stock',
            ],
            [
                'code'     => '#INV-3305',
                'name'     => 'Safety Helmets (Box of 10)',
                'location' => 'Batangas Depot – Rack D3',
                'category' => 'PPE & Safety Gear',
                'quantity' => 45,
                'unit'     => 'boxes',
                'max_qty'  => 112,
                'cost'     => 1800.00,
                'status'   => 'reserved',
            ],
        ];

        return view('inventory', compact('stats', 'items'));
    }

    /**
     * Show the form for creating a new stock item.
     */
    public function create()
    {
        return view('inventory.create');
    }

    /**
     * Store a newly created stock item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit'     => 'required|string|max:50',
            'cost'     => 'required|numeric|min:0',
            'status'   => 'required|in:in-stock,low-stock,out-stock,reserved',
        ]);

        // TODO: StockItem::create($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Stock item added successfully.');
    }

    /**
     * Display a single stock item.
     */
    public function show($id)
    {
        // TODO: $item = StockItem::findOrFail($id);
        return view('inventory.show', ['id' => $id]);
    }

    /**
     * Show the form for editing a stock item.
     */
    public function edit($id)
    {
        // TODO: $item = StockItem::findOrFail($id);
        return view('inventory.edit', ['id' => $id]);
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

        // TODO: StockItem::findOrFail($id)->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Stock item updated successfully.');
    }

    /**
     * Remove a stock item.
     */
    public function destroy($id)
    {
        // TODO: StockItem::findOrFail($id)->delete();

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
        //
    }
}
