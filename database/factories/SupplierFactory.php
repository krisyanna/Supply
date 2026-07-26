<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
  public function definition(): array
{
    return [
        'name' => $this->faker->company(),
        'contact_person' => $this->faker->name(),
        'phone' => $this->faker->phoneNumber(),
        'email' => $this->faker->safeEmail(),
        'category' => $this->faker->randomElement(['Components', 'Graphics', 'Storage', 'Power Supply']),
        'sub_categories' => $this->faker->word(),
        'payment_terms' => $this->faker->randomElement(['Net 30', 'COD', 'Net 60']),
        'rating' => $this->faker->randomFloat(2, 1.0, 5.0),
        'delivery_schedule' => $this->faker->randomElement(['Weekly', 'Bi-Weekly', 'Monthly']),
        'status' => 'Active',
    ];
}
}