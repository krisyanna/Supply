<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SupplierSyncController extends Controller
{
    public function sync(Request $request): JsonResponse
    {
        // 1. Verify the incoming token matches Procurement's token
        $incomingToken = $request->bearerToken();
        if ($incomingToken !== 'my-super-secret-erp-key-98765') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: Invalid API token.'
            ], 401);
        }

        // 2. Extract the suppliers array sent from Procurement
        $suppliersData = $request->input('suppliers', []);

        if (empty($suppliersData)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No supplier payload found.'
            ], 422);
        }

        // 3. Loop and persist each supplier record into the Supply database
        foreach ($suppliersData as $data) {
            Supplier::updateOrCreate(
                ['id' => $data['id']], // Matches ID to prevent duplicates
                [
                    'name'              => $data['name'] ?? null,
                    'contact_person'    => $data['contact_person'] ?? null,
                    'phone'             => $data['phone'] ?? null,
                    'email'             => $data['email'] ?? null,
                    'category'          => $data['category'] ?? null,
                    'sub_categories'    => $data['sub_categories'] ?? null,
                    'payment_terms'     => $data['payment_terms'] ?? null,
                    'rating'            => $data['rating'] ?? null,
                    'delivery_schedule' => $data['delivery_schedule'] ?? null,
                ]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Suppliers successfully synced and persisted to Supply database.',
            'count' => count($suppliersData)
        ], 200);
    }
}