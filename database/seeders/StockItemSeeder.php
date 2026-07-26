<?php

namespace Database\Seeders;

use App\Models\StockItem;
use Illuminate\Database\Seeder;

class StockItemSeeder extends Seeder
{
    private const LOCATIONS = [
        'Cavite Depot – Rack A2',
        'Cavite Depot – Rack A5',
        'Manila Port – Bay 5',
        'Manila Port – Bay 8',
        'Bulacan Hub – Rack C1',
        'Bulacan Hub – Rack C3',
        'Laguna Hub – Rack B4',
        'Batangas Depot – Rack D3',
        'Batangas Depot – Rack D6',
        'Quezon City Warehouse – Rack E1',
    ];

    private const CATEGORIES = [
        'Electronics & Components',
        'Heavy Machinery',
        'Raw Materials',
        'Spare Parts',
        'PPE & Safety Gear',
        'Packaging Supplies',
        'Office Supplies',
        'Tools & Equipment',
    ];

    private const UNITS = ['pcs', 'box', 'kg', 'liter', 'roll', 'set'];

    private const NAME_POOL = [
        'Copper Wiring Spool', 'Hydraulic Pump Unit', 'Galvanized Steel Sheets',
        'Industrial Ball Bearings', 'Safety Helmets (Box of 10)', 'Stainless Steel Bolts',
        'PVC Pipe Fittings', 'Rubber Gaskets', 'Welding Rods', 'Air Filter Cartridge',
        'Forklift Tire', 'LED Panel Light', 'Circuit Breaker Panel', 'Diesel Generator Set',
        'Aluminum Extrusion Bar', 'Conveyor Belt Roll', 'Insulation Foam Sheet',
        'Fire Extinguisher (10lb)', 'Cable Tray Section', 'Pallet Wrap Roll',
        'Packing Tape Carton', 'Cardboard Box (Large)', 'Printer Toner Cartridge',
        'A4 Bond Paper Ream', 'Cordless Drill Set', 'Angle Grinder', 'Torque Wrench Set',
        'Measuring Tape', 'Work Gloves (Pair)', 'Safety Goggles', 'Ear Protection Muffs',
        'Reflective Safety Vest', 'Nitrile Gloves (Box)', 'Motor Oil Drum',
        'Grease Cartridge', 'Fuel Filter', 'Brake Pad Set', 'Transmission Belt',
        'Hydraulic Hose', 'Steel Chain Link', 'Anchor Bolt Set',
    ];

    public function run(): void
    {
        $rows = [];
        $code = 3301;

        $rows[] = $this->row($code++, 'Copper Wiring Spool', self::LOCATIONS[0], self::CATEGORIES[0], 420, 'pcs', 500, 310.00);
        $rows[] = $this->row($code++, 'Hydraulic Pump Unit', self::LOCATIONS[2], self::CATEGORIES[1], 6, 'pcs', 75, 24500.00);
        $rows[] = $this->row($code++, 'Galvanized Steel Sheets', self::LOCATIONS[4], self::CATEGORIES[2], 0, 'pcs', 300, 1150.00);
        $rows[] = $this->row($code++, 'Industrial Ball Bearings', self::LOCATIONS[6], self::CATEGORIES[3], 980, 'pcs', 1030, 85.00);
        $rows[] = $this->row($code++, 'Safety Helmets (Box of 10)', self::LOCATIONS[7], self::CATEGORIES[4], 45, 'box', 112, 1800.00, 'reserved');
        $rows[] = $this->row($code++, 'Sample Giveaway Sticker Pack', self::LOCATIONS[1], self::CATEGORIES[5], 200, 'pcs', 200, 0.00);
        $rows[] = $this->row($code++, 'Diesel Generator Set', self::LOCATIONS[3], self::CATEGORIES[1], 3, 'pcs', 10, 285000.00);

        $remaining = 50 - count($rows);

        for ($i = 0; $i < $remaining; $i++) {
            $maxQty   = rand(20, 1000);
            $quantity = rand(0, $maxQty);

            $rows[] = $this->row(
                $code++,
                self::NAME_POOL[array_rand(self::NAME_POOL)],
                self::LOCATIONS[array_rand(self::LOCATIONS)],
                self::CATEGORIES[array_rand(self::CATEGORIES)],
                $quantity,
                self::UNITS[array_rand(self::UNITS)],
                $maxQty,
                round(rand(500, 5000000) / 100, 2)
            );
        }

        foreach ($rows as $row) {
            StockItem::updateOrCreate(['code' => $row['code']], $row);
        }
    }

    private function row(
        int $code, string $name, string $location, string $category,
        int $quantity, string $unit, int $maxQty, float $cost, ?string $forcedStatus = null
    ): array {
        $row = [
            'code'     => '#INV-' . $code,
            'name'     => $name,
            'location' => $location,
            'category' => $category,
            'quantity' => $quantity,
            'unit'     => $unit,
            'max_qty'  => $maxQty,
            'cost'     => $cost,
        ];

        if ($forcedStatus) {
            $row['status'] = $forcedStatus;
        }

        return $row;
    }
}