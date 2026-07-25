<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;

class SupplierSyncController extends Controller
{
    public function sync(): JsonResponse
    {
        // Define the procurement connection dynamically
        Config::set('database.connections.procurement', [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'procurement_system', // Update this
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Fetch records and remove duplicates from the source collection by name
        $suppliers = DB::connection('procurement')->table('suppliers')->get();

        if ($suppliers->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No suppliers found in the procurement database.'
            ], 404);
        }

        // Wipe old ERP supplier records to prevent unique constraint conflicts
        Supplier::truncate();

        foreach ($suppliers as $supplierData) {
            Supplier::create([
                'name'              => $supplierData->name,
                'category'          => $supplierData->category ?? null,
                'sub_categories'    => $supplierData->sub_categories ?? null,
                'payment_terms'     => $supplierData->payment_terms ?? null,
                'rating'            => $supplierData->rating ?? null,
                'delivery_schedule' => $supplierData->delivery_schedule ?? null,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Suppliers synced successfully.',
            'count' => $suppliers->count(),
            'data' => $suppliers // This adds all 100 records to the response view
        ], 200);
    }
}