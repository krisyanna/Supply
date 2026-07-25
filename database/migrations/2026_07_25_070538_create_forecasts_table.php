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
        Schema::create('forecasts', function (Blueprint $table) {
            $table->id();

            // Product information (from Inventory API)
            $table->unsignedBigInteger('product_id');
            $table->string('product_name');

            // Forecast details
            $table->string('forecast_period'); // e.g. August 2026
            $table->integer('forecast_demand');
            $table->decimal('demand_growth', 5, 2);

            // Inventory snapshot
            $table->integer('current_stock');
            $table->integer('inventory_coverage_days');

            // Forecast status
            $table->enum('status', [
                'Increasing',
                'Stable',
                'Decreasing'
            ]);

            // Planning recommendation
            $table->text('recommendation')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forecasts');
    }
};