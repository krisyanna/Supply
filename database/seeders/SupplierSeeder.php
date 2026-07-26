<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'ASUS Philippines Distributor', 'contact_person' => 'Mark Johnson', 'phone' => '+63 917 555 0192'],
            ['name' => 'Corsair Logistics', 'contact_person' => 'Sarah Jenkins', 'phone' => '+63 918 555 0243'],
            ['name' => 'Kingston Technology', 'contact_person' => 'David Tan', 'phone' => '+63 922 555 0381'],
            ['name' => 'AMD Channel Partner', 'contact_person' => 'Elena Rostova', 'phone' => '+63 919 555 0495'],
            ['name' => 'NVIDIA Hardware Solutions', 'contact_person' => 'Michael Chen', 'phone' => '+63 915 555 0562'],
            ['name' => 'Western Digital PH', 'contact_person' => 'Jessica Alba', 'phone' => '+63 923 555 0678'],
            ['name' => 'DeepCool Industries', 'contact_person' => 'Ryan Reynolds', 'phone' => '+63 927 555 0789'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create([
                'name' => $supplier['name'],
                'contact_person' => $supplier['contact_person'],
                'phone' => $supplier['phone'],
                'category' => 'Hardware',
                'payment_terms' => 'Net 30',
                'rating' => 4.8,
                'delivery_schedule' => '3-5 Days',
                'status' => 'Active',
            ]);
        }
    }
}