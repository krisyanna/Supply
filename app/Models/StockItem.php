<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockItem extends Model
{
    protected $fillable = [
        'code',
        'name',
        'location',
        'category',
        'quantity',
        'unit',
        'max_qty',
        'cost',
        'status',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'max_qty'  => 'integer',
        'cost'     => 'decimal:2',
    ];

    /**
     * Generate the next sequential item code, e.g. #INV-3306
     */
    public static function nextCode(): string
    {
        $last = static::orderByDesc('id')->first();

        if (! $last) {
            return '#INV-3301';
        }

        preg_match('/(\d+)/', $last->code, $matches);
        $nextNumber = isset($matches[1]) ? ((int) $matches[1] + 1) : 3301;

        return '#INV-' . $nextNumber;
    }
}