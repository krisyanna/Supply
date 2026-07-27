<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    // Point to the correct WarehouseLocation model
    public function warehouse()
    {
        return $this->belongsTo(WarehouseLocation::class, 'warehouse_location_id');
    }

    // Category relationship
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
