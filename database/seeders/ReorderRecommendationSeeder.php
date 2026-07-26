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
        // Get all currently created suppliers from your supplier management module
        $suppliers = Supplier::all();

        // Loop through each product and assign a random supplier from your list
        Product::all()->each(function ($product) use ($suppliers) {
            ReorderRecommendation::create([
                'product_id' => $product->product_id,
                'supplier_id' => $suppliers->isNotEmpty() ? $suppliers->random()->id : null,
                'suggested_quantity' => rand(30, 100),
                'status' => 'Pending',
            ]);
        });
    }
}