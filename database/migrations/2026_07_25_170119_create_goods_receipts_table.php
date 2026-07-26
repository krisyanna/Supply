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
    Schema::create('goods_receipts', function (Blueprint $table) {
        $table->id();
        $table->string('grn_number')->unique();
        $table->unsignedBigInteger('po_id')->nullable(); // <-- Add this column
        $table->string('supplier_name')->nullable();
        $table->string('invoice_match_status')->default('Pending');
        $table->date('received_date')->nullable();
        $table->string('status')->default('Received');
        
        $table->foreign('po_id')->references('id')->on('purchase_orders')->onDelete('set null');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};
