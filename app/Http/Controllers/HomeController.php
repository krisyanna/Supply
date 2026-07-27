<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     */
    public function index()
    {
        $totalSuppliers = Supplier::count();
        
        // Fetch products and load the warehouse and category relationships
        $items = Product::with(['warehouse', 'category'])->get(); 

        // Make sure this matches 'home' since your file is home.blade.php
        return view('home', compact('totalSuppliers', 'items'));
    }
}