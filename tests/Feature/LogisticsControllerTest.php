<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogisticsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_new_shipment_record(): void
    {
        $response = $this->postJson('/logistics/shipments', [
            'orderID' => 'ORD-999',
            'Name' => 'Test Client',
            'product' => 'Smart Sensor',
            'amount' => '₱12,500.00',
            'items' => 4,
            'total' => '₱50,000.00',
            'city' => 'Manila',
            'status' => 'In Transit',
        ]);

        $response->assertJsonPath('success', true);
        $this->assertDatabaseHas('shipments', ['orderID' => 'ORD-999']);
    }
}
