<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sales')->truncate();

        $products = DB::table('products')->get();

        foreach ($products as $product) {

            // Generate around 20 sales records for each product
            for ($i = 0; $i < 20; $i++) {

                DB::table('sales')->insert([
                    'product_id'     => $product->product_id,
                    'product_name'   => $product->product_name,
                    'category'       => $product->unit_type,
                    'quantity_sold'  => rand(5, 60),
                    'sale_date'      => now()->subDays(rand(1,180)),
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

            }

        }
    }
}