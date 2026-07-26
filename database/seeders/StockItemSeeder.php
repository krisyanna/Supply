<?php

namespace Database\Seeders;

use App\Models\StockItem;
use Illuminate\Database\Seeder;

class StockItemSeeder extends Seeder
{
    public function run(): void
    {
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

        foreach ($items as $item) {
            StockItem::updateOrCreate(['code' => $item['code']], $item);
        }
    }
}