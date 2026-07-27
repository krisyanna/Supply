@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col overflow-y-auto bg-slate-100/60 p-4 lg:p-6">
    
    <!-- Header (Full Fluid Width) -->
    <header class="w-full flex justify-between items-center px-6 lg:px-8 py-5 bg-white border border-slate-200/80 rounded-2xl shadow-2xs mb-4">
        <div>
            <h2 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Warehouse Locations</h2>
            <p class="text-xs lg:text-sm text-slate-500 mt-0.5">{{ $stats['total_warehouses'] }} warehouse locations registered</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs lg:text-sm font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                {{ $stats['total_warehouses'] }} Locations Active
            </span>
        </div>
    </header>

    <!-- KPI Cards Grid -->
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        
        <!-- Card 1: Total Warehouses -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Total Warehouses</p>
                <p class="text-3xl font-black text-blue-600 tracking-tight truncate">{{ $stats['total_warehouses'] }}</p>
            </div>
            <div class="shrink-0 p-3 bg-blue-50 rounded-xl border border-blue-100 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>
        
        <!-- Card 2: Active -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Active Warehouses</p>
                <p class="text-3xl font-black text-emerald-600 tracking-tight truncate">{{ $stats['active'] }}</p>
            </div>
            <div class="shrink-0 p-3 bg-emerald-50 rounded-xl border border-emerald-100 text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        
        <!-- Card 3: Inactive -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Inactive Warehouses</p>
                <p class="text-3xl font-black text-amber-600 tracking-tight truncate">{{ $stats['inactive'] }}</p>
            </div>
            <div class="shrink-0 p-3 bg-amber-50 rounded-xl border border-amber-100 text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
            </div>
        </div>

        <!-- Card 4: Total Capacity -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Total Capacity</p>
                <p class="text-3xl font-black text-purple-600 tracking-tight truncate">{{ number_format($stats['total_capacity']) }}</p>
            </div>
            <div class="shrink-0 p-3 bg-purple-50 rounded-xl border border-purple-100 text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
            </div>
        </div>
    </div>

    <!-- Data Table Container (Full Fluid Width) -->
    <div class="w-full flex-1 flex flex-col mb-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden flex-1 flex flex-col">
            
            <!-- Table Header Bar with Filters and Search Bar aligned to the Right -->
            <div class="px-6 lg:px-8 py-5 border-b border-slate-200/60 bg-white flex flex-col xl:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Warehouse Locations List</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Showing location details, capacity, and manager contacts</p>
                </div>
                <div class="flex flex-wrap items-center justify-end gap-2 w-full xl:w-auto">
                    
                    <!-- City Filter Dropdown -->
                    <div class="w-32 shrink-0">
                        <select id="cityFilter" class="w-full px-2.5 py-1.5 text-[11px] bg-slate-50/80 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/25 text-slate-700 font-medium appearance-none cursor-pointer">
                            <option value="">All Cities</option>
                            @foreach ($cities as $city)
                                <option value="{{ strtolower($city) }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter Dropdown -->
                    <div class="w-32 shrink-0">
                        <select id="statusFilter" class="w-full px-2.5 py-1.5 text-[11px] bg-slate-50/80 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/25 text-slate-700 font-medium appearance-none cursor-pointer">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="w-44 shrink-0 relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-slate-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" id="warehouseSearch" placeholder="Search warehouses..." 
                               class="w-full pl-7 pr-2 py-1.5 text-[11px] bg-slate-50/80 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/25">
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="w-full overflow-x-auto flex-1">
                <table class="w-full text-xs text-left border-collapse" id="warehouseTable">
                    <thead class="bg-slate-50/90 text-slate-500 font-semibold uppercase tracking-wider text-[10px] sticky top-0 border-b border-slate-200/60 z-10 backdrop-blur-xs">
                        <tr>
                            <th scope="col" class="px-4 py-3 w-[10%]">Code</th>
                            <th scope="col" class="px-4 py-3 w-[20%]">Name</th>
                            <th scope="col" class="px-4 py-3 w-[24%]">Address</th>
                            <th scope="col" class="px-4 py-3 w-[14%]">City</th>
                            <th scope="col" class="px-4 py-3 w-[10%]">Capacity</th>
                            <th scope="col" class="px-4 py-3 w-[14%]">Manager</th>
                            <th scope="col" class="px-4 py-3 w-[8%] text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700" id="warehouseTableBody">
                        @forelse($warehouses as $warehouse)
                        <tr class="hover:bg-slate-50/75 transition-colors duration-150 warehouse-row" data-code="{{ strtolower($warehouse->code) }}" data-name="{{ strtolower($warehouse->name) }}" data-city="{{ strtolower($warehouse->city ?? '') }}" data-status="{{ strtolower($warehouse->status ?? '') }}">
                            <td class="px-4 py-3 font-bold text-indigo-900 truncate"><span class="cursor-pointer hover:underline">{{ $warehouse->code }}</span></td>
                            <td class="px-4 py-3 text-slate-800 font-semibold truncate" title="{{ $warehouse->name }}">{{ $warehouse->name }}</td>
                            <td class="px-4 py-3 text-slate-600 font-medium truncate" title="{{ $warehouse->address }}">{{ $warehouse->address }}</td>
                            <td class="px-4 py-3 text-slate-800 font-semibold truncate" title="{{ $warehouse->city }}">{{ $warehouse->city }}</td>
                            <td class="px-4 py-3 text-slate-800 font-bold truncate">{{ number_format($warehouse->capacity) }}</td>
                            <td class="px-4 py-3 text-slate-600 font-medium truncate" title="{{ $warehouse->manager_name }}">{{ $warehouse->manager_name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-center truncate">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wide inline-block {{ strtolower($warehouse->status) === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/80' : 'bg-rose-50 text-rose-700 border border-rose-200/80' }}">
                                    {{ ucfirst($warehouse->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr id="empty-row">
                            <td colspan="7" class="px-4 py-8 text-center text-slate-400">
                                <p class="text-sm font-semibold">No warehouse locations yet</p>
                                <span class="text-xs text-slate-400">Add your first warehouse location to get started.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @if ($warehouses->hasPages())
            <div class="flex flex-col sm:flex-row items-center justify-between pt-4 border-t border-slate-200/60 gap-3 text-xs bg-white px-6 lg:px-8 py-3.5">
                <div class="text-slate-500 font-medium">
                    Showing <span class="font-bold text-slate-800">{{ $warehouses->firstItem() }}</span> to <span class="font-bold text-slate-800">{{ $warehouses->lastItem() }}</span> of <span class="font-bold text-slate-800">{{ $warehouses->total() }}</span> results
                </div>
                <div class="flex items-center gap-1">
                    {{-- Previous Page Link --}}
                    @if ($warehouses->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 cursor-not-allowed border border-slate-200 text-sm font-bold">
                            &lsaquo;
                        </span>
                    @else
                        <a href="{{ $warehouses->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-black hover:bg-blue-50 hover:border-blue-900 transition border border-blue-900 shadow-2xs text-sm font-bold">
                            &lsaquo;
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($warehouses->getUrlRange(1, $warehouses->lastPage()) as $page => $url)
                        @if ($page == $warehouses->currentPage())
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
                    @if ($warehouses->hasMorePages())
                        <a href="{{ $warehouses->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-black hover:bg-blue-50 hover:border-blue-900 transition border border-blue-900 shadow-2xs text-sm font-bold">
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

<script>
    function filterWarehouseTable() {
        const term = document.getElementById('warehouseSearch').value.toLowerCase().trim();
        const selectedCity = document.getElementById('cityFilter').value.toLowerCase();
        const selectedStatus = document.getElementById('statusFilter').value.toLowerCase();
        const tbody = document.getElementById('warehouseTableBody');
        const rows = Array.from(tbody.querySelectorAll('.warehouse-row'));
        
        rows.forEach(row => {
            const code = row.getAttribute('data-code') || '';
            const name = row.getAttribute('data-name') || '';
            const city = row.getAttribute('data-city') || '';
            const status = row.getAttribute('data-status') || '';
            
            const matchesSearch = !term || code.includes(term) || name.includes(term);
            const matchesCity = !selectedCity || city === selectedCity;
            const matchesStatus = !selectedStatus || status === selectedStatus;
            
            if (matchesSearch && matchesCity && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.getElementById('warehouseSearch').addEventListener('input', filterWarehouseTable);
    document.getElementById('cityFilter').addEventListener('change', filterWarehouseTable);
    document.getElementById('statusFilter').addEventListener('change', filterWarehouseTable);
</script>
@endsection