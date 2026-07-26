@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col overflow-y-auto bg-slate-100/60 p-4 lg:p-6">
    
    <!-- Header (Full Fluid Width) -->
    <header class="w-full flex justify-between items-center px-6 lg:px-8 py-5 bg-white border border-slate-200/80 rounded-2xl shadow-2xs mb-4">
        <div>
            <h2 class="text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight">Procurement &amp; Supplier Coordination</h2>
            <p class="text-xs lg:text-sm text-slate-500 mt-0.5">Complete Enterprise Supplier Ledger &mdash; Real-time Database Synchronization</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs lg:text-sm font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                {{ $kpi_summary['total_suppliers'] ?? $supplier_list->total() }} Records Synced
            </span>
        </div>
    </header>

    <!-- KPI Cards Grid (Full Fluid Width) -->
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Total Suppliers</p>
                <p class="text-3xl font-black text-slate-900 tracking-tight truncate">{{ $kpi_summary['total_suppliers'] ?? $supplier_list->total() }}</p>
            </div>
            <div class="shrink-0 p-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
        
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Active Contracts</p>
                <p class="text-3xl font-black text-indigo-600 tracking-tight truncate">{{ $kpi_summary['active_contracts'] ?? 0 }}</p>
            </div>
            <div class="shrink-0 p-3 bg-indigo-50/70 rounded-xl border border-indigo-100 text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
        
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Pending Reviews</p>
                <p class="text-3xl font-black text-amber-600 tracking-tight truncate">{{ $kpi_summary['pending_reviews'] ?? 0 }}</p>
            </div>
            <div class="shrink-0 p-3 bg-amber-50/70 rounded-xl border border-amber-100 text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all duration-200 flex justify-between items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1 truncate">Avg. Performance</p>
                <p class="text-3xl font-black text-slate-900 tracking-tight truncate">{{ $kpi_summary['avg_performance'] ?? '0.0' }}</p>
            </div>
            <div class="shrink-0 p-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
    </div>

    <!-- Data Table Container (Full Fluid Width) -->
    <div class="w-full flex-1 flex flex-col mb-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden flex-1 flex flex-col">
            
            <!-- Table Header Bar with Search, Category Filter & Sorting Filter -->
            <div class="px-6 lg:px-8 py-5 border-b border-slate-200/60 bg-white flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Complete Supplier Management Ledger</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Showing all synchronized fields and contact details</p>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    
                    <!-- Sorting Dropdown -->
                    <div class="w-full sm:w-44">
                        <select id="sortFilter" class="w-full px-3 py-2.5 text-xs bg-slate-50/80 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-2xs text-slate-700 font-medium">
                            <option value="">Sort By: Default</option>
                            <option value="az">Name: A to Z</option>
                            <option value="za">Name: Z to A</option>
                        </select>
                    </div>

                    <!-- Category Filter Dropdown -->
                    <div class="w-full sm:w-44">
                        <select id="categoryFilter" class="w-full px-3 py-2.5 text-xs bg-slate-50/80 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-2xs text-slate-700 font-medium">
                            <option value="">All Categories</option>
                            <option value="graphics">Graphics</option>
                            <option value="storage">Storage</option>
                            <option value="power supply">Power Supply</option>
                            <option value="cooling">Cooling</option>
                            <option value="components">Components</option>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="w-full sm:w-64 relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" id="supplierSearch" placeholder="Search suppliers on this page..." 
                               class="w-full pl-10 pr-4 py-2.5 text-xs bg-slate-50/80 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-2xs">
                    </div>
                </div>
            </div>

            <!-- Table Container (No Inner Scroll) -->
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-xs text-left border-collapse" id="supplierTable">
                    <thead class="bg-slate-50/90 text-slate-500 font-semibold uppercase tracking-wider text-[11px] sticky top-0 border-b border-slate-200/60 z-10 backdrop-blur-xs">
                        <tr>
                            <th scope="col" class="px-6 lg:px-8 py-4">Supplier Name</th>
                            <th scope="col" class="px-6 lg:px-8 py-4">Contact Details</th>
                            <th scope="col" class="px-6 lg:px-8 py-4">Category</th>
                            <th scope="col" class="px-6 lg:px-8 py-4">Sub-Categories</th>
                            <th scope="col" class="px-6 lg:px-8 py-4">Payment Terms</th>
                            <th scope="col" class="px-6 lg:px-8 py-4">Rating</th>
                            <th scope="col" class="px-6 lg:px-8 py-4">Delivery Schedule</th>
                            <th scope="col" class="px-6 lg:px-8 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700" id="supplierTableBody">
                        @foreach($supplier_list as $supplier)
                        <tr class="hover:bg-slate-50/75 transition-colors duration-150 supplier-row" data-category="{{ strtolower($supplier->category ?? '') }}">
                            <td class="px-6 lg:px-8 py-4 font-bold text-indigo-900 supplier-name text-xs sm:text-sm">{{ $supplier->name }}</td>
                            <td class="px-6 lg:px-8 py-4 text-slate-600 font-medium">{{ $supplier->contact ?? $supplier->contact_representative ?? '-' }}</td>
                            <td class="px-6 lg:px-8 py-4 text-slate-800 font-semibold supplier-category">{{ $supplier->category }}</td>
                            <td class="px-6 lg:px-8 py-4 text-slate-500">{{ $supplier->sub_categories }}</td>
                            <td class="px-6 lg:px-8 py-4 text-slate-800 font-medium">{{ $supplier->payment_terms }}</td>
                            <td class="px-6 lg:px-8 py-4 font-bold text-slate-900">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-4 h-4 text-amber-500 fill-amber-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.690h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.690l1.07-3.292z"/></svg>
                                    {{ $supplier->rating ?? $supplier->performance ?? '0.0' }}
                                </span>
                            </td>
                            <td class="px-6 lg:px-8 py-4 text-slate-600">{{ $supplier->delivery_schedule }}</td>
                            <td class="px-6 lg:px-8 py-4">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold tracking-wide {{ strtolower($supplier->status) === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/80' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $supplier->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @if ($supplier_list->hasPages())
            <div class="flex flex-col sm:flex-row items-center justify-between pt-4 border-t border-slate-200/60 gap-3 text-xs bg-white px-6 lg:px-8 py-3.5">
                <div class="text-slate-500 font-medium">
                    Showing <span class="font-bold text-slate-800">{{ $supplier_list->firstItem() }}</span> to <span class="font-bold text-slate-800">{{ $supplier_list->lastItem() }}</span> of <span class="font-bold text-slate-800">{{ $supplier_list->total() }}</span> results
                </div>
                <div class="flex items-center gap-1">
                    {{-- Previous Page Link --}}
                    @if ($supplier_list->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 cursor-not-allowed border border-slate-200 text-sm font-bold">
                            &lsaquo;
                        </span>
                    @else
                        <a href="{{ $supplier_list->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-black hover:bg-blue-50 hover:border-blue-900 transition border border-blue-900 shadow-2xs text-sm font-bold">
                            &lsaquo;
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($supplier_list->getUrlRange(1, $supplier_list->lastPage()) as $page => $url)
                        @if ($page == $supplier_list->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-950 text-white font-bold border border-blue-950 shadow-xs text-xs">
                                {{ $page }}
                            </span>
                        @elsegit add .
                            <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-black hover:bg-blue-50 hover:border-blue-900 transition border border-blue-900 font-semibold shadow-2xs text-xs">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($supplier_list->hasMorePages())
                        <a href="{{ $supplier_list->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-black hover:bg-blue-50 hover:border-blue-900 transition border border-blue-900 shadow-2xs text-sm font-bold">
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
    function filterAndSortTable() {
        const term = document.getElementById('supplierSearch').value.toLowerCase();
        const selectedCategory = document.getElementById('categoryFilter').value.toLowerCase();
        const sortOrder = document.getElementById('sortFilter').value;
        const tbody = document.getElementById('supplierTableBody');
        const rows = Array.from(tbody.querySelectorAll('.supplier-row'));
        
        // 1. Filter rows based on search term & category selection
        rows.forEach(row => {
            const name = row.querySelector('.supplier-name').textContent.toLowerCase();
            const category = row.getAttribute('data-category');
            
            const matchesSearch = name.includes(term);
            const matchesCategory = selectedCategory === "" || category.includes(selectedCategory);
            
            if (matchesSearch && matchesCategory) {
                row.style.display = '';
                row.setAttribute('data-visible', 'true');
            } else {
                row.style.display = 'none';
                row.setAttribute('data-visible', 'false');
            }
        });

        // 2. Sort rows if a sort option is selected
        if (sortOrder !== "") {
            rows.sort((a, b) => {
                const nameA = a.querySelector('.supplier-name').textContent.trim().toLowerCase();
                const nameB = b.querySelector('.supplier-name').textContent.trim().toLowerCase();
                
                if (sortOrder === 'az') {
                    return nameA.localeCompare(nameB);
                } else if (sortOrder === 'za') {
                    return nameB.localeCompare(nameA);
                }
                return 0;
            });

            // Re-append rows in sorted order inside the table body
            rows.forEach(row => tbody.appendChild(row));
        }
    }

    document.getElementById('supplierSearch').addEventListener('input', filterAndSortTable);
    document.getElementById('categoryFilter').addEventListener('change', filterAndSortTable);
    document.getElementById('sortFilter').addEventListener('change', filterAndSortTable);
</script>
@endsection