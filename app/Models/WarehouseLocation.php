<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WarehouseLocation extends Model
{
    protected $table = 'supply_warehouse_locations';

    private const CODE_PREFIX = 'WH';
    private const CODE_START  = 101;

    protected $fillable = [
        'code',
        'name',
        'address',
        'city',
        'capacity',
        'manager_name',
        'status',
    ];

    protected $casts = [
        'capacity' => 'integer',
    ];

    /**
     * Generate the next sequential warehouse code, e.g. #WH-101
     */
    public static function nextCode(): string
    {
        return DB::transaction(function () {
            $last = static::orderByDesc('id')->lockForUpdate()->first();

            if (! $last) {
                return '#' . self::CODE_PREFIX . '-' . self::CODE_START;
            }

            preg_match('/(\d+)/', $last->code, $matches);
            $nextNumber = isset($matches[1])
                ? ((int) $matches[1] + 1)
                : self::CODE_START;

            return '#' . self::CODE_PREFIX . '-' . $nextNumber;
        });
    }
}