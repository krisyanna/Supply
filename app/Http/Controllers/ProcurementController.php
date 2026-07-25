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
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->select('products.*', 'suppliers.name as supplier_name')
            ->whereColumn('products.current_stock', '<=', 'products.reorder_point')
            ->orderByRaw("FIELD(products.priority_level, 'High', 'Medium', 'Low')")
            ->get();

        // 3. Format the data to match your Blade @foreach loop
        $reorder_list = $products->map(function ($item) {
            $priorityColor = match ($item->priority_level ?? 'Low') {
                'High'   => 'bg-red-100 text-red-600',
                'Medium' => 'bg-orange-100 text-orange-600',
                'Low'    => 'bg-emerald-100 text-emerald-600',
                default  => 'bg-slate-100 text-slate-600',
            };

            return [
                'product'         => $item->product_name ?? 'Unknown Product',
                'recommended_qty' => ($item->reorder_quantity ?? 0) . ' ' . ($item->unit_type ?? ''),
                'supplier'        => $item->supplier_name ?? 'No Supplier',
                'priority'        => $item->priority_level ?? 'Low',
                'priority_color'  => $priorityColor,
            ];
        });

        return view('procurement.index', compact('kpi_summary', 'reorder_list'));
    }

    public function suppliers()
    {
        $suppliers = DB::table('suppliers')->get();

        $totalSuppliers  = $suppliers->count();
        $activeContracts = $suppliers->where('status', 'Active')->count();
        $pendingReviews  = $suppliers->where('status', 'Under Review')->count();
        $avgPerformance  = $suppliers->avg('rating');

        $kpi_summary = [
            'total_suppliers'  => $totalSuppliers,
            'active_contracts' => $activeContracts,
            'pending_reviews'  => $pendingReviews,
            'avg_performance'  => $avgPerformance ? number_format($avgPerformance, 2) : '0.00',
        ];

        $supplierRecords = DB::table('suppliers')
            ->orderBy('name', 'asc')
            ->get();

        // 3. Format the data to match your Blade @foreach loop
        // 3. Map and format each supplier record for the view
        $supplier_list = $supplierRecords->map(function ($item) {
            $status = $item->status ?? 'Active';
            
            $statusColor = match ($status) {
                'Active'       => 'bg-emerald-50 text-emerald-700 border border-emerald-200/60',
                'Under Review' => 'bg-amber-50 text-amber-700 border border-amber-200/60',
                'Inactive'     => 'bg-slate-100 text-slate-700 border border-slate-200/60',
                default        => 'bg-slate-100 text-slate-600',
            };

            // Expanded fallbacks to automatically catch whatever column name your database uses
            $contactName = data_get($item, 'contact_name') 
                        ?? data_get($item, 'contact_person') 
                        ?? data_get($item, 'contact') 
                        ?? data_get($item, 'contact_no') 
                        ?? 'N/A';

            $contactEmail = data_get($item, 'contact_email') 
                         ?? data_get($item, 'email') 
                         ?? data_get($item, 'contact_mail');
            
            $fullContact = $contactEmail && $contactName !== 'N/A' 
                ? "{$contactName} ({$contactEmail})" 
                : ($contactName !== 'N/A' ? $contactName : ($contactEmail ?? 'N/A'));

            return [
                'name'              => $item->name ?? 'Unknown Supplier',
                'contact'           => $fullContact,
                'category'          => $item->category ?? 'General',
                'sub_categories'    => $item->sub_categories ?? 'N/A',
                'payment_terms'     => $item->payment_terms ?? 'N/A',
                'performance'       => isset($item->rating) ? number_format($item->rating, 2) : 'N/A',
                'delivery_schedule' => $item->delivery_schedule ?? 'N/A',
                'status'            => $status,
                'status_color'      => $statusColor,
            ];
        });

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

        // 2. Fetch Dynamic Ledger Table Data safely aliasing supplier name
        $purchaseOrders = DB::table('purchase_orders')
            ->leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
            ->select('purchase_orders.*', 'suppliers.name as supplier_name')
            ->orderBy('purchase_orders.order_date', 'desc')
            ->orderBy('purchase_orders.po_number', 'desc')
            ->get();

        // 3. Format the data to match your Blade @foreach loop
        $po_list = $purchaseOrders->map(function ($item) {
            $status = $item->status ?? 'Pending Approval';
            
            $statusColor = match ($status) {
                'Approved'         => 'bg-emerald-50 text-emerald-700',
                'Delivered'        => 'bg-indigo-50 text-indigo-700',
                'Pending Approval' => 'bg-amber-50 text-amber-700',
                'Delayed'          => 'bg-rose-50 text-rose-700',
                default            => 'bg-slate-100 text-slate-600',
            };

            return [
                'po_number'    => $item->po_number ?? 'N/A',
                'supplier'     => $item->supplier_name ?? 'Unknown Supplier',
                'order_date'   => isset($item->order_date) ? date('d M Y', strtotime($item->order_date)) : 'N/A',
                'amount'       => '₱' . number_format($item->total_amount ?? 0, 2),
                'status'       => $status,
                'status_color' => $statusColor,
            ];
        });

        return view('procurement.po', compact('kpi_summary', 'po_list'));
    }

    public function goodsReceipt()
    {
        // 1. Calculate Dynamic KPIs for Goods Receipt
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

        // 2. Fetch Dynamic Ledger Table Data with safe column selection
        $receipts = DB::table('goods_receipts')
            ->leftJoin('purchase_orders', 'goods_receipts.po_id', '=', 'purchase_orders.id')
            ->leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
            ->select('goods_receipts.*', 'purchase_orders.po_number', 'suppliers.name as supplier_name')
            ->orderBy('goods_receipts.received_date', 'desc')
            ->get();

        // 3. Format the data to match your Blade @foreach loop
        $receipt_list = $receipts->map(function ($item) {
            $status = $item->status ?? 'In Progress';
            
            $statusColor = match ($status) {
                'Completed'     => 'bg-emerald-50 text-emerald-700',
                'In Progress'   => 'bg-indigo-50 text-indigo-700',
                'Action Needed' => 'bg-rose-50 text-rose-700',
                default         => 'bg-slate-100 text-slate-600',
            };

            return [
                'gr_code'       => $item->gr_code ?? 'N/A',
                'po_code'       => $item->po_number ?? 'N/A',
                'supplier'      => $item->supplier_name ?? 'Unknown Supplier',
                'received_date' => isset($item->received_date) ? date('d M Y', strtotime($item->received_date)) : 'N/A',
                'invoice_match' => $item->invoice_match_status ?? 'Pending',
                'status'        => $status,
                'status_color'  => $statusColor,
            ];
        });

        return view('procurement.goods-receipt', compact('kpi_summary', 'receipt_list'));
    }
}