<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProcurementController extends Controller
{
   public function index()
    {
        // 1. Calculate Dynamic KPIs (Kept in case your Blade file still uses the top cards)
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

        $kpi_summary = [
            'items_to_reorder'   => $itemsToReorder,
            'high_priority'      => $highPriority,
            'suppliers_involved' => $suppliersInvolved,
            'total_est_cost'     => '₱' . number_format($estRestockCost, 2),
        ];

        // The $reorder_list query and formatting have been completely removed!

        // Pass only the KPI summary to the view
        return view('procurement.index', compact('kpi_summary'));
    }

    public function suppliers()
    {
        // 1. Fetch raw supplier records from your database table
        $supplierRecords = DB::table('suppliers')->get();

        // 2. Compute dynamic KPI metrics
        $totalSuppliers = $supplierRecords->count();
        $activeContracts = $supplierRecords->where('status', 'Active')->count();
        $pendingReviews = $supplierRecords->where('status', 'Under Review')->count();
        
        // Calculate average performance rating safely
        $avgPerformance = $supplierRecords->avg('rating');
        $formattedAvgPerformance = $avgPerformance ? number_format($avgPerformance, 2) : '0.00';

        $kpi_summary = [
            'total_suppliers'  => $totalSuppliers,
            'active_contracts' => $activeContracts,
            'pending_reviews'  => $pendingReviews,
            'avg_performance'  => $formattedAvgPerformance,
        ];

        $supplier_list = DB::table('suppliers')->paginate(10);
        return view('procurement.suppliers', compact('kpi_summary', 'supplier_list'));
        
        
        

        
       
    }

   public function poManagement()
    {
        // 1. Calculate Dynamic KPIs for Purchase Orders (Using all records)
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

        // 2. Fetch PAGINATED Ledger Table Data (10 items per page)
        $po_list = DB::table('purchase_orders')
            ->leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
            ->select('purchase_orders.*', 'suppliers.name as supplier_name')
            ->orderBy('purchase_orders.order_date', 'desc')
            ->orderBy('purchase_orders.po_number', 'desc')
            ->paginate(10);

        // 3. Format the data directly on the Paginator's collection
        $po_list->getCollection()->transform(function ($po) {
            $color = 'bg-slate-100 text-slate-600 border-slate-200'; // Default
            
            if ($po->status === 'Approved') {
                $color = 'bg-emerald-50 text-emerald-600 border-emerald-200';
            } elseif ($po->status === 'Delayed') {
                $color = 'bg-rose-50 text-rose-600 border-rose-200';
            } elseif ($po->status === 'Pending Approval') {
                $color = 'bg-orange-50 text-orange-600 border-orange-200';
            } elseif ($po->status === 'Delivered') {
                $color = 'bg-indigo-50 text-indigo-600 border-indigo-200'; 
            }

            return [
                'po_number'    => $po->po_number,
                'supplier'     => $po->supplier_name,
                'order_date'   => \Carbon\Carbon::parse($po->order_date)->format('d M Y'),
                'amount'       => '₱' . number_format($po->total_amount, 2),
                'status'       => $po->status,
                'status_color' => $color,
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
    ->leftJoin('purchase_orders', 'goods_receipts.po_id', '=', 'purchase_orders.id') // Changed .po_id to .id
    ->leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
    ->select('goods_receipts.*', 'purchase_orders.po_number', 'suppliers.name as supplier_name')
    ->orderBy('goods_receipts.received_date', 'desc')
    ->get();
// 3. Format the data to match your Blade @foreach loop
       // 3. Format the data to match your Blade @foreach loop
$receipt_list = $receipts->map(function ($item) {
    $status = $item->status ?? 'Pending';
    
    // Add exact matches for the seeded data
    $statusColor = match ($status) {
    'Completed'            => 'bg-emerald-50 text-emerald-700 border-emerald-200',
    'Received'             => 'bg-blue-50 text-blue-700 border-blue-200',
    'Pending Verification' => 'bg-amber-50 text-amber-700 border-amber-200',
    'In Progress'          => 'bg-indigo-50 text-indigo-700 border-indigo-200',
    'Action Needed'        => 'bg-rose-50 text-rose-700 border-rose-200',
    default                => 'bg-slate-50 text-slate-600 border-slate-200',
};

    return [
        'gr_code'       => $item->grn_number ?? 'N/A',
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

   public function reorder()
{
    // Fetch suppliers directly from your local database model
    $suppliers = \App\Models\Supplier::all();

    // Fetch low-stock products from your local database
    $reorder_list = DB::table('products as p')
        ->whereColumn('p.current_stock', '<=', 'p.reorder_point')
        ->get()
        ->map(function($product) use ($suppliers) {
            
            // Match the supplier name using the supplier_id
            $supplier = $suppliers->firstWhere('id', $product->supplier_id);

            $product->product = $product->product_name ?? 'Unknown Product';
            $product->recommended_qty = ($product->reorder_quantity ?? 0) . ' ' . ($product->unit_type ?? 'pcs');
            
            // Dynamically grab the supplier name from your local database, with a clean fallback
            $product->supplier = $supplier->name ?? 'Unassigned'; 
            
            $product->priority = $product->priority_level ?? 'High';
            
            $product->priority_color = match(strtolower($product->priority)) {
                'high' => 'bg-rose-50 text-rose-700 border border-rose-200/80',
                'medium' => 'bg-amber-50 text-amber-700 border border-amber-200/80',
                default => 'bg-slate-100 text-slate-700 border border-slate-200'
            };

            return $product;
        });

    $kpi_summary = [
        'items_to_reorder'   => $reorder_list->count(),
        'high_priority'      => $reorder_list->where('priority', 'High')->count(),
        'suppliers_involved' => $reorder_list->unique('supplier')->count(),
        'total_est_cost'     => '₱' . number_format(
            DB::table('products')->whereColumn('current_stock', '<=', 'reorder_point')->sum(DB::raw('reorder_quantity * unit_cost')), 
            2
        ),
    ];

    return view('procurement.index', compact('reorder_list', 'kpi_summary'));

}
}