<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductApiController extends Controller
{
    public function index()
    {
        // Get all products from the database
        $products = Product::all();

        return response()->json([
            'status' => 'success',
            'module' => 'Inventory',
            'count' => $products->count(),
            'data' => $products
        ], 200, [], JSON_PRETTY_PRINT);
    }
}