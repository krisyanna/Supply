<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReorderRecommendationSeeder;
use Database\Seeders\PurchaseOrderSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SupplierSeeder::class,
            ProductSeeder::class,
            ReorderRecommendationSeeder::class,
            PurchaseOrderSeeder::class, // <-- This line must be here
        ]);
    }
}