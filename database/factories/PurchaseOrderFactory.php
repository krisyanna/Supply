<?php

namespace Database\Factories;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderFactory extends Factory
{
    protected $model = PurchaseOrder::class;

    public function definition(): array
    {
        return [
            'po_number' => 'PO-' . $this->faker->unique()->numberBetween(10000, 99999),
            'supplier_id' => Supplier::inRandomOrder()->first()?->id ?? Supplier::factory(),
            'order_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'total_amount' => $this->faker->randomFloat(2, 15000, 250000),
            'status' => $this->faker->randomElement(['Pending Approval', 'Approved', 'Delayed', 'Completed']),
        ];
    }
}