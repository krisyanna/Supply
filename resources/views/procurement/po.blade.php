@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col overflow-y-auto bg-slate-50/40 p-6 lg:p-8 gap-6">
    
    <!-- Top Header Card -->
    <div class="bg-white border border-slate-200/75 rounded-3xl p-8 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight">Purchase Order Management</h2>
            <p class="text-[13px] text-slate-500 mt-1 font-medium">Complete Purchase Order Ledger — Real-time Database Synchronization</p>
        </div>
        <div class="bg-emerald-50 text-emerald-600 px-4 py-2.5 rounded-full font-bold text-xs border border-emerald-100 flex items-center gap-2.5 shadow-sm shrink-0">
            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
            {{ $kpi_summary['total_pos'] ?? '0' }} Records Synced
        </div>
    </div>

    <!-- KPI Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Total POs -->
        <div class="bg-white border border-slate-200/75 rounded-3xl p-6 shadow-sm flex flex-col justify-between group hover:border-indigo-200 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Total POs</p>
                <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-indigo-500 group-hover:bg-indigo-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
            <p class="text-[38px] font-black text-slate-900 tracking-tight leading-none">{{ $kpi_summary['total_pos'] }}</p>
        </div>
        
        <!-- Card 2: Pending Approval -->
        <div class="bg-white border border-slate-200/75 rounded-3xl p-6 shadow-sm flex flex-col justify-between group hover:border-indigo-200 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Pending Approval</p>
                <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-orange-500 group-hover:bg-orange-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-[38px] font-black text-indigo-600 tracking-tight leading-none">{{ $kpi_summary['pending_approval'] }}</p>
        </div>
        
        <!-- Card 3: Delayed POs -->
        <div class="bg-white border border-slate-200/75 rounded-3xl p-6 shadow-sm flex flex-col justify-between group hover:border-indigo-200 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Delayed POs</p>
                <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-rose-500 group-hover:bg-rose-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <p class="text-[38px] font-black text-rose-500 tracking-tight leading-none">{{ $kpi_summary['delayed_pos'] }}</p>
        </div>
        
        <!-- Card 4: Total PO Value -->
        <div class="bg-white border border-slate-200/75 rounded-3xl p-6 shadow-sm flex flex-col justify-between group hover:border-indigo-200 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Total PO Value</p>
                <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-emerald-500 group-hover:bg-emerald-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <!-- Scaled down text slightly so large currency amounts don't overflow the box -->
            <p class="text-[28px] font-black text-slate-900 tracking-tight leading-none truncate">{{ $kpi_summary['total_value'] }}</p>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="bg-white border border-slate-200/75 rounded-3xl shadow-sm overflow-hidden flex flex-col mb-10">
        <!-- Table Header & Controls -->
        <div class="px-8 py-7 border-b border-slate-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight">Complete Purchase Order Ledger</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Showing all synchronized PO records and status details</p>
            </div>
            
            <!-- Table Action Controls (Styled to match the reference image) -->
            <div class="flex items-center gap-3">
                
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text"class="pl-9 pr-4 py-2 text-[11px] font-semibold text-slate-900 bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm placeholder:text-slate-400 w-48 transition-all">
                </div>
            </div>
        </div>
        
        <!-- Table Body -->
        <div class="overflow-x-auto px-4 pb-4">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] text-slate-400 uppercase tracking-widest font-extrabold border-b border-slate-100">
                    <tr>
                        <th scope="col" class="px-6 py-5">PO Number</th>
                        <th scope="col" class="px-6 py-5">Supplier Name</th>
                        <th scope="col" class="px-6 py-5">Order Date</th>
                        <th scope="col" class="px-6 py-5">Total Amount</th>
                        <th scope="col" class="px-6 py-5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50/50">
                    @foreach($po_list as $po)
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                        <td class="px-6 py-4 font-bold text-indigo-900 text-xs">{{ $po['po_number'] }}</td>
                        <td class="px-6 py-4 text-slate-700 font-semibold text-xs">{{ $po['supplier'] }}</td>
                        <td class="px-6 py-4 text-slate-500 font-medium text-xs">{{ $po['order_date'] }}</td>
                        <td class="px-6 py-4 text-slate-700 font-semibold text-xs">{{ $po['amount'] }}</td>
                        <td class="px-6 py-4">
                            <!-- Utilizing the highly compact badge style -->
                            <span class="{{ $po['status_color'] }} border inline-block px-3 py-1 rounded-full text-[11px] font-bold tracking-wide whitespace-nowrap leading-none shadow-sm">
                                {{ $po['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection