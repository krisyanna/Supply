@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col overflow-y-auto">
    
    <!-- Header -->
    <header class="flex justify-between items-center px-10 py-8 bg-white border-b border-slate-100">
        <div>
            <h2 class="text-[22px] font-extrabold text-slate-900 tracking-tight">Procurement &amp; Supplier Coordination</h2>
            <p class="text-sm text-slate-500 mt-1">Dynamic UI Mode (Connected to Database)</p>
        </div>
    </header>

    <!-- KPI Cards -->
    <div class="grid grid-cols-4 gap-6 px-10 py-8">
        <!-- Card 1 -->
        <div class="border border-slate-200/80 rounded-2xl p-6 shadow-sm bg-white flex justify-between items-center gap-3 overflow-hidden">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1 truncate">Total Suppliers</p>
                <p class="text-[32px] font-black text-slate-900 tracking-tight truncate">{{ $kpi_summary['total_suppliers'] }}</p>
            </div>
            <div class="shrink-0">
                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
        
        <!-- Card 2 -->
        <div class="border border-slate-200/80 rounded-2xl p-6 shadow-sm bg-white flex justify-between items-center gap-3 overflow-hidden">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1 truncate">Active Contracts</p>
                <p class="text-[32px] font-black brand-purple-text tracking-tight truncate">{{ $kpi_summary['active_contracts'] }}</p>
            </div>
            <div class="shrink-0">
                <svg class="w-12 h-12 text-[#4f46e5]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
        
        <!-- Card 3 -->
        <div class="border border-slate-200/80 rounded-2xl p-6 shadow-sm bg-white flex justify-between items-center gap-3 overflow-hidden">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1 truncate">Pending Reviews</p>
                <p class="text-[32px] font-black text-orange-500 tracking-tight truncate">{{ $kpi_summary['pending_reviews'] }}</p>
            </div>
            <div class="shrink-0">
                <svg class="w-12 h-12 text-orange-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        
        <!-- Card 4 -->
        <div class="border border-slate-200/80 rounded-2xl p-6 shadow-sm bg-white flex justify-between items-center gap-3 overflow-hidden">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1 truncate">Avg. Performance</p>
                <p class="text-[32px] font-black text-slate-900 tracking-tight truncate">{{ $kpi_summary['avg_performance'] }}</p>
            </div>
            <div class="shrink-0">
                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
    </div>

    <!-- Data Table (Ledger) -->
    <div class="px-10 pb-10">
        <div class="border border-slate-200/80 rounded-2xl shadow-sm bg-white overflow-hidden">
            <div class="px-7 py-5 border-b border-slate-100 bg-white">
                <h3 class="text-[15px] font-extrabold text-slate-900">Supplier Management Ledger</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-[11px] text-slate-400 bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th scope="col" class="px-7 py-4 font-bold uppercase tracking-wider">Supplier Name</th>
                            <th scope="col" class="px-7 py-4 font-bold uppercase tracking-wider">Contact Person</th>
                            <th scope="col" class="px-7 py-4 font-bold uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-7 py-4 font-bold uppercase tracking-wider">Performance Score</th>
                            <th scope="col" class="px-7 py-4 font-bold uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($supplier_list as $supplier)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-7 py-4 font-bold brand-purple-text">{{ $supplier['name'] }}</td>
                            <td class="px-7 py-4 text-slate-600 font-medium">{{ $supplier['contact'] }}</td>
                            <td class="px-7 py-4 text-slate-700 font-semibold">{{ $supplier['category'] }}</td>
                            <td class="px-7 py-4 text-slate-700 font-bold">{{ $supplier['performance'] }}</td>
                            <td class="px-7 py-4">
                                <span class="px-3.5 py-1.5 rounded-md text-[11px] font-bold tracking-wide {{ $supplier['status_color'] }}">
                                    {{ $supplier['status'] }}
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