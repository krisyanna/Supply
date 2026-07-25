@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col overflow-y-auto">
    
    <!-- Header -->
    <header class="flex justify-between items-center px-10 py-8 bg-white border-b border-slate-100">
        <div>
            <h2 class="text-[22px] font-extrabold text-slate-900 tracking-tight">Goods Receipt &amp; Invoice Matching</h2>
            <p class="text-sm text-slate-500 mt-1">Dynamic UI Mode (Connected to Database)</p>
        </div>
    </header>

    <!-- KPI Cards for Goods Receipt -->
    <div class="grid grid-cols-4 gap-6 px-10 py-8">
        <!-- Card 1: Total Receipts -->
        <div class="border border-slate-200/80 rounded-2xl p-6 shadow-sm bg-white flex justify-between items-center gap-3 overflow-hidden">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1 truncate">Total Receipts</p>
                <p class="text-[32px] font-black text-slate-900 tracking-tight truncate">{{ $kpi_summary['total_receipts'] }}</p>
            </div>
            <div class="shrink-0">
                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
        </div>
        
        <!-- Card 2: Matched Invoices -->
        <div class="border border-slate-200/80 rounded-2xl p-6 shadow-sm bg-white flex justify-between items-center gap-3 overflow-hidden">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1 truncate">Matched Invoices</p>
                <p class="text-[32px] font-black text-emerald-500 tracking-tight truncate">{{ $kpi_summary['matched_invoices'] }}</p>
            </div>
            <div class="shrink-0">
                <svg class="w-12 h-12 text-emerald-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        
        <!-- Card 3: Discrepancies -->
        <div class="border border-slate-200/80 rounded-2xl p-6 shadow-sm bg-white flex justify-between items-center gap-3 overflow-hidden">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1 truncate">Discrepancies</p>
                <p class="text-[32px] font-black text-rose-500 tracking-tight truncate">{{ $kpi_summary['discrepancies'] }}</p>
            </div>
            <div class="shrink-0">
                <svg class="w-12 h-12 text-rose-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>
        
        <!-- Card 4: Pending Matching -->
        <div class="border border-slate-200/80 rounded-2xl p-6 shadow-sm bg-white flex justify-between items-center gap-3 overflow-hidden">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1 truncate">Pending Matching</p>
                <p class="text-[32px] font-black text-orange-500 tracking-tight truncate">{{ $kpi_summary['pending_matching'] }}</p>
            </div>
            <div class="shrink-0">
                <svg class="w-12 h-12 text-orange-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Data Table for Goods Receipt -->
    <div class="px-10 pb-10">
        <div class="border border-slate-200/80 rounded-2xl shadow-sm bg-white overflow-hidden">
            <div class="px-7 py-5 border-b border-slate-100 bg-white">
                <h3 class="text-[15px] font-extrabold text-slate-900">Goods Receipt &amp; Matching Ledger</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-[11px] text-slate-400 bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th scope="col" class="px-7 py-4 font-bold uppercase tracking-wider">GR Code</th>
                            <th scope="col" class="px-7 py-4 font-bold uppercase tracking-wider">PO Code</th>
                            <th scope="col" class="px-7 py-4 font-bold uppercase tracking-wider">Supplier Name</th>
                            <th scope="col" class="px-7 py-4 font-bold uppercase tracking-wider">Received Date</th>
                            <th scope="col" class="px-7 py-4 font-bold uppercase tracking-wider">Invoice Match Status</th>
                            <th scope="col" class="px-7 py-4 font-bold uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($receipt_list as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-7 py-4 font-bold brand-purple-text">{{ $item['gr_code'] }}</td>
                            <td class="px-7 py-4 text-slate-700 font-semibold">{{ $item['po_code'] }}</td>
                            <td class="px-7 py-4 text-slate-600 font-medium">{{ $item['supplier'] }}</td>
                            <td class="px-7 py-4 text-slate-600 font-medium">{{ $item['received_date'] }}</td>
                            <td class="px-7 py-4 text-slate-700 font-semibold">{{ $item['invoice_match'] }}</td>
                            <td class="px-7 py-4">
                                <span class="px-3.5 py-1.5 rounded-md text-[11px] font-bold tracking-wide {{ $item['status_color'] }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</main>
@endsection