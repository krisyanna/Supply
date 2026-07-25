<?php
// pa accepts
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'category',
        'sub_categories',
        'payment_terms',
        'rating',
        'delivery_schedule',
    ];
}