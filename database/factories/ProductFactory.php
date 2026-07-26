<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory

{
    protected $model = \App\Models\Product::class; // Update to match your model path

   public function definition(): array
{
    return [
        'product_name' => $this->faker->words(3, true),
        'unit_type' => 'pcs',
        'unit_cost' => $this->faker->randomFloat(2, 100, 5000),
        'current_stock' => $this->faker->numberBetween(1, 10),
        'reorder_point' => 15,
        'reorder_quantity' => 50,
        'priority_level' => 'High',
        'supplier_id' => 1,
    ];
}
}
