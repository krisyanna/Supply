<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'sub_categories',
        'payment_terms',
        'rating',
        'delivery_schedule',
        'status',
        'contact_person',
    ];
}