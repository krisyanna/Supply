<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogisticsController extends Controller
{
    public function index()
    {
        // 1. GET DATA FROM: Procurement (Purchase Orders)
        $purchaseOrders = [
            ['po_number' => 'PO-2026-001', 'supplier' => 'TechParts Phils Corp', 'item' => 'Vertex [Mother Board] Ryzen-5', 'qty' => 150],
            ['po_number' => 'PO-2026-002', 'supplier' => 'Global Hardware', 'item' => 'Ryzen-9 Core Kit Combo', 'qty' => 45],
        ];

        // 2. GET DATA FROM: Inventory (Warehouse Locations & Products)
        $warehouses = [
            ['id' => 'WH-CVT', 'name' => 'Cavite Central Warehouse', 'location' => '2118 Ridge St. Cavite, 3564'],
            ['id' => 'WH-MNA', 'name' => 'Manila Container Terminal', 'location' => 'Port Area, Manila'],
            ['id' => 'WH-LGN', 'name' => 'Laguna Distribution Center', 'location' => '137 Gomez St, Brgy 2, Laguna City'],
        ];

        $products = [
            ['code' => 'SKU-101', 'name' => 'Vertex [Mother Board] Ryzen-5', 'weight' => '2.5 kg'],
            ['code' => 'SKU-202', 'name' => 'Ryzen-9 Core Kit Combo', 'weight' => '4.0 kg'],
            ['code' => 'SKU-303', 'name' => 'Groceries Logistics Bundle', 'weight' => '15.0 kg'],
        ];

        // 3. GET DATA FROM: Sales (Customer Orders for Outbound Deliveries)
        $customerOrders = [
            ['order_id' => 'ORD-001', 'customer' => 'SM Prime Holdings', 'destination' => 'Laguna City', 'status' => 'En Route'],
            ['order_id' => 'ORD-002', 'customer' => 'Robinsons Land', 'destination' => 'Bulacan', 'status' => 'En Route'],
        ];

        // DATA CREATED: Active Dispatches
        $shipments = [
            [
                'id' => 1,
                'shipment_code'       => 'ABC-01234',
                'po_reference'        => 'PO-2026-001',
                'customer_order'      => 'ORD-001',
                'driver_name'         => 'Erich De Torres',
                'phone_number'        => '+63 917 888 2002',
                'courier'             => 'JNT EXPRESS',
                'date_logged'         => 'Mon 13/09/26',
                'shipping_date'       => 'September 11, 2026',
                'estimated_arrival'   => 'Estimated 13 Sept 2026',
                'origin_address'      => '2118 Ridge St. Cavite, 3564',
                'destination_address' => '137 Gomez St, Brgy 2, Laguna City',
                'route_path'          => 'Cavite - Laguna',
                'status'              => 'En Route',
                'time_left'           => '4h 22m left',
                'progress_pct'        => 65,
                'cargo_details'       => 'Vertex [Mother Board] Ryzen-5',
                'delivery_cost'       => 17000.00,
                'payment_status'      => 'Paid'
            ],
            [
                'id' => 2,
                'shipment_code'       => 'DEF-56789',
                'po_reference'        => 'PO-2026-002',
                'customer_order'      => 'ORD-002',
                'driver_name'         => 'Kristy Ann Paracale',
                'phone_number'        => '+63 920 333 3003',
                'courier'             => 'JNT EXPRESS',
                'date_logged'         => 'Mon 13/09/26',
                'shipping_date'       => 'September 11, 2026',
                'estimated_arrival'   => 'Estimated 13 Sept 2026',
                'origin_address'      => 'Port Area, Manila',
                'destination_address' => 'Malolos, Bulacan',
                'route_path'          => 'Manila - Bulacan',
                'status'              => 'En Route',
                'time_left'           => '9h 52m left',
                'progress_pct'        => 40,
                'cargo_details'       => 'Ryzen-9 Core Kit Combo',
                'delivery_cost'       => 12850.00,
                'payment_status'      => 'Pending'
            ],
            [
                'id' => 3,
                'shipment_code'       => 'GHI-10111',
                'po_reference'        => 'PO-2026-001',
                'customer_order'      => 'ORD-001',
                'driver_name'         => 'Juliana Aquino',
                'phone_number'        => '+63 912 555 1001',
                'courier'             => 'JNT EXPRESS',
                'date_logged'         => 'Mon 13/09/26',
                'shipping_date'       => 'September 10, 2026',
                'estimated_arrival'   => '13 Sept 2026',
                'origin_address'      => 'Dagupan, Pangasinan',
                'destination_address' => 'Calamba, Laguna',
                'route_path'          => 'Pangasinan - Laguna',
                'status'              => 'Delivered',
                'time_left'           => '0h 00m left',
                'progress_pct'        => 100,
                'cargo_details'       => 'Groceries Logistics Bundle',
                'delivery_cost'       => 5000.00,
                'payment_status'      => 'Paid'
            ]
        ];

        return view('logistics-dashboard', compact('purchaseOrders', 'warehouses', 'products', 'customerOrders', 'shipments'));
    }
}