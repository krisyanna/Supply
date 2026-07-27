<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    

    Schema::create('reorder_recommendations', function (Blueprint $table) {
        $table->id();
        
        // THIS IS THE ONLY TIME PRODUCT_ID SHOULD APPEAR HERE:
        $table->foreignId('product_id')->references('product_id')->on('products')->onDelete('cascade');
        
        $table->integer('recommended_qty');
        $table->string('urgency_level')->default('Medium');
        $table->string('status')->default('Pending Review');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('reorder_recommendations');
    }
};