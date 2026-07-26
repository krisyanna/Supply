<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        $suppliers = [
            ['name' => 'ASUS Philippines Distributor', 'contact' => 'Mark Johnson', 'phone' => '+63 917 555 0192'],
            ['name' => 'Corsair Asia-Pacific Logistics', 'contact' => 'Sarah Jenkins', 'phone' => '+63 918 555 0243'],
            ['name' => 'Kingston Technology Corp', 'contact' => 'David Tan', 'phone' => '+63 922 555 0381'],
            ['name' => 'AMD Regional Channel Partner', 'contact' => 'Elena Rostova', 'phone' => '+63 919 555 0495'],
            ['name' => 'NVIDIA Hardware Solutions Inc.', 'contact' => 'Michael Chen', 'phone' => '+63 915 555 0562'],
            ['name' => 'Western Digital Enterprise', 'contact' => 'Jessica Alba', 'phone' => '+63 923 555 0678'],
            ['name' => 'DeepCool Industries PH', 'contact' => 'Ryan Reynolds', 'phone' => '+63 927 555 0789'],
            ['name' => 'MSI Components Distribution', 'contact' => 'Grace Hopper', 'phone' => '+63 928 555 0890'],
        ];

        $supplier = $this->faker->randomElement($suppliers);

        return [
            'name' => $supplier['name'],
            'contact_person' => $supplier['contact'],
            'phone' => $supplier['phone'],
            'category' => $this->faker->randomElement(['Processors', 'Graphics', 'Memory', 'Storage', 'Cooling', 'Power Supply']),
            'payment_terms' => $this->faker->randomElement(['Net 30', 'Net 60', 'COD', 'Net 15']),
            'rating' => $this->faker->randomFloat(1, 4.0, 5.0),
            'delivery_schedule' => $this->faker->randomElement(['3-5 Business Days', 'Next Day Delivery', 'Weekly Batch', '2 Days Express']),
            'status' => 'Active',
        ];
    }
}