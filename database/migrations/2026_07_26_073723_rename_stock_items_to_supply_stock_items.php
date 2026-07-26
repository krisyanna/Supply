<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('stock_items', 'supply_stock_items');
    }

    public function down(): void
    {
        Schema::rename('supply_stock_items', 'stock_items');
    }
};