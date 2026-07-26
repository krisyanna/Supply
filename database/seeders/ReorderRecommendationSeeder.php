<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReorderRecommendationSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            return;
        }

        foreach ($products->random(15) as $product) {
            DB::table('reorder_recommendations')->insert([
                'product_id'        => $product->id,
                'recommended_qty'   => $product->reorder_quantity,
                'urgency_level'     => ['High', 'Medium', 'Critical'][rand(0, 2)],
                'status'            => 'Pending Review',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}