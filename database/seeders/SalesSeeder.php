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
               
                   'quantity_sold' => match ($product->priority_level) {
                    'High' => rand(30, 60),
                    'Medium' => rand(15, 35),
                    'Low' => rand(5, 15),
                    default => rand(10, 25),
                },
                    'sale_date'      => now()->subDays(rand(1,180)),
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

            }

        }
    }
}