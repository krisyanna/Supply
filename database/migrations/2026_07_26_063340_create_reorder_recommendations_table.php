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
    Schema::create('reorder_recommendations', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('product_id')->nullable();
        $table->unsignedBigInteger('supplier_id')->nullable();
        $table->integer('suggested_quantity');
        $table->string('status')->default('Pending');
        $table->timestamps();

        // Foreign keys linking to products and supplier management mock data
        $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reorder_recommendations');
    }
};
