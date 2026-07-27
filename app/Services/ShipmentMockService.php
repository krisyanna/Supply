<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ShipmentMockService
{
    public static function getMockShipments(): Collection
    {
        return collect([
            ['orderID' => 'S-001', 'product' => 'CPU Cooling Fans', 'items' => 42, 'city' => 'Manila', 'status' => 'In Transit', 'amount' => 12, 'total' => '₱62,500', 'contact' => '+63 917 555 0101', 'remarks' => 'Carrier departing Pasay warehouse now.', 'departure' => 'Pasay Warehouse', 'transit' => 'Bulacan Hub', 'arrival' => 'Manila Import Terminal', 'departureTime' => '07:10 AM', 'expectedArrival' => 'Today 3:20 PM', 'expectedArrive' => 'Today 3:20 PM'],
            ['orderID' => 'S-002', 'product' => 'Motherboard Kits', 'items' => 86, 'city' => 'Cebu', 'status' => 'Delayed', 'amount' => 18, 'total' => '₱128,400', 'contact' => '+63 922 555 0102', 'remarks' => 'Road delay at Mandaue interchange.', 'departure' => 'Cebu Consolidation', 'transit' => 'Cebu Port Hub', 'arrival' => 'Cebu City Depot', 'departureTime' => '05:30 AM', 'expectedArrival' => 'Tomorrow 9:45 AM', 'expectedArrive' => 'Tomorrow 9:45 AM'],
            ['orderID' => 'S-003', 'product' => 'SSD Modules', 'items' => 12, 'city' => 'Davao', 'status' => 'In Transit', 'amount' => 22, 'total' => '₱98,200', 'contact' => '+63 905 555 0103', 'remarks' => 'Temperature-controlled load in transit.', 'departure' => 'Davao Warehouse', 'transit' => 'Davao Hub', 'arrival' => 'Davao Terminal', 'departureTime' => '08:55 AM', 'expectedArrival' => 'Today 7:30 PM', 'expectedArrive' => 'Today 7:30 PM'],
            ['orderID' => 'S-004', 'product' => 'Power Supplies', 'items' => 128, 'city' => 'Quezon City', 'status' => 'Delivered', 'amount' => 10, 'total' => '₱320,000', 'contact' => '+63 917 555 0104', 'remarks' => 'Delivery completed and receipts signed.', 'departure' => 'QC Consolidation', 'transit' => 'North Manila Hub', 'arrival' => 'Quezon City Depot', 'departureTime' => '04:20 AM', 'expectedArrival' => 'Today 12:15 PM', 'expectedArrive' => 'Today 12:15 PM'],
            ['orderID' => 'S-005', 'product' => 'GPU Riser Cables', 'items' => 35, 'city' => 'Makati', 'status' => 'In Transit', 'amount' => 8, 'total' => '₱89,000', 'contact' => '+63 998 555 0105', 'remarks' => 'Moving on schedule toward Makati distribution.', 'departure' => 'Pasig Warehouse', 'transit' => 'Muntinlupa Hub', 'arrival' => 'Makati Dock', 'departureTime' => '09:00 AM', 'expectedArrival' => 'Today 4:40 PM', 'expectedArrive' => 'Today 4:40 PM'],
            ['orderID' => 'S-006', 'product' => 'RAM DIMMs', 'items' => 56, 'city' => 'Pasig', 'status' => 'Delayed', 'amount' => 16, 'total' => '₱74,800', 'contact' => '+63 946 555 0106', 'remarks' => 'Inspection hold at Pasig checkpoint.', 'departure' => 'Pasig Warehouse', 'transit' => 'Metro Manila Hub', 'arrival' => 'Pasig Distribution', 'departureTime' => '06:05 AM', 'expectedArrival' => 'Tomorrow 10:05 AM', 'expectedArrive' => 'Tomorrow 10:05 AM'],
            ['orderID' => 'S-007', 'product' => 'Network Adapters', 'items' => 72, 'city' => 'Baguio', 'status' => 'In Transit', 'amount' => 6, 'total' => '₱43,200', 'contact' => '+63 915 555 0107', 'remarks' => 'Ascending northbound route to Baguio.', 'departure' => 'Tarlac Warehouse', 'transit' => 'Baguio Hub', 'arrival' => 'Baguio Depot', 'departureTime' => '10:25 AM', 'expectedArrival' => 'Today 8:10 PM', 'expectedArrive' => 'Today 8:10 PM'],
            ['orderID' => 'S-008', 'product' => 'Cooling Gel Pads', 'items' => 19, 'city' => 'Iloilo', 'status' => 'Delivered', 'amount' => 14, 'total' => '₱18,600', 'contact' => '+63 935 555 0108', 'remarks' => 'Delivered to Iloilo regional hub.', 'departure' => 'Iloilo Warehouse', 'transit' => 'Panay Hub', 'arrival' => 'Iloilo Center', 'departureTime' => '03:45 AM', 'expectedArrival' => 'Today 11:50 AM', 'expectedArrive' => 'Today 11:50 AM'],
            ['orderID' => 'S-009', 'product' => 'Computer Cases', 'items' => 27, 'city' => 'Bacolod', 'status' => 'In Transit', 'amount' => 20, 'total' => '₱47,300', 'contact' => '+63 936 555 0109', 'remarks' => 'En route along the Visayas corridor.', 'departure' => 'Bacolod Warehouse', 'transit' => 'Negros Hub', 'arrival' => 'Bacolod Port', 'departureTime' => '11:20 AM', 'expectedArrival' => 'Today 9:25 PM', 'expectedArrive' => 'Today 9:25 PM'],
            ['orderID' => 'S-010', 'product' => 'Cable Management Kits', 'items' => 93, 'city' => 'Cavite', 'status' => 'Delayed', 'amount' => 9, 'total' => '₱15,300', 'contact' => '+63 927 555 0110', 'remarks' => 'Pending clearance before Cavite delivery.', 'departure' => 'Cavite Warehouse', 'transit' => 'Calabarzon Hub', 'arrival' => 'Cavite Dock', 'departureTime' => '07:55 AM', 'expectedArrival' => 'Tomorrow 6:10 AM', 'expectedArrive' => 'Tomorrow 6:10 AM'],
            ['orderID' => 'S-011', 'product' => 'Display Cables', 'items' => 62, 'city' => 'Taguig', 'status' => 'In Transit', 'amount' => 13, 'total' => '₱20,480', 'contact' => '+63 917 555 0111', 'remarks' => 'Final-mile carrier is on schedule.', 'departure' => 'Taguig Warehouse', 'transit' => 'Metro Manila Hub', 'arrival' => 'Taguig Center', 'departureTime' => '08:00 AM', 'expectedArrival' => 'Today 6:00 PM', 'expectedArrive' => 'Today 6:00 PM'],
            ['orderID' => 'S-012', 'product' => 'UPS Batteries', 'items' => 31, 'city' => 'Antipolo', 'status' => 'Delivered', 'amount' => 11, 'total' => '₱31,200', 'contact' => '+63 929 555 0112', 'remarks' => 'Received and inventoried in Antipolo.', 'departure' => 'Antipolo Warehouse', 'transit' => 'Rizal Hub', 'arrival' => 'Antipolo Depot', 'departureTime' => '02:10 AM', 'expectedArrival' => 'Today 11:55 AM', 'expectedArrive' => 'Today 11:55 AM'],
            ['orderID' => 'S-013', 'product' => 'LCD Panels', 'items' => 51, 'city' => 'Laguna', 'status' => 'In Transit', 'amount' => 15, 'total' => '₱76,500', 'contact' => '+63 936 555 0113', 'remarks' => 'Heading to Laguna distribution hub.', 'departure' => 'Laguna Warehouse', 'transit' => 'Calabarzon Hub', 'arrival' => 'Laguna Gate', 'departureTime' => '06:40 AM', 'expectedArrival' => 'Today 5:20 PM', 'expectedArrive' => 'Today 5:20 PM'],
        ])->map(function ($item) {
            return (object) array_merge($item, [
                'created_at' => now()->subMinutes(rand(5, 120)),
                'updated_at' => now()->subMinutes(rand(1, 60)),
            ]);
        });
    }
}
