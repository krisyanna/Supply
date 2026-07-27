@extends('layouts.app')

@section('content')
<!-- overflow-y-scroll locks vertical scrollbar to eliminate page layout jump -->
<main class="flex-1 flex flex-col min-w-0 overflow-y-scroll bg-slate-100/60 p-4 lg:p-6 font-sans antialiased">
    
    <!-- Header (Identical to Supplier Management) -->
    <header class="w-full flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-5 bg-white border border-slate-200/80 rounded-2xl shadow-2xs mb-4 shrink-0">
        <div>
            <h2 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Warehouse Locations</h2>
            <p class="text-xs lg:text-sm text-slate-500 mt-0.5 font-normal">{{ $warehouses->total() }} warehouse locations found</p>
        </div>
        <div class="flex items-center shrink-0">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Active Sites
            </span>
        </div>
    </header>

    <!-- Stat Cards (Supplier Management Typography & Spacing) -->
    <div class="w-full grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-4 shrink-0">
        <div class="bg-white border border-slate-200/80 rounded-xl p-3.5 sm:p-4 shadow-2xs flex items-center justify-between gap-2 min-w-0">
            <div class="min-w-0 flex-1">
                <p class="text-[10px] sm:text-[11px] font-bold text-slate-400 tracking-wider uppercase truncate">Total Warehouses</p>
                <p class="text-xl sm:text-2xl font-black text-indigo-600 tracking-tight truncate mt-0.5">{{ $stats['total_warehouses'] }}</p>
            </div>
            <div class="shrink-0 p-2 sm:p-2.5 bg-indigo-50 rounded-lg border border-indigo-100 text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-xl p-3.5 sm:p-4 shadow-2xs flex items-center justify-between gap-2 min-w-0">
            <div class="min-w-0 flex-1">
                <p class="text-[10px] sm:text-[11px] font-bold text-slate-400 tracking-wider uppercase truncate">Active</p>
                <p class="text-xl sm:text-2xl font-black text-emerald-600 tracking-tight truncate mt-0.5">{{ $stats['active'] }}</p>
            </div>
            <div class="shrink-0 p-2 sm:p-2.5 bg-emerald-50 rounded-lg border border-emerald-100 text-emerald-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-xl p-3.5 sm:p-4 shadow-2xs flex items-center justify-between gap-2 min-w-0">
            <div class="min-w-0 flex-1">
                <p class="text-[10px] sm:text-[11px] font-bold text-slate-400 tracking-wider uppercase truncate">Inactive</p>
                <p class="text-xl sm:text-2xl font-black text-amber-600 tracking-tight truncate mt-0.5">{{ $stats['inactive'] }}</p>
            </div>
            <div class="shrink-0 p-2 sm:p-2.5 bg-amber-50 rounded-lg border border-amber-100 text-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-xl p-3.5 sm:p-4 shadow-2xs flex items-center justify-between gap-2 min-w-0">
            <div class="min-w-0 flex-1">
                <p class="text-[10px] sm:text-[11px] font-bold text-slate-400 tracking-wider uppercase truncate">Capacity</p>
                <p class="text-lg sm:text-xl font-black text-purple-600 tracking-tight truncate mt-0.5">{{ number_format($stats['total_capacity']) }}</p>
            </div>
            <div class="shrink-0 p-2 sm:p-2.5 bg-purple-50 rounded-lg border border-purple-100 text-purple-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8-4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
            </div>
        </div>
    </div>

    <!-- Data Table Container -->
    <div class="w-full min-w-0 bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden flex flex-col">
        
        <!-- Filter Bar with Locked Input Widths -->
        <form id="warehouse-filter-form" method="GET" action="{{ route('inventory.warehouse-locations') }}" class="px-5 py-4 border-b border-slate-200/60 bg-white flex flex-col md:flex-row md:items-center justify-between gap-3 shrink-0">
            <div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Warehouse Locations List</h3>
                <p class="text-xs text-slate-500 mt-0.5 font-normal">Showing registered storage facilities & contact details</p>
            </div>
            <div class="flex flex-wrap items-center gap-2 shrink-0">
                
                <!-- City Filter -->
                <select name="city" onchange="this.form.submit()" class="w-40 px-3 py-1.5 text-xs font-medium text-slate-700 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/25 shrink-0">
                    <option value="">All Cities</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                            {{ $city }}
                        </option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()" class="w-36 px-3 py-1.5 text-xs font-medium text-slate-700 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/25 shrink-0">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <!-- Search Input -->
                <div class="relative w-52 shrink-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" id="live-warehouse-search" value="{{ request('search') }}" placeholder="Search code, name..." class="w-full pl-8 pr-2.5 py-1.5 text-xs font-medium text-slate-700 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/25 placeholder:text-slate-400">
                </div>

                @if(request()->hasAny(['city', 'status', 'search']))
                    <a href="{{ route('inventory.warehouse-locations') }}" class="px-3 py-1.5 text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors shrink-0">
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
                        <th scope="col" class="px-4 py-3">Code</th>
                        <th scope="col" class="px-4 py-3">Name</th>
                        <th scope="col" class="px-4 py-3">Address</th>
                        <th scope="col" class="px-4 py-3">City</th>
                        <th scope="col" class="px-4 py-3">Capacity</th>
                        <th scope="col" class="px-4 py-3">Manager</th>
                        <th scope="col" class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($warehouses as $warehouse)
                    <tr class="hover:bg-slate-50/75 transition-colors">
                        <td class="px-4 py-3 font-bold text-indigo-950 whitespace-nowrap">{{ $warehouse->code }}</td>
                        <td class="px-4 py-3 font-semibold text-slate-900 max-w-[180px] truncate" title="{{ $warehouse->name }}">{{ $warehouse->name }}</td>
                        <td class="px-4 py-3 text-slate-600 font-normal max-w-[220px] truncate" title="{{ $warehouse->address }}">{{ $warehouse->address }}</td>
                        <td class="px-4 py-3 text-slate-800 font-medium whitespace-nowrap">{{ $warehouse->city }}</td>
                        <td class="px-4 py-3 font-bold text-slate-900 whitespace-nowrap">{{ number_format($warehouse->capacity) }}</td>
                        <td class="px-4 py-3 text-slate-700 whitespace-nowrap">{{ $warehouse->manager_name }}</td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold inline-block {{ strtolower($warehouse->status) === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/80' : 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($warehouse->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center text-slate-400 font-medium">No warehouse locations found matching your filters.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Block (Exact Match with Supplier Management) -->
        @if($warehouses->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-between px-5 py-3.5 border-t border-slate-200/80 bg-white gap-3 text-xs select-none shrink-0">
            <div class="text-slate-500 font-medium">
                Showing <span class="font-bold text-slate-800">{{ $warehouses->firstItem() }}</span> to <span class="font-bold text-slate-800">{{ $warehouses->lastItem() }}</span> of <span class="font-bold text-slate-800">{{ $warehouses->total() }}</span> results
            </div>
            
            <div class="flex items-center gap-1.5">
                @if ($warehouses->onFirstPage())
                    <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 bg-slate-50 cursor-not-allowed font-medium text-xs">Previous</span>
                @else
                    <a href="{{ $warehouses->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium text-xs">Previous</a>
                @endif

                @foreach ($warehouses->getUrlRange(1, $warehouses->lastPage()) as $page => $url)
                    @if ($page == $warehouses->currentPage())
                        <span class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white font-bold text-xs shadow-xs">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium text-xs">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($warehouses->hasMorePages())
                    <a href="{{ $warehouses->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium text-xs">Next</a>
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
        const searchInput = document.getElementById('live-warehouse-search');
        const form = document.getElementById('warehouse-filter-form');
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