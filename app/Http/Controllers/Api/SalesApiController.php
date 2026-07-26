<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SalesApiController extends Controller
{
    public function index()
    {
        $sales = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.product_id')
            ->select(
                'sales.id',
                'sales.product_id',
                'products.product_name',
                'products.unit_type',
                'sales.quantity_sold',
                'sales.sale_date'
            )
            ->get();

        return response()->json([
            'status' => 'success',
            'module' => 'Sales',
            'count' => $sales->count(),
            'data' => $sales
        ], 200, [], JSON_PRETTY_PRINT);
    }
}