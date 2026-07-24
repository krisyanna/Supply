<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcurementController extends Controller
{
    public function index()
    {
        // Standalone KPI Data tailored for Reordering
        $kpi_summary = [
            'items_to_reorder' => 14,
            'high_priority' => 5,
            'total_est_cost' => '₱245,000.00',
            'suppliers_involved' => 4
        ];

        // Data structure based precisely on image_8384c8.png requirements
        $reorder_list = [
            [
                'product' => 'Industrial Lubricant (50L)',
                'recommended_qty' => '20 Barrels',
                'supplier' => 'Apex Heavy Machinery',
                'priority' => 'High',
                'priority_color' => 'bg-red-100 text-red-700'
            ],
            [
                'product' => 'Server Racks (Standard 42U)',
                'recommended_qty' => '5 Units',
                'supplier' => 'TechSource Global',
                'priority' => 'Medium',
                'priority_color' => 'bg-orange-100 text-orange-700'
            ],
            [
                'product' => 'Raw Steel Beams',
                'recommended_qty' => '50 Tons',
                'supplier' => 'BuildRight Materials',
                'priority' => 'Medium',
                'priority_color' => 'bg-orange-100 text-orange-700'
            ],
            [
                'product' => 'A4 Bond Paper (Ream)',
                'recommended_qty' => '100 Boxes',
                'supplier' => 'Office Essentials Inc.',
                'priority' => 'Low',
                'priority_color' => 'bg-green-100 text-green-700'
            ],
            [
                'product' => 'Hydraulic Pump Components',
                'recommended_qty' => '12 Sets',
                'supplier' => 'Apex Heavy Machinery',
                'priority' => 'High',
                'priority_color' => 'bg-red-100 text-red-700'
            ],
        ];

        return view('procurement.index', compact('kpi_summary', 'reorder_list'));
    }

    public function suppliers()
    {
        // Standalone KPI Data tailored for Supplier Management
        $kpi_summary = [
            'total_suppliers' => 24,
            'active_contracts' => 18,
            'pending_reviews' => 3,
            'avg_performance' => '94%'
        ];

        // Data structure for Suppliers
        $supplier_list = [
            [
                'name' => 'Apex Heavy Machinery',
                'contact' => 'Michael Chang (m.chang@apex.com)',
                'category' => 'Heavy Equipment',
                'performance' => '95%',
                'status' => 'Active',
                'status_color' => 'bg-green-100 text-green-700'
            ],
            [
                'name' => 'TechSource Global',
                'contact' => 'Sarah Jenkins (s.jenkins@techsource.com)',
                'category' => 'IT Infrastructure',
                'performance' => '98%',
                'status' => 'Active',
                'status_color' => 'bg-green-100 text-green-700'
            ],
            [
                'name' => 'BuildRight Materials',
                'contact' => 'David Torres (dtorres@buildright.com)',
                'category' => 'Raw Materials',
                'performance' => '88%',
                'status' => 'Under Review',
                'status_color' => 'bg-orange-100 text-orange-700'
            ],
            [
                'name' => 'Office Essentials Inc.',
                'contact' => 'Lisa Wong (lwong@officeessentials.com)',
                'category' => 'General Supplies',
                'performance' => '91%',
                'status' => 'Active',
                'status_color' => 'bg-green-100 text-green-700'
            ],
        ];

        return view('procurement.suppliers', compact('kpi_summary', 'supplier_list'));
    }

    public function poManagement()
    {
        // Standalone KPI Data for PO Management
        $kpi_summary = [
            'total_pos' => 128,
            'pending_approval' => 12,
            'total_value' => '₱3,450,000.00',
            'delayed_pos' => 3
        ];

        // PO Data List
        $po_list = [
            [
                'po_number' => '#PO-9001',
                'supplier' => 'TechSource Global',
                'order_date' => '20 Sept 2026',
                'amount' => '₱450,000.00',
                'status' => 'Approved',
                'status_color' => 'bg-green-100 text-green-700'
            ],
            [
                'po_number' => '#PO-9002',
                'supplier' => 'Apex Heavy Machinery',
                'order_date' => '22 Sept 2026',
                'amount' => '₱1,200,000.00',
                'status' => 'Pending Approval',
                'status_color' => 'bg-orange-100 text-orange-700'
            ],
            [
                'po_number' => '#PO-9003',
                'supplier' => 'BuildRight Materials',
                'order_date' => '18 Sept 2026',
                'amount' => '₱85,500.00',
                'status' => 'Delivered',
                'status_color' => 'bg-blue-100 text-blue-700'
            ],
            [
                'po_number' => '#PO-9004',
                'supplier' => 'Office Essentials Inc.',
                'order_date' => '23 Sept 2026',
                'amount' => '₱12,400.00',
                'status' => 'Approved',
                'status_color' => 'bg-green-100 text-green-700'
            ],
            [
                'po_number' => '#PO-9005',
                'supplier' => 'Global Freight Logistics',
                'order_date' => '15 Sept 2026',
                'amount' => '₱340,000.00',
                'status' => 'Delayed',
                'status_color' => 'bg-red-100 text-red-700'
            ]
        ];

        return view('procurement.po', compact('kpi_summary', 'po_list'));
    }

    public function goodsReceipt()
    {
        $kpi_summary = [
            'total_receipts' => 84,
            'matched_invoices' => 78,
            'discrepancies' => 2,
            'pending_matching' => 4
        ];

        $receipt_list = [
            [
                'gr_code' => '#GR-5001',
                'po_code' => '#PO-9001',
                'supplier' => 'TechSource Global',
                'received_date' => '21 Sept 2026',
                'invoice_match' => 'Fully Matched',
                'status' => 'Verified',
                'status_color' => 'bg-green-100 text-green-700'
            ],
            [
                'gr_code' => '#GR-5002',
                'po_code' => '#PO-9002',
                'supplier' => 'Apex Heavy Machinery',
                'received_date' => '23 Sept 2026',
                'invoice_match' => 'Price Variance Found',
                'status' => 'Discrepancy',
                'status_color' => 'bg-red-100 text-red-700'
            ],
            [
                'gr_code' => '#GR-5003',
                'po_code' => '#PO-9003',
                'supplier' => 'BuildRight Materials',
                'received_date' => '19 Sept 2026',
                'invoice_match' => 'Fully Matched',
                'status' => 'Verified',
                'status_color' => 'bg-green-100 text-green-700'
            ]
        ];

        return view('procurement.goods-receipt', compact('kpi_summary', 'receipt_list'));
    }














} 
