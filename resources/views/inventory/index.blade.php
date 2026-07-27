@extends('layouts.app')

@section('content')
<!-- overflow-y-scroll locks vertical scrollbar to eliminate page layout jump -->
<main class="flex-1 flex flex-col min-w-0 overflow-y-scroll bg-slate-100/60 p-4 lg:p-6 font-sans antialiased">
    
    <!-- Header (Identical to Supplier Management) -->
    <header class="w-full flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-5 bg-white border border-slate-200/80 rounded-2xl shadow-2xs mb-4 shrink-0">
        <div>
            <h2 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Inventory & Warehouse Management</h2>
            <p class="text-xs lg:text-sm text-slate-500 mt-0.5 font-normal">{{ $items->total() }} stock items found</p>
        </div>
        <div class="flex items-center shrink-0">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Real-time Stock Synchronization
            </span>
        </div>
    </header>

    <!-- Stat Cards (Supplier Management Typography & Spacing) -->
    <div class="w-full grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-4 shrink-0">
        <div class="bg-white border border-slate-200/80 rounded-xl p-3.5 sm:p-4 shadow-2xs flex items-center justify-between gap-2 min-w-0">
            <div class="min-w-0 flex-1">
                <p class="text-[10px] sm:text-[11px] font-bold text-slate-400 tracking-wider uppercase truncate">Total SKUs</p>
                <p class="text-xl sm:text-2xl font-black text-indigo-600 tracking-tight truncate mt-0.5">{{ $stats['total_skus'] }}</p>
            </div>
            <div class="shrink-0 p-2 sm:p-2.5 bg-indigo-50 rounded-lg border border-indigo-100 text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-xl p-3.5 sm:p-4 shadow-2xs flex items-center justify-between gap-2 min-w-0">
            <div class="min-w-0 flex-1">
                <p class="text-[10px] sm:text-[11px] font-bold text-slate-400 tracking-wider uppercase truncate">In Stock</p>
                <p class="text-xl sm:text-2xl font-black text-blue-600 tracking-tight truncate mt-0.5">{{ $stats['in_stock'] }}</p>
            </div>
            <div class="shrink-0 p-2 sm:p-2.5 bg-blue-50 rounded-lg border border-blue-100 text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-xl p-3.5 sm:p-4 shadow-2xs flex items-center justify-between gap-2 min-w-0">
            <div class="min-w-0 flex-1">
                <p class="text-[10px] sm:text-[11px] font-bold text-slate-400 tracking-wider uppercase truncate">Low / Out</p>
                <p class="text-xl sm:text-2xl font-black text-amber-600 tracking-tight truncate mt-0.5">{{ $stats['low_out_of_stock'] }}</p>
            </div>
            <div class="shrink-0 p-2 sm:p-2.5 bg-amber-50 rounded-lg border border-amber-100 text-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-xl p-3.5 sm:p-4 shadow-2xs flex items-center justify-between gap-2 min-w-0">
            <div class="min-w-0 flex-1">
                <p class="text-[10px] sm:text-[11px] font-bold text-slate-400 tracking-wider uppercase truncate">Reserved</p>
                <p class="text-xl sm:text-2xl font-black text-teal-600 tracking-tight truncate mt-0.5">{{ $stats['reserved'] }}</p>
            </div>
            <div class="shrink-0 p-2 sm:p-2.5 bg-teal-50 rounded-lg border border-teal-100 text-teal-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-xl p-3.5 sm:p-4 shadow-2xs flex items-center justify-between gap-2 min-w-0 col-span-2 sm:col-span-1">
            <div class="min-w-0 flex-1">
                <p class="text-[10px] sm:text-[11px] font-bold text-slate-400 tracking-wider uppercase truncate">Total Value</p>
                <p class="text-lg sm:text-xl font-black text-purple-600 tracking-tight truncate mt-0.5">₱{{ number_format($stats['inventory_value'], 0) }}</p>
            </div>
            <div class="shrink-0 p-2 sm:p-2.5 bg-purple-50 rounded-lg border border-purple-100 text-purple-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Data Table Container -->
    <div class="w-full min-w-0 bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden flex flex-col">
        
        <!-- Filter Bar with Locked Input Widths -->
        <form id="ledger-filter-form" method="GET" action="{{ route('inventory.index') }}" class="px-5 py-4 border-b border-slate-200/60 bg-white flex flex-col md:flex-row md:items-center justify-between gap-3 shrink-0">
            <div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Warehouse Stock Ledger</h3>
                <p class="text-xs text-slate-500 mt-0.5 font-normal">Real-time stock balance across linked warehouses</p>
            </div>
            <div class="flex flex-wrap items-center gap-2 shrink-0">
                
                <!-- Category Filter -->
                <select name="category" onchange="this.form.submit()" class="w-40 px-3 py-1.5 text-xs font-medium text-slate-700 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/25 shrink-0">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()" class="w-36 px-3 py-1.5 text-xs font-medium text-slate-700 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/25 shrink-0">
                    <option value="">All Statuses</option>
                    <option value="in-stock" {{ request('status') == 'in-stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="low-stock" {{ request('status') == 'low-stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out-stock" {{ request('status') == 'out-stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                </select>

                <!-- Search Input -->
                <div class="relative w-52 shrink-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" id="live-search-input" value="{{ request('search') }}" placeholder="Search code, name..." class="w-full pl-8 pr-2.5 py-1.5 text-xs font-medium text-slate-700 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/25 placeholder:text-slate-400">
                </div>

                @if(request()->hasAny(['category', 'status', 'search']))
                    <a href="{{ route('inventory.index') }}" class="px-3 py-1.5 text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Fixed Table Viewport -->
        <div class="w-full overflow-x-auto min-w-0 min-h-[420px]">
            <table class="w-full text-xs text-left min-w-[700px]">
                <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200/60 select-none">
                    <tr>
                        <th scope="col" class="px-4 py-3">Item Code</th>
                        <th scope="col" class="px-4 py-3">Item Name</th>
                        <th scope="col" class="px-4 py-3">Warehouse Location</th>
                        <th scope="col" class="px-4 py-3">Category</th>
                        <th scope="col" class="px-4 py-3">Quantity On Hand</th>
                        <th scope="col" class="px-4 py-3">Unit Cost</th>
                        <th scope="col" class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($items as $item)
                    <tr class="hover:bg-slate-50/75 transition-colors">
                        <td class="px-4 py-3 font-bold text-indigo-950 whitespace-nowrap">{{ $item->code }}</td>
                        <td class="px-4 py-3 font-semibold text-slate-900 max-w-[180px] truncate" title="{{ $item->name }}">{{ $item->name }}</td>
                        <td class="px-4 py-3 text-slate-600 font-normal max-w-[180px] truncate" title="{{ $item->location }}">{{ $item->location }}</td>
                        <td class="px-4 py-3 text-slate-800 font-medium whitespace-nowrap">{{ $item->category }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-bold text-slate-900">{{ $item->quantity }} {{ $item->unit }}</div>
                            <div class="w-20 h-1 bg-slate-100 rounded-full mt-1 overflow-hidden">
                                <div class="h-full bg-indigo-500 rounded-full" style="width: {{ min(100, ($item->quantity / max($item->max_qty, 1)) * 100) }}%"></div>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-bold text-slate-900 whitespace-nowrap">₱{{ number_format($item->cost, 2) }}</td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @php
                                $badgeStyle = 'bg-slate-100 text-slate-700';
                                if ($item->status === 'in-stock') $badgeStyle = 'bg-emerald-50 text-emerald-700 border border-emerald-200/80';
                                elseif ($item->status === 'low-stock') $badgeStyle = 'bg-amber-50 text-amber-700 border border-amber-200/80';
                                elseif ($item->status === 'out-stock') $badgeStyle = 'bg-rose-50 text-rose-700 border border-rose-200/80';
                                elseif ($item->status === 'reserved') $badgeStyle = 'bg-blue-50 text-blue-700 border border-blue-200/80';
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block {{ $badgeStyle }}">
                                {{ ucwords(str_replace('-', ' ', $item->status)) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center text-slate-400 font-medium">No stock records found matching your filters.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Block (Exact Match with Supplier Management) -->
        @if($items->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-between px-5 py-3.5 border-t border-slate-200/80 bg-white gap-3 text-xs select-none shrink-0">
            <div class="text-slate-500 font-medium">
                Showing <span class="font-bold text-slate-800">{{ $items->firstItem() }}</span> to <span class="font-bold text-slate-800">{{ $items->lastItem() }}</span> of <span class="font-bold text-slate-800">{{ $items->total() }}</span> results
            </div>
            
            <div class="flex items-center gap-1.5">
                @if ($items->onFirstPage())
                    <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 bg-slate-50 cursor-not-allowed font-medium text-xs">Previous</span>
                @else
                    <a href="{{ $items->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium text-xs">Previous</a>
                @endif

                @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                    @if ($page == $items->currentPage())
                        <span class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white font-bold text-xs shadow-xs">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium text-xs">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($items->hasMorePages())
                    <a href="{{ $items->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium text-xs">Next</a>
                @else
                    <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 bg-slate-50 cursor-not-allowed font-medium text-xs">Next</span>
                @endif
            </div>
        </div>
        @endif

    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('live-search-input');
        const form = document.getElementById('ledger-filter-form');
        let timeout = null;

        if (searchInput && form) {
            const val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;

            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    form.submit();
                }, 350);
            });
        }
    });
</script>
@endsection