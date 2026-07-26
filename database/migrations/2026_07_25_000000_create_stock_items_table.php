<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('location');
            $table->string('category');
            $table->unsignedInteger('quantity')->default(0);
            $table->string('unit');
            $table->unsignedInteger('max_qty')->default(0);
            $table->decimal('cost', 12, 2)->default(0);
            $table->enum('status', ['in-stock', 'low-stock', 'out-stock', 'reserved'])
                ->default('in-stock');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_items');
    }
};