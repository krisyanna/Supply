<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ForecastDemandApiController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
            ->leftJoin('sales', 'products.product_id', '=', 'sales.product_id')
            ->select(
                'products.product_id',
                'products.product_name',
                DB::raw('COALESCE(SUM(sales.quantity_sold),0) as historical_sales')
            )
            ->groupBy(
                'products.product_id',
                'products.product_name'
            )
            ->get();

        $forecast = $products->map(function ($product) {

            $historical = (int) $product->historical_sales;

            // Simple forecast (10% increase)
            $forecastDemand = round($historical * 1.10);

            $growthRate = $historical > 0 ? 10 : 0;

            $averageMonthlyDemand = round($historical / 6);

            return [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'historical_sales' => $historical,
                'forecast_demand' => $forecastDemand,
                'growth_rate' => $growthRate,
                'average_monthly_demand' => $averageMonthlyDemand,
                'trend' => $growthRate >= 0 ? 'Increasing' : 'Decreasing'
            ];
        });

        return response()->json([
            'status' => 'success',
            'module' => 'Supply Chain',
            'generated_at' => now(),
            'count' => $forecast->count(),
            'data' => $forecast
        ], 200, [], JSON_PRETTY_PRINT);
    }
}