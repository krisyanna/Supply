<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();

        if ($suppliers->isEmpty()) {
            return;
        }

        $statuses = ['Pending Approval', 'Approved', 'Delayed', 'Delivered'];

        for ($i = 1; $i <= 15; $i++) {
            DB::table('purchase_orders')->insert([
                'po_number' => 'PO-2026-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'supplier_id' => $suppliers->random()->id,
                'order_date' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                'total_amount' => rand(15000, 250000) + (rand(0, 99) / 100),
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}