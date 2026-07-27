@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col overflow-y-auto bg-slate-100/60 p-4 lg:p-6">
    
    <!-- Header (Full Fluid Width) -->
    <header class="w-full flex justify-between items-center px-6 lg:px-8 py-5 bg-white border border-slate-200/80 rounded-2xl shadow-2xs mb-4">
        <div>
            <h2 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Inventory &amp; Warehouse Management</h2>
            <p class="text-xs lg:text-sm text-slate-500 mt-0.5">{{ $stats['total_skus'] }} stock items across all warehouse locations</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs lg:text-sm font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                {{ $stats['total_skus'] }} Records Synced
            </span>
        </div>
    </header>

    <!-- KPI Cards Grid -->
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
        
        <!-- Card 1: Total SKUs -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Total SKUs</p>
                <p class="text-3xl font-black text-blue-600 tracking-tight truncate">{{ $stats['total_skus'] }}</p>
            </div>
            <div class="shrink-0 p-3 bg-blue-50 rounded-xl border border-blue-100 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>
        
        <!-- Card 2: In Stock -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">In Stock</p>
                <p class="text-3xl font-black text-emerald-600 tracking-tight truncate">{{ $stats['in_stock'] }}</p>
            </div>
            <div class="shrink-0 p-3 bg-emerald-50 rounded-xl border border-emerald-100 text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        
        <!-- Card 3: Low / Out of Stock -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Low / Out of Stock</p>
                <p class="text-3xl font-black text-amber-600 tracking-tight truncate">{{ $stats['low_out_of_stock'] }}</p>
            </div>
            <div class="shrink-0 p-3 bg-amber-50 rounded-xl border border-amber-100 text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>

        <!-- Card 4: Reserved -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Reserved</p>
                <p class="text-3xl font-black text-indigo-600 tracking-tight truncate">{{ $stats['reserved'] }}</p>
            </div>
            <div class="shrink-0 p-3 bg-indigo-50 rounded-xl border border-indigo-100 text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
            </div>
        </div>

        <!-- Card 5: Inventory Value Total -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Inventory Value</p>
                <p class="text-2xl font-black text-purple-600 tracking-tight truncate">₱{{ number_format($stats['inventory_value'], 2) }}</p>
            </div>
            <div class="shrink-0 p-3 bg-purple-50 rounded-xl border border-purple-100 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Data Table Container -->
    <div class="w-full flex-1 flex flex-col mb-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden flex-1 flex flex-col">
            
            <!-- Table Header Bar with Form-based Filters & Search -->
            <form method="GET" action="{{ route('inventory.index') }}" id="filterForm" class="px-6 lg:px-8 py-5 border-b border-slate-200/60 bg-white flex flex-col xl:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Warehouse Stock Ledger</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Showing all synchronized items, quantities, locations, and unit costs</p>
                </div>
                <div class="flex flex-wrap items-center justify-end gap-2 w-full xl:w-auto">
                    
                    <!-- Category Filter Dropdown -->
                    <div class="w-36 shrink-0">
                        <select name="category" onchange="document.getElementById('filterForm').submit()" class="w-full px-2.5 py-1.5 text-[11px] bg-slate-50/80 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/25 text-slate-700 font-medium cursor-pointer">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter Dropdown -->
                    <div class="w-36 shrink-0">
                        <select name="status" onchange="document.getElementById('filterForm').submit()" class="w-full px-2.5 py-1.5 text-[11px] bg-slate-50/80 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/25 text-slate-700 font-medium cursor-pointer">
                            <option value="">All Statuses</option>
                            <option value="in-stock" {{ request('status') == 'in-stock' ? 'selected' : '' }}>In Stock</option>
                            <option value="low-stock" {{ request('status') == 'low-stock' ? 'selected' : '' }}>Low Stock</option>
                            <option value="out-stock" {{ request('status') == 'out-stock' ? 'selected' : '' }}>Out of Stock</option>
                            <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="w-48 shrink-0 relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-slate-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search items..." 
                               class="w-full pl-7 pr-2 py-1.5 text-[11px] bg-slate-50/80 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/25">
                    </div>
                </div>
            </form>

            <!-- Table Container -->
            <div class="w-full overflow-x-auto flex-1">
                <table class="w-full text-xs text-left border-collapse">
                    <thead class="bg-slate-50/90 text-slate-500 font-semibold uppercase tracking-wider text-[10px] sticky top-0 border-b border-slate-200/60 z-10 backdrop-blur-xs">
                        <tr>
                            <th scope="col" class="px-4 py-3 w-[12%]">Item Code</th>
                            <th scope="col" class="px-4 py-3 w-[22%]">Item Name</th>
                            <th scope="col" class="px-4 py-3 w-[18%]">Warehouse Location</th>
                            <th scope="col" class="px-4 py-3 w-[15%]">Category</th>
                            <th scope="col" class="px-4 py-3 w-[15%]">Quantity On Hand</th>
                            <th scope="col" class="px-4 py-3 w-[10%]">Unit Cost</th>
                            <th scope="col" class="px-4 py-3 w-[8%] text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($items as $item)
                        <tr class="hover:bg-slate-50/75 transition-colors duration-150">
                            <td class="px-4 py-3 font-bold text-indigo-900 truncate"><span class="cursor-pointer hover:underline">{{ $item->code }}</span></td>
                            <td class="px-4 py-3 text-slate-800 font-semibold truncate" title="{{ $item->name }}">{{ $item->name }}</td>
                            <td class="px-4 py-3 text-slate-600 font-medium truncate" title="{{ $item->location }}">{{ $item->location }}</td>
                            <td class="px-4 py-3 text-slate-800 font-semibold truncate" title="{{ $item->category }}">{{ $item->category }}</td>
                            <td class="px-4 py-3 text-slate-800 font-medium truncate">
                                <div class="font-bold text-slate-900 text-[11px]">{{ $item->quantity }} {{ $item->unit }}</div>
                                <div class="w-20 h-1.5 bg-slate-200 rounded-full mt-1 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-teal-400 to-indigo-600 rounded-full" style="width: {{ min(100, ($item->quantity / max($item->max_qty, 1)) * 100) }}%"></div>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-bold text-slate-900 truncate">₱{{ number_format($item->cost, 2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-center truncate">
                                @php
                                    $statusClass = match(strtolower($item->status)) {
                                        'in-stock' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/80',
                                        'low-stock' => 'bg-amber-50 text-amber-700 border border-amber-200/80',
                                        'out-stock' => 'bg-rose-50 text-rose-700 border border-rose-200/80',
                                        'reserved' => 'bg-indigo-50 text-indigo-700 border border-indigo-200/80',
                                        default => 'bg-slate-100 text-slate-700 border border-slate-200',
                                    };
                                @endphp
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wide inline-block {{ $statusClass }}">
                                    {{ ucwords(str_replace('-', ' ', $item->status)) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-400">
                                <p class="text-sm font-semibold">No inventory records found</p>
                                <span class="text-xs text-slate-400">Try adjusting your filters or search terms.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @if ($items->hasPages())
            <div class="flex flex-col sm:flex-row items-center justify-between pt-4 border-t border-slate-200/60 gap-3 text-xs bg-white px-6 lg:px-8 py-3.5">
                <div class="text-slate-500 font-medium">
                    Showing <span class="font-bold text-slate-800">{{ $items->firstItem() }}</span> to <span class="font-bold text-slate-800">{{ $items->lastItem() }}</span> of <span class="font-bold text-slate-800">{{ $items->total() }}</span> results
                </div>
                <div class="flex items-center gap-1">
                    {{-- Previous Page Link --}}
                    @if ($items->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 cursor-not-allowed border border-slate-200 text-sm font-bold">&lsaquo;</span>
                    @else
                        <a href="{{ $items->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-black hover:bg-blue-50 hover:border-blue-900 transition border border-blue-900 shadow-2xs text-sm font-bold">&lsaquo;</a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                        @if ($page == $items->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-950 text-white font-bold border border-blue-950 shadow-xs text-xs">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-black hover:bg-blue-50 hover:border-blue-900 transition border border-blue-900 font-semibold shadow-2xs text-xs">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($items->hasMorePages())
                        <a href="{{ $items->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-black hover:bg-blue-50 hover:border-blue-900 transition border border-blue-900 shadow-2xs text-sm font-bold">&rsaquo;</a>
                    @else
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 cursor-not-allowed border border-slate-200 text-sm font-bold">&rsaquo;</span>
                    @endif
                </div>
            </div>
        @endif

        </div>
    </div>
</main>
@endsection