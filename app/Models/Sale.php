<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'product_id',
        'product_name',
        'category',
        'quantity_sold',
        'sale_date',
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];
}