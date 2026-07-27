@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col overflow-y-auto bg-slate-100/60 p-4 lg:p-6">
    
    <!-- Header (Full Fluid Width) -->
    <header class="w-full flex justify-between items-center px-6 lg:px-8 py-5 bg-white border border-slate-200/80 rounded-2xl shadow-2xs mb-4">
        <div>
            <h2 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Purchase Order Management</h2>
            <p class="text-xs lg:text-sm text-slate-500 mt-0.5">Complete Purchase Order Ledger &mdash; Real-time Database Synchronization</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs lg:text-sm font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                {{ $kpi_summary['total_pos'] ?? '0' }} Records Synced
            </span>
        </div>
    </header>

    <!-- KPI Cards Grid (Full Fluid Width) -->
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        
        <!-- Card 1: Total POs -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Total POs</p>
                <p class="text-3xl font-black text-slate-900 tracking-tight truncate">{{ $kpi_summary['total_pos'] }}</p>
            </div>
            <div class="shrink-0 p-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
        
        <!-- Card 2: Pending Approval -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Pending Approval</p>
                <p class="text-3xl font-black text-indigo-600 tracking-tight truncate">{{ $kpi_summary['pending_approval'] }}</p>
            </div>
            <div class="shrink-0 p-3 bg-indigo-50/70 rounded-xl border border-indigo-100 text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        
        <!-- Card 3: Delayed POs -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Delayed POs</p>
                <p class="text-3xl font-black text-rose-500 tracking-tight truncate">{{ $kpi_summary['delayed_pos'] }}</p>
            </div>
            <div class="shrink-0 p-3 bg-rose-50/70 rounded-xl border border-rose-100 text-rose-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>
        
        <!-- Card 4: Total PO Value -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 xl:p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-2">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Total PO Value</p>
                <p class="text-[18px] lg:text-[16px] xl:text-[20px] 2xl:text-[24px] font-black text-slate-900 tracking-tighter leading-none pt-1">{{ $kpi_summary['total_value'] }}</p>
            </div>
            <div class="shrink-0 p-2 xl:p-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-600">
                <svg class="w-5 h-5 xl:w-6 xl:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 10h8M8 13h8M10 7v10M10 7h4a3 3 0 010 6h-4"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Data Table Container (Full Fluid Width) -->
    <div class="w-full flex-1 flex flex-col mb-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden flex-1 flex flex-col">
            
            <!-- Table Header Bar -->
            <div class="px-6 lg:px-8 py-5 border-b border-slate-200/60 bg-white flex flex-col xl:flex-row justify-between items-start gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Complete Purchase Order Ledger</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Showing all synchronized PO records and status details</p>
                </div>
            </div>
            
            <!-- Table Body -->
            <div class="w-full overflow-hidden flex-1">
                <table class="w-full text-xs text-left border-collapse">
                    <thead class="bg-slate-50/90 text-slate-500 font-semibold uppercase tracking-wider text-[10px] sticky top-0 border-b border-slate-200/60 z-10 backdrop-blur-xs">
                        <tr>
                            <th scope="col" class="px-6 py-3">PO Number</th>
                            <th scope="col" class="px-6 py-3">Supplier Name</th>
                            <th scope="col" class="px-6 py-3">Order Date</th>
                            <th scope="col" class="px-6 py-3">Total Amount</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($po_list as $po)
                        <tr class="hover:bg-slate-50/75 transition-colors duration-150">
                            <!-- Note: Changed $po array access to object access if using pagination -->
                            <td class="px-6 py-3 font-bold text-indigo-900 text-xs truncate">{{ $po['po_number'] ?? $po->po_number ?? '' }}</td>
                            <td class="px-6 py-3 font-semibold text-slate-700 text-xs truncate">{{ $po['supplier'] ?? $po->supplier_name ?? '' }}</td>
                            <td class="px-6 py-3 font-medium text-slate-500 text-xs truncate">{{ $po['order_date'] ?? $po->order_date ?? '' }}</td>
                            <td class="px-6 py-3 font-semibold text-slate-700 text-xs truncate">{{ $po['amount'] ?? '₱'.number_format($po->total_amount ?? 0, 2) }}</td>
                            <td class="px-6 py-3">
                                <span class="{{ $po['status_color'] ?? 'bg-slate-100 text-slate-700' }} border inline-block px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide whitespace-nowrap leading-none shadow-2xs">
                                    {{ $po['status'] ?? $po->status ?? '' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if(method_exists($po_list, 'hasPages') && $po_list->hasPages())
                <div class="flex flex-col sm:flex-row items-center justify-between pt-4 border-t border-slate-200/60 gap-3 text-xs bg-white px-6 lg:px-8 py-3.5">
                    <div class="text-slate-500 font-medium">
                        Showing <span class="font-bold text-slate-800">{{ $po_list->firstItem() }}</span> to <span class="font-bold text-slate-800">{{ $po_list->lastItem() }}</span> of <span class="font-bold text-slate-800">{{ $po_list->total() }}</span> results
                    </div>
                    <div class="flex items-center gap-1">
                        {{-- Previous Page Link --}}
                        @if ($po_list->onFirstPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 cursor-not-allowed border border-slate-200 text-sm font-bold">
                                &lsaquo;
                            </span>
                        @else
                            <a href="{{ $po_list->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-black hover:bg-blue-50 hover:border-blue-900 transition border border-blue-900 shadow-2xs text-sm font-bold">
                                &lsaquo;
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($po_list->getUrlRange(1, $po_list->lastPage()) as $page => $url)
                            @if ($page == $po_list->currentPage())
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-950 text-white font-bold border border-blue-950 shadow-xs text-xs">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-black hover:bg-blue-50 hover:border-blue-900 transition border border-blue-900 font-semibold shadow-2xs text-xs">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($po_list->hasMorePages())
                            <a href="{{ $po_list->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-black hover:bg-blue-50 hover:border-blue-900 transition border border-blue-900 shadow-2xs text-sm font-bold">
                                &rsaquo;
                            </a>
                        @else
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 cursor-not-allowed border border-slate-200 text-sm font-bold">
                                &rsaquo;
                            </span>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</main>
@endsection