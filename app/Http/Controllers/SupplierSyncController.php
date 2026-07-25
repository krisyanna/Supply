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
        Config::set('database.connections.procurement', [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'procurement_system',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        $suppliers = DB::connection('procurement')->table('suppliers')->get();

        if ($suppliers->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No suppliers found in the procurement database.'
            ], 404);
        }

        Supplier::truncate();

        foreach ($suppliers as $supplierData) {
            Supplier::create([
                'name'              => $supplierData->name ?? $supplierData->supplier_name ?? 'Unknown',
                'contact_name'      => $supplierData->contact_name ?? $supplierData->contact_person ?? null,
                'contact_email'     => $supplierData->contact_email ?? null,
                'category'          => $supplierData->category ?? null,
                'sub_categories'    => $supplierData->sub_categories ?? null,
                'payment_terms'     => $supplierData->payment_terms ?? null,
                'rating'            => $supplierData->rating ?? $supplierData->performance_score ?? null,
                'delivery_schedule' => $supplierData->delivery_schedule ?? null,
                'status'            => $supplierData->status ?? 'Active',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'All supplier details synced successfully.',
            'count' => $suppliers->count(),
            'data' => $suppliers // This adds all 100 records to the response view
        ], 200);
    }
}