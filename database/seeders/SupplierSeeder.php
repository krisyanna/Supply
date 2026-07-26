<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'ASUS Philippines Distributor', 'contact_person' => 'Mark Johnson', 'phone' => '+63 917 555 0192', 'category' => 'Hardware'],
            ['name' => 'Corsair Logistics Asia', 'contact_person' => 'Sarah Jenkins', 'phone' => '+63 918 555 0243', 'category' => 'Power Supply'],
            ['name' => 'Kingston Technology Corp', 'contact_person' => 'David Tan', 'phone' => '+63 922 555 0381', 'category' => 'Memory'],
            ['name' => 'AMD Regional Channel Partner', 'contact_person' => 'Elena Rostova', 'phone' => '+63 919 555 0495', 'category' => 'Processors'],
            ['name' => 'NVIDIA Hardware Solutions', 'contact_person' => 'Michael Chen', 'phone' => '+63 915 555 0562', 'category' => 'Graphics'],
            ['name' => 'Western Digital Enterprise', 'contact_person' => 'Jessica Alba', 'phone' => '+63 923 555 0678', 'category' => 'Storage'],
            ['name' => 'DeepCool Industries PH', 'contact_person' => 'Ryan Reynolds', 'phone' => '+63 927 555 0789', 'category' => 'Cooling'],
            ['name' => 'MSI Components Distribution', 'contact_person' => 'Grace Hopper', 'phone' => '+63 928 555 0890', 'category' => 'Motherboards'],
            ['name' => 'Gigabyte Technology PH', 'contact_person' => 'Alan Turing', 'phone' => '+63 917 555 1122', 'category' => 'Motherboards'],
            ['name' => 'Seagate Technology Distribution', 'contact_person' => 'Linus Torvalds', 'phone' => '+63 918 555 2233', 'category' => 'Storage'],
            ['name' => 'Intel APAC Channel Sales', 'contact_person' => 'Satya Nadella', 'phone' => '+63 919 555 3344', 'category' => 'Processors'],
            ['name' => 'Razer Gaming peripherals PH', 'contact_person' => 'Min-Liang Tan', 'phone' => '+63 922 555 4455', 'category' => 'Peripherals'],
            ['name' => 'Cooler Master Philippines', 'contact_person' => 'Tim Cook', 'phone' => '+63 923 555 5566', 'category' => 'Chassis'],
            ['name' => 'Lian Li Industrial Co.', 'contact_person' => 'Jensen Huang', 'phone' => '+63 927 555 6677', 'category' => 'Chassis'],
            ['name' => 'NZXT Authorized Distributor', 'contact_person' => 'Bill Gates', 'phone' => '+63 928 555 7788', 'category' => 'Cooling'],
            ['name' => 'G.Skill International Enterprise', 'contact_person' => 'Steve Wozniak', 'phone' => '+63 917 555 8899', 'category' => 'Memory'],
            ['name' => 'Thermaltake Technology PH', 'contact_person' => 'Sundar Pichai', 'phone' => '+63 918 555 9900', 'category' => 'Power Supply'],
            ['name' => 'Be Quiet! German Engineering PH', 'contact_person' => 'Elon Musk', 'phone' => '+63 919 555 1011', 'category' => 'Cooling'],
            ['name' => 'Fractal Design Asia', 'contact_person' => 'Jeff Bezos', 'phone' => '+63 922 555 1213', 'category' => 'Chassis'],
            ['name' => 'Phanteks Supply Chain', 'contact_person' => 'Mark Zuckerberg', 'phone' => '+63 923 555 1415', 'category' => 'Chassis'],
            ['name' => 'SanDisk Professional', 'contact_person' => 'Sheryl Sandberg', 'phone' => '+63 927 555 1617', 'category' => 'Storage'],
            ['name' => 'Crucial by Micron', 'contact_person' => 'Jassy Andy', 'phone' => '+63 928 555 1819', 'category' => 'Memory'],
            ['name' => 'Zotac Gaming Philippines', 'contact_person' => 'Lisa Su', 'phone' => '+63 917 555 2021', 'category' => 'Graphics'],
            ['name' => 'Sapphire Technology Ltd.', 'contact_person' => 'Ginni Rometty', 'phone' => '+63 918 555 2223', 'category' => 'Graphics'],
            ['name' => 'PowerColor Official Partner', 'contact_person' => 'Marissa Mayer', 'phone' => '+63 919 555 2425', 'category' => 'Graphics'],
            ['name' => 'EVGA Authorized Partner', 'contact_person' => 'Susan Wojcicki', 'phone' => '+63 922 555 2627', 'category' => 'Power Supply'],
            ['name' => 'Seasonic Electronics PH', 'contact_person' => 'Whitney Wolfe', 'phone' => '+63 923 555 2829', 'category' => 'Power Supply'],
            ['name' => 'Asrock Motherboard Channel', 'contact_person' => 'Boz Saint John', 'phone' => '+63 927 555 3031', 'category' => 'Motherboards'],
            ['name' => 'Biostar Microtech PH', 'contact_person' => 'Daniel Ek', 'phone' => '+63 928 555 3233', 'category' => 'Motherboards'],
            ['name' => 'PNY Technologies Asia', 'contact_person' => 'Vitalik Buterin', 'phone' => '+63 917 555 3435', 'category' => 'Graphics'],
        ];

        foreach ($suppliers as $index => $supplier) {
            Supplier::create([
                'name' => $supplier['name'],
                'contact_person' => $supplier['contact_person'],
                'phone' => $supplier['phone'],
                'category' => $supplier['category'],
                'payment_terms' => $index % 2 == 0 ? 'Net 30' : 'Net 60',
                'rating' => round(rand(43, 50) / 10, 2),
                'delivery_schedule' => $index % 3 == 0 ? 'Next Day Delivery' : '3-5 Business Days',
                'status' => 'Active',
            ]);
        }
    }
}