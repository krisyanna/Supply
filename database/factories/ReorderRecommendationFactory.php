<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\ReorderRecommendation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReorderRecommendationFactory extends Factory
{
    protected $model = ReorderRecommendation::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $supplier = Supplier::inRandomOrder()->first();

        return [
            'product_id' => $product?->product_id ?? null,
            'supplier_id' => $supplier?->id ?? null, // Randomly picks from your actual suppliers table
            'suggested_quantity' => $this->faker->numberBetween(30, 100),
            'status' => 'Pending',
        ];
    }
}