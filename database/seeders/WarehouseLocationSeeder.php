<?php

namespace Database\Seeders;

use App\Models\WarehouseLocation;
use Illuminate\Database\Seeder;

class WarehouseLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Generates exactly 50 mock warehouse locations, matching the
     * same 50-record pattern used by StockItemSeeder.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $cities = [
            'Cavite', 'Manila', 'Bulacan', 'Laguna', 'Batangas',
            'Rizal', 'Quezon City', 'Pampanga', 'Cebu', 'Davao',
            'Iloilo', 'Bacolod', 'Zamboanga', 'Cagayan de Oro', 'Baguio',
        ];

        $warehouseTypes = [
            'Depot', 'Distribution Center', 'Storage Facility', 'Logistics Hub',
            'Fulfillment Center', 'Cold Storage', 'Cross-Dock Terminal', 'Port Warehouse',
        ];

        for ($i = 1; $i <= 50; $i++) {
            $city = $faker->randomElement($cities);
            $type = $faker->randomElement($warehouseTypes);
            $code = '#WH-' . (100 + $i);

            WarehouseLocation::updateOrCreate(
                ['code' => $code],
                [
                    'code'         => $code,
                    'name'         => "{$city} {$type}",
                    'address'      => $faker->streetAddress(),
                    'city'         => $city,
                    'capacity'     => $faker->numberBetween(1000, 50000),
                    'manager_name' => $faker->name(),
                    'status'       => $faker->randomElement(['active', 'active', 'active', 'inactive']),
                ]
            );
        }
    }
}
