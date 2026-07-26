<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id('product_id');
        $table->string('product_name');
        $table->string('unit_type');
        $table->decimal('unit_cost', 12, 2);
        $table->integer('current_stock')->default(0);
        $table->integer('reorder_point')->default(0);
        $table->integer('reorder_quantity');
        $table->enum('priority_level', ['High', 'Medium', 'Low']);
       
        $table->timestamps();
    });
   Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('product_name');
    $table->unsignedBigInteger('supplier_id');
    $table->string('category')->nullable();
    $table->decimal('unit_cost', 10, 2);
    $table->integer('current_stock');
    $table->integer('reorder_point');
    $table->integer('reorder_quantity');
    $table->string('unit_type')->default('pcs');
    $table->string('priority_level')->default('Medium');
    $table->timestamps();

    $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
