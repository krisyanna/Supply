<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\ReorderRecommendation;
use Illuminate\Database\Seeder;

class ReorderRecommendationSeeder extends Seeder
{
    public function run(): void
    {
        ReorderRecommendation::truncate();

        $suppliers = Supplier::all();

        Product::all()->each(function ($product) use ($suppliers) {
            ReorderRecommendation::create([
                'product_id' => $product->product_id,
                // Assigns a completely random supplier from your actual suppliers table
                'supplier_id' => $suppliers->isNotEmpty() ? $suppliers->random()->id : null,
                'suggested_quantity' => rand(30, 100),
                'status' => 'Pending',
            ]);
        });
    }
}