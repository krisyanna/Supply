<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id(); // Matches incoming Procurement supplier ID
            $table->string('name');
            $table->string('contact_person')->nullable(); // <--- Added
            $table->string('phone')->nullable();          // <--- Added
            $table->string('email')->nullable();          // <--- Added
            $table->string('category')->nullable();
            $table->string('sub_categories')->nullable();
            $table->string('payment_terms')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->string('delivery_schedule')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};