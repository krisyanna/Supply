<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goods Receipt & Invoice Matching | Supply Chain</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .sidebar-bg { background-color: #1c1d2e; }
        .sidebar-active-module { background-color: #25263a; }
        .brand-purple-bg { background-color: #5f5cf1; }
        .brand-purple-text { color: #5f5cf1; }
        .text-muted-blue { color: #8a90a5; }
    </style>
</head>
<body class="bg-[#f8f9fa] flex h-screen overflow-hidden">

    <!-- Sidebar Area -->
    <aside class="sidebar-bg w-[260px] text-gray-400 flex flex-col h-full shrink-0 border-r border-gray-800/50">
        <!-- Logo -->
        <div class="flex items-center gap-3 p-6 pb-4">
            <div class="brand-purple-bg p-2.5 rounded-xl text-white shadow-lg shadow-indigo-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <h1 class="text-white font-bold text-[17px] tracking-wide leading-tight">Supply Chain</h1>
                <p class="text-[10px] brand-purple-text font-bold tracking-widest mt-0.5">ERP SYSTEM</p>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 py-4 overflow-y-auto px-3 space-y-1.5">
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:text-white hover:bg-white/5 transition-colors">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="text-sm font-medium">Home</span>
            </a>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:text-white hover:bg-white/5 transition-colors">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                <span class="text-sm font-medium">Forecasting</span>
            </a>
            
            <!-- Active Procurement Module -->
            <div class="sidebar-active-module border border-gray-700/50 rounded-xl overflow-hidden mt-2">
                
                <div onclick="toggleProcurementMenu()" class="flex items-center justify-between px-4 py-3 text-white cursor-pointer hover:bg-white/5 transition-colors">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#5f5cf1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="text-sm font-semibold">Procurement</span>
                    </div>
                    <svg id="proc-arrow" class="w-4 h-4 transform rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                
                <!-- Sub-menu -->
                <ul id="proc-submenu" class="pb-3 space-y-0.5 block mt-1">
                    <li>
                        <a href="/procurement" class="flex items-center gap-2.5 px-4 pl-10 py-2.5 text-xs font-medium text-gray-400 hover:text-gray-200 transition-colors rounded-r-lg mr-4 hover:bg-white/5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                             Reorder Recommendations
                        </a>
                    </li>
                    <li>
                        <a href="/procurement/suppliers" class="flex items-center gap-2.5 px-4 pl-10 py-2.5 text-xs font-medium text-gray-400 hover:text-gray-200 transition-colors rounded-r-lg mr-4 hover:bg-white/5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                             Supplier Management
                        </a>
                    </li>
                    <li>
                        <a href="/procurement/po-management" class="flex items-center gap-2.5 px-4 pl-10 py-2.5 text-xs font-medium text-gray-400 hover:text-gray-200 transition-colors rounded-r-lg mr-4 hover:bg-white/5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                             Purchase Order Management
                        </a>
                    </li>
                    <li>
                        <!-- ACTIVE: Goods Receipt -->
                        <a href="/procurement/goods-receipt" class="flex items-center gap-2.5 px-4 pl-10 py-2.5 text-xs font-medium bg-[#5f5cf1]/15 text-[#8b89f5] rounded-r-lg mr-4 transition-colors hover:bg-[#5f5cf1]/25 hover:text-[#a3a2f7]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M15 11l-3 3-3-3"></path></svg>
                             Goods Receipt & Invoices
                        </a>
                    </li>
                </ul>
            </div>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:text-white hover:bg-white/5 transition-colors">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                <span class="text-sm font-medium">Logistics</span>
            </a>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:text-white hover:bg-white/5 transition-colors">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span class="text-sm font-medium">Inventory & Warehouse</span>
            </a>
        </nav>

        <!-- Leave Button -->
        <div class="p-4 border-t border-gray-800/50">
            <button class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg text-sm font-medium text-red-400 hover:text-white hover:bg-red-500/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Leave
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        
        <!-- Header -->
        <header class="flex justify-between items-center px-10 py-8">
            <div>
                <h2 class="text-[22px] font-extrabold text-gray-900 tracking-tight">Goods Receipt & Invoice Matching</h2>
                <p class="text-sm text-gray-500 mt-1">Standalone UI Mode (No Database Dependency Required)</p>
            </div>
        </header>

        <!-- KPI Cards -->
        <div class="grid grid-cols-4 gap-6 px-10 pb-8">
            <div class="border border-gray-200/80 rounded-2xl p-6 shadow-sm bg-white flex justify-between items-center gap-3 overflow-hidden">
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-bold text-muted-blue tracking-widest uppercase mb-1 truncate">Total Receipts</p>
                    <p class="text-[32px] font-black text-gray-900 tracking-tight truncate">{{ $kpi_summary['total_receipts'] }}</p>
                </div>
                <div class="shrink-0">
                    <svg class="w-12 h-12 text-gray-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>
            <div class="border border-gray-200/80 rounded-2xl p-6 shadow-sm bg-white flex justify-between items-center gap-3 overflow-hidden">
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-bold text-muted-blue tracking-widest uppercase mb-1 truncate">Matched Invoices</p>
                    <p class="text-[32px] font-black text-green-500 tracking-tight truncate">{{ $kpi_summary['matched_invoices'] }}</p>
                </div>
                <div class="shrink-0">
                    <svg class="w-12 h-12 text-green-500/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="border border-gray-200/80 rounded-2xl p-6 shadow-sm bg-white flex justify-between items-center gap-3 overflow-hidden">
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-bold text-muted-blue tracking-widest uppercase mb-1 truncate">Discrepancies</p>
                    <p class="text-[32px] font-black text-red-500 tracking-tight truncate">{{ $kpi_summary['discrepancies'] }}</p>
                </div>
                <div class="shrink-0">
                    <svg class="w-12 h-12 text-red-500/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <div class="border border-gray-200/80 rounded-2xl p-6 shadow-sm bg-white flex justify-between items-center gap-3 overflow-hidden">
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-bold text-muted-blue tracking-widest uppercase mb-1 truncate">Pending Matching</p>
                    <p class="text-[32px] font-black text-orange-500 tracking-tight truncate">{{ $kpi_summary['pending_matching'] }}</p>
                </div>
                <div class="shrink-0">
                    <svg class="w-12 h-12 text-orange-500/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Ledger Table -->
        <div class="px-10 pb-10">
            <div class="border border-gray-200/80 rounded-2xl shadow-sm bg-white overflow-hidden">
                <div class="px-7 py-5 border-b border-gray-100 bg-white">
                    <h3 class="text-[15px] font-extrabold text-gray-900">Goods Receipt & Matching Ledger</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[11px] text-muted-blue bg-white border-b border-gray-100">
                            <tr>
                                <th class="px-7 py-4 font-bold uppercase tracking-wider">GR Code</th>
                                <th class="px-7 py-4 font-bold uppercase tracking-wider">PO Code</th>
                                <th class="px-7 py-4 font-bold uppercase tracking-wider">Supplier Name</th>
                                <th class="px-7 py-4 font-bold uppercase tracking-wider">Received Date</th>
                                <th class="px-7 py-4 font-bold uppercase tracking-wider">Invoice Match Status</th>
                                <th class="px-7 py-4 font-bold uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($receipt_list as $item)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-7 py-4 font-bold brand-purple-text">{{ $item['gr_code'] }}</td>
                                <td class="px-7 py-4 text-gray-800 font-semibold">{{ $item['po_code'] }}</td>
                                <td class="px-7 py-4 text-gray-600 font-medium">{{ $item['supplier'] }}</td>
                                <td class="px-7 py-4 text-gray-600 font-medium">{{ $item['received_date'] }}</td>
                                <td class="px-7 py-4 text-gray-800 font-semibold">{{ $item['invoice_match'] }}</td>
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

    <script>
        function toggleProcurementMenu() {
            const submenu = document.getElementById('proc-submenu');
            const arrow = document.getElementById('proc-arrow');
            
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                submenu.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }
    </script>
</body>
</html>