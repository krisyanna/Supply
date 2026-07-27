<?php

namespace Tests\Feature;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogisticsDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_logistics_dashboard_shows_approval_view_and_purchase_orders(): void
    {
        $supplier = Supplier::factory()->create(['name' => 'Northwind Supply']);

        PurchaseOrder::create([
            'po_number' => 'PO-2026-001',
            'supplier_id' => $supplier->id,
            'order_date' => now()->toDateString(),
            'total_amount' => 15000.00,
            'status' => 'Pending Approval',
        ]);

        $response = $this->get(route('logistics.dashboard'));

        $response->assertOk();
        $response->assertSee('Logistics');
        $response->assertSee('Orders to Approve');
        $response->assertSee('PO-2026-001');
    }
}
