<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shipment;

class ShipmentSeeder extends Seeder
{
    public function run()
    {
        $shipments = [
            ['orderID' => 'ORD-101', 'Name' => 'Juan Dela Cruz', 'product' => 'Ryzen-5 Motherboard', 'amount' => '₱1,700.00', 'items' => 10, 'total' => '₱17,000.00', 'city' => 'Cavite', 'status' => 'In Transit'],
            ['orderID' => 'ORD-102', 'Name' => 'Maria Santos', 'product' => 'Core Kit Combo', 'amount' => '₱2,850.00', 'items' => 5, 'total' => '₱14,250.00', 'city' => 'Laguna', 'status' => 'In Transit'],
            ['orderID' => 'ORD-103', 'Name' => 'Pedro Penduko', 'product' => 'Logistics Bundle', 'amount' => '₱500.00', 'items' => 30, 'total' => '₱15,000.00', 'city' => 'Batangas', 'status' => 'Delayed'],
            ['orderID' => 'ORD-104', 'Name' => 'Ana Reyes', 'product' => 'DDR4 16GB RAM', 'amount' => '₱2,500.00', 'items' => 8, 'total' => '₱20,000.00', 'city' => 'Cavite', 'status' => 'Delivered'],
            ['orderID' => 'ORD-105', 'Name' => 'Jose Rizal', 'product' => 'NVMe M.2 SSD 1TB', 'amount' => '₱4,000.00', 'items' => 4, 'total' => '₱16,000.00', 'city' => 'Manila', 'status' => 'In Transit'],
            ['orderID' => 'ORD-106', 'Name' => 'Andres Bonifacio', 'product' => 'Graphics Card RTX 4060', 'amount' => '₱20,000.00', 'items' => 2, 'total' => '₱40,000.00', 'city' => 'Bulacan', 'status' => 'Delivered'],
            ['orderID' => 'ORD-107', 'Name' => 'Emilio Aguinaldo', 'product' => 'Gaming Monitor 27"', 'amount' => '₱12,000.00', 'items' => 3, 'total' => '₱36,000.00', 'city' => 'Cavite', 'status' => 'In Transit'],
            ['orderID' => 'ORD-108', 'Name' => 'Apolinario Mabini', 'product' => 'Mechanical Keyboard', 'amount' => '₱1,500.00', 'items' => 12, 'total' => '₱18,000.00', 'city' => 'Laguna', 'status' => 'Delayed'],
            ['orderID' => 'ORD-109', 'Name' => 'Gabriela Silang', 'product' => 'Wireless Mouse', 'amount' => '₱800.00', 'items' => 15, 'total' => '₱12,000.00', 'city' => 'Batangas', 'status' => 'Delivered'],
            ['orderID' => 'ORD-110', 'Name' => 'Melchora Aquino', 'product' => 'Power Supply 650W', 'amount' => '₱3,500.00', 'items' => 6, 'total' => '₱21,000.00', 'city' => 'Manila', 'status' => 'In Transit'],
            ['orderID' => 'ORD-111', 'Name' => 'Antonio Luna', 'product' => 'PC Case ATX', 'amount' => '₱2,200.00', 'items' => 7, 'total' => '₱15,400.00', 'city' => 'Bulacan', 'status' => 'In Transit'],
            ['orderID' => 'ORD-112', 'Name' => 'Marcelo del Pilar', 'product' => 'CPU Cooler Fan', 'amount' => '₱1,200.00', 'items' => 10, 'total' => '₱12,000.00', 'city' => 'Cavite', 'status' => 'Delivered'],
            ['orderID' => 'ORD-113', 'Name' => 'Juan Luna', 'product' => 'Intel Core i5 Processor', 'amount' => '₱9,500.00', 'items' => 3, 'total' => '₱28,500.00', 'city' => 'Laguna', 'status' => 'In Transit'],
            ['orderID' => 'ORD-114', 'Name' => 'Leonor Rivera', 'product' => 'AMD Ryzen 7 Processor', 'amount' => '₱14,000.00', 'items' => 2, 'total' => '₱28,000.00', 'city' => 'Batangas', 'status' => 'Delayed'],
            ['orderID' => 'ORD-115', 'Name' => 'Gregoria de Jesus', 'product' => 'Thermal Paste Tube', 'amount' => '₱250.00', 'items' => 40, 'total' => '₱10,000.00', 'city' => 'Manila', 'status' => 'Delivered'],
            ['orderID' => 'ORD-116', 'Name' => 'Sultan Kudarat', 'product' => 'External Hard Drive 2TB', 'amount' => '₱4,500.00', 'items' => 5, 'total' => '₱22,500.00', 'city' => 'Bulacan', 'status' => 'In Transit'],
            ['orderID' => 'ORD-117', 'Name' => 'Diego Silang', 'product' => 'HDMI Cable 2.0', 'amount' => '₱300.00', 'items' => 25, 'total' => '₱7,500.00', 'city' => 'Cavite', 'status' => 'Delivered'],
            ['orderID' => 'ORD-118', 'Name' => 'Francisco Baltazar', 'product' => 'DisplayPort Cable', 'amount' => '₱400.00', 'items' => 20, 'total' => '₱8,000.00', 'city' => 'Laguna', 'status' => 'In Transit'],
            ['orderID' => 'ORD-119', 'Name' => 'Claro M. Recto', 'product' => 'LAN Cable 10m', 'amount' => '₱350.00', 'items' => 30, 'total' => '₱10,500.00', 'city' => 'Batangas', 'status' => 'Delivered'],
            ['orderID' => 'ORD-120', 'Name' => 'Trinidad Tecson', 'product' => 'USB-C Hub Adapter', 'amount' => '₱900.00', 'items' => 14, 'total' => '₱12,600.00', 'city' => 'Manila', 'status' => 'In Transit'],
            ['orderID' => 'ORD-121', 'Name' => 'Wenceslao Vinzons', 'product' => 'Bluetooth Adapter', 'amount' => '₱450.00', 'items' => 18, 'total' => '₱8,100.00', 'city' => 'Bulacan', 'status' => 'In Transit'],
            ['orderID' => 'ORD-122', 'Name' => 'Vicente Lim', 'product' => 'Web Camera 1080p', 'amount' => '₱1,800.00', 'items' => 6, 'total' => '₱10,800.00', 'city' => 'Cavite', 'status' => 'Delivered'],
            ['orderID' => 'ORD-123', 'Name' => 'Jose Abad Santos', 'product' => 'Headset Gaming', 'amount' => '₱2,100.00', 'items' => 9, 'total' => '₱18,900.00', 'city' => 'Laguna', 'status' => 'In Transit'],
            ['orderID' => 'ORD-124', 'Name' => 'Artemio Ricarte', 'product' => 'Desk Pad Extended', 'amount' => '₱500.00', 'items' => 22, 'total' => '₱11,000.00', 'city' => 'Batangas', 'status' => 'Delivered'],
            ['orderID' => 'ORD-125', 'Name' => 'Rafael Palma', 'product' => 'Laptop Stand Aluminum', 'amount' => '₱1,100.00', 'items' => 11, 'total' => '₱12,100.00', 'city' => 'Manila', 'status' => 'In Transit'],
            ['orderID' => 'ORD-126', 'Name' => 'Jorge B. Vargas', 'product' => 'Surge Protector Strip', 'amount' => '₱750.00', 'items' => 16, 'total' => '₱12,000.00', 'city' => 'Bulacan', 'status' => 'Delivered'],
            ['orderID' => 'ORD-127', 'Name' => 'Elpidio Quirino', 'product' => 'Motherboard B550M', 'amount' => '₱6,500.00', 'items' => 4, 'total' => '₱26,000.00', 'city' => 'Cavite', 'status' => 'In Transit'],
            ['orderID' => 'ORD-128', 'Name' => 'Ramon Magsaysay', 'product' => 'RAM DDR5 32GB', 'amount' => '₱6,000.00', 'items' => 5, 'total' => '₱30,000.00', 'city' => 'Laguna', 'status' => 'In Transit'],
            ['orderID' => 'ORD-129', 'Name' => 'Carlos P. Garcia', 'product' => 'SSD 500GB SATA', 'amount' => '₱2,300.00', 'items' => 10, 'total' => '₱23,000.00', 'city' => 'Batangas', 'status' => 'Delivered'],
            ['orderID' => 'ORD-130', 'Name' => 'Diosdado Macapagal', 'product' => 'Graphics Card GTX 1650', 'amount' => '₱8,500.00', 'items' => 3, 'total' => '₱25,500.00', 'city' => 'Manila', 'status' => 'In Transit'],
            ['orderID' => 'ORD-131', 'Name' => 'Ferdinand Marcos', 'product' => 'CPU Liquid Cooler', 'amount' => '₱4,200.00', 'items' => 7, 'total' => '₱29,400.00', 'city' => 'Bulacan', 'status' => 'Delivered'],
            ['orderID' => 'ORD-132', 'Name' => 'Corazon Aquino', 'product' => 'Cabinet Fan RGB Pack', 'amount' => '₱1,500.00', 'items' => 12, 'total' => '₱18,000.00', 'city' => 'Cavite', 'status' => 'In Transit'],
            ['orderID' => 'ORD-133', 'Name' => 'Fidel V. Ramos', 'product' => 'UPS Battery Backup', 'amount' => '₱5,500.00', 'items' => 4, 'total' => '₱22,000.00', 'city' => 'Laguna', 'status' => 'In Transit'],
            ['orderID' => 'ORD-134', 'Name' => 'Joseph Estrada', 'product' => 'Wi-Fi 6 Router', 'amount' => '₱3,200.00', 'items' => 8, 'total' => '₱25,600.00', 'city' => 'Batangas', 'status' => 'Delivered'],
            ['orderID' => 'ORD-135', 'Name' => 'Gloria Macapagal-Arroyo', 'product' => 'Network Switch 8-Port', 'amount' => '₱1,000.00', 'items' => 15, 'total' => '₱15,000.00', 'city' => 'Manila', 'status' => 'In Transit'],
            ['orderID' => 'ORD-136', 'Name' => 'Benigno Aquino III', 'product' => 'Patch Panel 24-Port', 'amount' => '₱2,800.00', 'items' => 5, 'total' => '₱14,000.00', 'city' => 'Bulacan', 'status' => 'Delivered'],
            ['orderID' => 'ORD-137', 'Name' => 'Rodrigo Duterte', 'product' => 'Rack Mount 4U', 'amount' => '₱7,000.00', 'items' => 2, 'total' => '₱14,000.00', 'city' => 'Cavite', 'status' => 'In Transit'],
            ['orderID' => 'ORD-138', 'Name' => 'Ferdinand Marcos Jr.', 'product' => 'Server Enclosure', 'amount' => '₱15,000.00', 'items' => 1, 'total' => '₱15,000.00', 'city' => 'Laguna', 'status' => 'Delivered'],
            ['orderID' => 'ORD-139', 'Name' => 'Leni Robredo', 'product' => 'KVM Switch 2-Port', 'amount' => '₱1,600.00', 'items' => 9, 'total' => '₱14,400.00', 'city' => 'Batangas', 'status' => 'In Transit'],
            ['orderID' => 'ORD-140', 'Name' => 'Isko Moreno', 'product' => 'SATA Data Cable', 'amount' => '₱150.00', 'items' => 50, 'total' => '₱7,500.00', 'city' => 'Manila', 'status' => 'Delivered'],
            ['orderID' => 'ORD-141', 'Name' => 'Sara Duterte', 'product' => 'Case Screws Kit', 'amount' => '₱200.00', 'items' => 45, 'total' => '₱9,000.00', 'city' => 'Bulacan', 'status' => 'In Transit'],
            ['orderID' => 'ORD-142', 'Name' => 'Vicente Sotto III', 'product' => 'Motherboard Z790', 'amount' => '₱13,500.00', 'items' => 3, 'total' => '₱40,500.00', 'city' => 'Cavite', 'status' => 'Delivered'],
            ['orderID' => 'ORD-143', 'Name' => 'Alan Peter Cayetano', 'product' => 'CPU i7-14700K', 'amount' => '₱22,000.00', 'items' => 2, 'total' => '₱44,000.00', 'city' => 'Laguna', 'status' => 'In Transit'],
            ['orderID' => 'ORD-144', 'Name' => 'Manny Pacquiao', 'product' => 'GPU RTX 4070 Ti', 'amount' => '₱45,000.00', 'items' => 1, 'total' => '₱45,000.00', 'city' => 'Batangas', 'status' => 'Delivered'],
            ['orderID' => 'ORD-145', 'Name' => 'Panfilo Lacson', 'product' => 'PSU 850W Gold', 'amount' => '₱6,800.00', 'items' => 5, 'total' => '₱34,000.00', 'city' => 'Manila', 'status' => 'In Transit'],
            ['orderID' => 'ORD-146', 'Name' => 'Chris Tiu', 'product' => 'Monitor Arm Dual', 'amount' => '₱3,000.00', 'items' => 6, 'total' => '₱18,000.00', 'city' => 'Bulacan', 'status' => 'Delivered'],
            ['orderID' => 'ORD-147', 'Name' => 'Willie Revillame', 'product' => 'Ergonomic Chair', 'amount' => '₱8,000.00', 'items' => 4, 'total' => '₱32,000.00', 'city' => 'Cavite', 'status' => 'In Transit'],
            ['orderID' => 'ORD-148', 'Name' => 'Charo Santos', 'product' => 'Standing Desk Frame', 'amount' => '₱11,000.00', 'items' => 3, 'total' => '₱33,000.00', 'city' => 'Laguna', 'status' => 'Delivered'],
            ['orderID' => 'ORD-149', 'Name' => 'Atom Araullo', 'product' => 'Portable Monitor 15.6"', 'amount' => '₱7,500.00', 'items' => 5, 'total' => '₱37,500.00', 'city' => 'Batangas', 'status' => 'In Transit'],
            ['orderID' => 'ORD-150', 'Name' => 'Jessica Soho', 'product' => 'Microphone Condenser USB', 'amount' => '₱3,800.00', 'items' => 7, 'total' => '₱26,600.00', 'city' => 'Manila', 'status' => 'Delivered']
        ];

        foreach ($shipments as $data) {
            Shipment::updateOrCreate(['orderID' => $data['orderID']], $data);
        }
    }
}