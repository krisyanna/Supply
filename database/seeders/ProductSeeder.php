<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // Or use DB::table if not using Eloquent models

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Generates 5 mock low-stock products instantly
        \App\Models\Product::factory()->count(5)->create();
    }
}
