<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $hardwareItems = [
            ['name' => 'AMD Ryzen 9 7950X Processor', 'category' => 'Processors', 'cost' => 32999.00],
            ['name' => 'AMD Ryzen 7 7700X Processor', 'category' => 'Processors', 'cost' => 18500.00],
            ['name' => 'AMD Ryzen 5 7600X Processor', 'category' => 'Processors', 'cost' => 12999.00],
            ['name' => 'Intel Core i9-14900K Processor', 'category' => 'Processors', 'cost' => 34500.00],
            ['name' => 'Intel Core i7-14700K Processor', 'category' => 'Processors', 'cost' => 24000.00],
            ['name' => 'NVIDIA GeForce RTX 4090 24GB', 'category' => 'Graphics', 'cost' => 89999.00],
            ['name' => 'NVIDIA GeForce RTX 4080 Super', 'category' => 'Graphics', 'cost' => 59999.00],
            ['name' => 'NVIDIA GeForce RTX 4070 Ti', 'category' => 'Graphics', 'cost' => 45000.00],
            ['name' => 'AMD Radeon RX 7900 XTX', 'category' => 'Graphics', 'cost' => 54999.00],
            ['name' => 'AMD Radeon RX 7800 XT', 'category' => 'Graphics', 'cost' => 28999.00],
            ['name' => 'Kingston Fury Beast 32GB DDR5 RAM', 'category' => 'Memory', 'cost' => 6500.00],
            ['name' => 'Corsair Vengeance RGB 16GB DDR5', 'category' => 'Memory', 'cost' => 3800.00],
            ['name' => 'Samsung 990 PRO 2TB NVMe M.2 SSD', 'category' => 'Storage', 'cost' => 9500.00],
            ['name' => 'WD Black SN850X 1TB NVMe SSD', 'category' => 'Storage', 'cost' => 5200.00],
            ['name' => 'Seagate Barracuda 2TB HDD', 'category' => 'Storage', 'cost' => 3200.00],
            ['name' => 'ASUS ROG Strix X670E-E Gaming WiFi', 'category' => 'Motherboards', 'cost' => 24999.00],
            ['name' => 'MSI MAG B650 Tomahawk WiFi', 'category' => 'Motherboards', 'cost' => 11500.00],
            ['name' => 'Gigabyte Z790 Aorus Elite AX', 'category' => 'Motherboards', 'cost' => 14200.00],
            ['name' => 'Corsair RM850x 850W 80+ Gold PSU', 'category' => 'Power Supply', 'cost' => 7800.00],
            ['name' => 'Seasonic Focus GX-750 750W PSU', 'category' => 'Power Supply', 'cost' => 6200.00],
            ['name' => 'NZXT Kraken 240 RGB Liquid Cooler', 'category' => 'Cooling', 'cost' => 8500.00],
            ['name' => 'DeepCool AK620 High Performance Air Cooler', 'category' => 'Cooling', 'cost' => 3400.00],
            ['name' => 'Lian Li O11 Dynamic EVO Case', 'category' => 'Chassis', 'cost' => 9200.00],
            ['name' => 'NZXT H5 Flow Compact ATX Case', 'category' => 'Chassis', 'cost' => 5400.00],
        ];

        $item = $this->faker->randomElement($hardwareItems);

        return [
            'product_name' => $item['name'] . ' (' . strtoupper($this->faker->bothify('###')) . ')',
            'unit_type' => 'pcs',
            'unit_cost' => $item['cost'],
            'current_stock' => $this->faker->numberBetween(5, 100),
            'reorder_point' => $this->faker->numberBetween(10, 25),
            'reorder_quantity' => $this->faker->numberBetween(30, 80),
            'priority_level' => $this->faker->randomElement(['High', 'Medium', 'Low']),
            'supplier_id' => Supplier::inRandomOrder()->first()?->id ?? null,
        ];
    }
}