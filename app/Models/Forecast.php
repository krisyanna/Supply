<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    protected $fillable = [
        'product_id',
        'product_name',
        'forecast_period',
        'forecast_demand',
        'demand_growth',
        'current_stock',
        'inventory_coverage_days',
        'status',
        'recommendation'
    ];
}