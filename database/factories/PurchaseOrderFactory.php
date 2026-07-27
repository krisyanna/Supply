<?php

namespace Database\Factories;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderFactory extends Factory
{
    protected $model = PurchaseOrder::class;

    public function definition(): array
    {
        // 1. Generate core dates
        $orderDate = $this->faker->dateTimeBetween('-2 months', 'now');
        $expectedDelivery = \Carbon\Carbon::parse($orderDate)->addDays($this->faker->numberBetween(7, 21));
        
        // 2. Randomize the status (Added 'Delivered'!)
        $status = $this->faker->randomElement(['Approved', 'Pending Approval', 'Delayed', 'Delivered']);
        
        // 3. Logic for logistics fields
        $isPending = $status === 'Pending Approval';
        $isDelayed = $status === 'Delayed';
        $isDelivered = $status === 'Delivered';

        return [
            'po_number'              => 'PO-' . date('Y') . '-' . $this->faker->unique()->numerify('###'),
            'supplier_name'          => $this->faker->company() . ' ' . $this->faker->companySuffix(),
            'order_date'             => $orderDate,
            'expected_delivery_date' => $expectedDelivery,
            'total_amount'           => $this->faker->randomFloat(2, 15000, 500000),
            'status'                 => $status,
            
            // Logistics Tracking
            'tracking_number'        => $isPending ? null : $this->faker->lexify('???-') . $this->faker->numerify('######') . $this->faker->lexify('?'),
            'shipping_provider'      => $isPending ? null : $this->faker->randomElement(['DHL', 'FedEx', 'UPS', 'LBC', 'J&T Express']),
            'shipping_status'        => $isPending ? 'Processing' : ($isDelayed ? 'Held at Customs' : ($isDelivered ? 'Delivered' : 'In Transit')),
        ];
    }
}