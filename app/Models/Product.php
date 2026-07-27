<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- 1. Import the trait


class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'product_id';
}
