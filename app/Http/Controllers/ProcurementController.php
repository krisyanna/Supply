<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcurementController extends Controller
{
    public function index()
    {
        // 1. Calculate Dynamic KPIs
        $itemsToReorder = DB::table('products')
            ->whereColumn('current_stock', '<=', 'reorder_point')
            ->count();

        $highPriority = DB::table('products')
            ->whereColumn('current_stock', '<=', 'reorder_point')
            ->where('priority_level', 'High')
            ->count();

        $suppliersInvolved = DB::table('products')
            ->whereColumn('current_stock', '<=', 'reorder_point')
            ->distinct('supplier_id')
            ->count('supplier_id');

        $estRestockCost = DB::table('products')
            ->whereColumn('current_stock', '<=', 'reorder_point')
            ->sum(DB::raw('reorder_quantity * unit_cost'));

        // Bind KPIs to the array your Blade file expects
        $kpi_summary = [
            'items_to_reorder'   => $itemsToReorder,
            'high_priority'      => $highPriority,
            'suppliers_involved' => $suppliersInvolved,
            'total_est_cost'     => '₱' . number_format($estRestockCost, 2),
        ];

        // 2. Fetch Dynamic Ledger Table Data
        $products = DB::table('products')
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.supplier_id')
            ->whereColumn('products.current_stock', '<=', 'products.reorder_point')
            ->orderByRaw("FIELD(products.priority_level, 'High', 'Medium', 'Low')")
            ->get();

        // 3. Format the data to match your Blade @foreach loop
        $reorder_list = $products->map(function ($item) {
            // Dynamically assign Tailwind colors based on priority
            $priorityColor = match ($item->priority_level) {
                'High'   => 'bg-red-100 text-red-600',
                'Medium' => 'bg-orange-100 text-orange-600',
                'Low'    => 'bg-emerald-100 text-emerald-600',
                default  => 'bg-slate-100 text-slate-600',
            };

            return [
                'product'         => $item->product_name,
                'recommended_qty' => $item->reorder_quantity . ' ' . $item->unit_type,
                'supplier'        => $item->supplier_name ?? 'No Supplier',
                'priority'        => $item->priority_level,
                'priority_color'  => $priorityColor,
            ];
        });

        // 4. Return the view and pass the data
        // Make sure your HTML file is saved as resources/views/procurement.blade.php
       return view('procurement.index', compact('kpi_summary', 'reorder_list'));

    }

    public function suppliers()
    {
        // 1. Calculate Dynamic KPIs for Supplier Management
        $totalSuppliers = DB::table('suppliers')->count();

        $activeContracts = DB::table('suppliers')
            ->where('status', 'Active')
            ->count();

        $pendingReviews = DB::table('suppliers')
            ->where('status', 'Under Review')
            ->count();

        // Calculate average performance, round it to a whole number
        $avgPerformance = DB::table('suppliers')->avg('performance_score');

        // Bind KPIs to the array your Blade file expects
        $kpi_summary = [
            'total_suppliers'  => $totalSuppliers,
            'active_contracts' => $activeContracts,
            'pending_reviews'  => $pendingReviews,
            'avg_performance'  => round((float) $avgPerformance) . '%',
        ];

        // 2. Fetch Dynamic Ledger Table Data
        $suppliers = DB::table('suppliers')
            ->orderByRaw("FIELD(status, 'Under Review', 'Active', 'Inactive')")
            ->orderBy('supplier_name', 'asc')
            ->get();

        // 3. Format the data to match your Blade @foreach loop
        $supplier_list = $suppliers->map(function ($item) {
            // Dynamically assign Tailwind colors based on the supplier's status
            $statusColor = match ($item->status) {
                'Active'       => 'bg-green-100 text-green-700',
                'Under Review' => 'bg-orange-100 text-orange-700',
                'Inactive'     => 'bg-rose-100 text-rose-700',
                default        => 'bg-slate-100 text-slate-600',
            };

            return [
                'name'         => $item->supplier_name,
                'contact'      => $item->contact_name . ' (' . $item->contact_email . ')',
                'category'     => $item->category,
                'performance'  => $item->performance_score . '%',
                'status'       => $item->status,
                'status_color' => $statusColor,
            ];
        });

        // 4. Return the view and pass the data
        // Make sure your HTML file is saved as resources/views/procurement/suppliers.blade.php
        return view('procurement.suppliers', compact('kpi_summary', 'supplier_list'));
    }
   public function poManagement()
    {
        // 1. Calculate Dynamic KPIs for Purchase Orders
        $totalPOs = DB::table('purchase_orders')->count();

        $pendingApproval = DB::table('purchase_orders')
            ->where('status', 'Pending Approval')
            ->count();

        $delayedPOs = DB::table('purchase_orders')
            ->where('status', 'Delayed')
            ->count();

        $totalValue = DB::table('purchase_orders')->sum('total_amount');

        // Bind KPIs to the array your Blade file expects
        $kpi_summary = [
            'total_pos'        => $totalPOs,
            'pending_approval' => $pendingApproval,
            'delayed_pos'      => $delayedPOs,
            'total_value'      => '₱' . number_format($totalValue, 2),
        ];

        // 2. Fetch Dynamic Ledger Table Data
        $purchaseOrders = DB::table('purchase_orders')
            ->leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.supplier_id')
            ->orderBy('purchase_orders.order_date', 'desc')
            ->orderBy('purchase_orders.po_number', 'desc')
            ->get();

        // 3. Format the data to match your Blade @foreach loop
        $po_list = $purchaseOrders->map(function ($item) {
            // Dynamically assign Tailwind colors based on the PO status
            $statusColor = match ($item->status) {
                'Approved'         => 'bg-green-100 text-green-700',
                'Delivered'        => 'bg-indigo-100 text-indigo-700',
                'Pending Approval' => 'bg-orange-100 text-orange-700',
                'Delayed'          => 'bg-rose-100 text-rose-700',
                default            => 'bg-slate-100 text-slate-600',
            };

            return [
                'po_number'    => $item->po_number,
                'supplier'     => $item->supplier_name ?? 'Unknown Supplier',
                'order_date'   => date('d M Y', strtotime($item->order_date)),
                'amount'       => '₱' . number_format($item->total_amount, 2),
                'status'       => $item->status,
                'status_color' => $statusColor,
            ];
        });

        // 4. Return the view and pass the data
        // Ensure your HTML file is saved as resources/views/procurement/po_management.blade.php
        return view('procurement.po', compact('kpi_summary', 'po_list'));
    }

    public function goodsReceipt()
    {
        // 1. Calculate Dynamic KPIs for Goods Receipt
        // Assuming your table is named 'goods_receipts' and has an 'invoice_match_status' column
        $totalReceipts = DB::table('goods_receipts')->count();

        $matchedInvoices = DB::table('goods_receipts')
            ->where('invoice_match_status', 'Matched')
            ->count();

        $discrepancies = DB::table('goods_receipts')
            ->where('invoice_match_status', 'Discrepancy')
            ->count();

        $pendingMatching = DB::table('goods_receipts')
            ->where('invoice_match_status', 'Pending')
            ->count();

        // Bind KPIs to the array your Blade file expects
        $kpi_summary = [
            'total_receipts'   => $totalReceipts,
            'matched_invoices' => $matchedInvoices,
            'discrepancies'    => $discrepancies,
            'pending_matching' => $pendingMatching,
        ];

        // 2. Fetch Dynamic Ledger Table Data
        // Joining with purchase_orders and suppliers to get the PO number and Supplier name
        $receipts = DB::table('goods_receipts')
            ->leftJoin('purchase_orders', 'goods_receipts.po_id', '=', 'purchase_orders.po_id')
            ->leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.supplier_id')
            ->orderBy('goods_receipts.received_date', 'desc')
            ->get();

        // 3. Format the data to match your Blade @foreach loop
        $receipt_list = $receipts->map(function ($item) {
            // Dynamically assign Tailwind colors based on the GR status
            $statusColor = match ($item->status) {
                'Completed'     => 'bg-green-100 text-green-700',
                'In Progress'   => 'bg-indigo-100 text-indigo-700',
                'Action Needed' => 'bg-rose-100 text-rose-700',
                default         => 'bg-slate-100 text-slate-600',
            };

            return [
                'gr_code'       => $item->gr_code,
                'po_code'       => $item->po_number ?? 'N/A', // Pulled from the purchase_orders join
                'supplier'      => $item->supplier_name ?? 'Unknown Supplier', // Pulled from the suppliers join
                'received_date' => date('d M Y', strtotime($item->received_date)),
                'invoice_match' => $item->invoice_match_status,
                'status'        => $item->status,
                'status_color'  => $statusColor,
            ];
        });

        // 4. Return the view and pass the data
        // Ensure your HTML file is saved as resources/views/procurement/goods_receipt.blade.php
       return view('procurement.goods-receipt', compact('kpi_summary', 'receipt_list'));
    }
    




} 
