<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- 1. Import the DB facade

class HomeController extends Controller
{
    /**
     * Show the application home page.
     */
    public function index()
{
    $totalSuppliers = DB::table('supply.suppliers')->count();

    return view('dashboard', compact('totalSuppliers'));
}
}