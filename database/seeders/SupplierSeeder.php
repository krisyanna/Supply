<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


use App\Models\Supplier;


class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::factory()->count(50)->create();
    }
}

