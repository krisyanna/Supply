<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoodsReceiptSeeder extends Seeder
{
    public function run(): void
    {
        $purchaseOrders = DB::table('purchase_orders')->get();

        $matchStatuses = ['Matched', 'Discrepancy', 'Pending'];
        $statuses = ['Received', 'Completed', 'Pending Verification'];

        for ($i = 1; $i <= 15; $i++) {
            $po = $purchaseOrders->isNotEmpty() ? $purchaseOrders->random() : null;

            // Ensure this table name matches your controller and migration (e.g., 'goods_receipts')
            DB::table('goods_receipts')->insert([
                'grn_number'           => 'GRN-2026-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'po_id'                => $po ? $po->id : null,
                'supplier_name'        => $po ? ($po->supplier_name ?? 'Hardware Distributor Inc.') : 'Global Tech Supplies',
                'invoice_match_status' => $matchStatuses[array_rand($matchStatuses)],
                'received_date'        => now()->subDays(rand(1, 15))->format('Y-m-d'),
                'status'               => $statuses[array_rand($statuses)],
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);
        }
    }
}