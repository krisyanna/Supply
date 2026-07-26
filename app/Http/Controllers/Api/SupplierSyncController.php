<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierSyncController extends Controller
{
    public function store(Request $request)
{
    $incomingToken = $request->bearerToken();
    $expectedToken = env('SUPPLY_CHAIN_API_TOKEN');

    if (!$incomingToken || $incomingToken !== $expectedToken) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Unauthorized: Invalid or missing API token.'
        ], 401);
    }

    $suppliers = $request->input('suppliers', []);
    \Illuminate\Support\Facades\Log::info('SUPPLY SYNC DEBUG - Count received: ' . count($suppliers));

    try {
        foreach ($suppliers as $supplier) {
            DB::table('suppliers')->updateOrInsert(
                ['id' => $supplier['id']],
                [
                    'name'              => $supplier['name'],
                    'contact_person'    => $supplier['contact_person'] ?? null,
                    'phone'             => $supplier['phone'] ?? null,
                    'email'             => $supplier['email'] ?? null,
                    'category'          => $supplier['category'] ?? null,
                    'sub_categories'    => $supplier['sub_categories'] ?? null,
                    'payment_terms'     => $supplier['payment_terms'] ?? null,
                    'rating'            => $supplier['rating'] ?? null,
                    'delivery_schedule' => $supplier['delivery_schedule'] ?? null,
                    'updated_at'        => now(),
                    'created_at'        => now(),
                ]
            );
        }
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('SUPPLY SYNC ERROR: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }

    return response()->json([
        'status'       => 'success',
        'synced_count' => count($suppliers)
    ], 200);
}
}