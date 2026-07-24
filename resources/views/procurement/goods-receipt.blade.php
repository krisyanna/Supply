<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goods Receipt & Invoice Matching | ERP Suite</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        sidebarBg: '#0f172a',
                        sidebarActive: '#1e293b',
                        brandIndigo: '#4f46e5',
                    }
                }
            }
        }
    </script>

    <!-- UNIFORM FONT: Plus Jakarta Sans -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }

        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .submenu-transition {
            transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease-in-out;
            overflow: hidden;
        }
        
        .brand-purple-text { color: #4f46e5; }
        .text-muted-blue { color: #64748b; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen overflow-x-hidden antialiased">

    <!-- MAIN LAYOUT WRAPPER -->
    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR NAVIGATION -->
        <aside class="w-72 bg-sidebarBg text-slate-300 flex flex-col flex-shrink-0 border-r border-slate-800 relative z-20">
            <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-extrabold shadow-md border border-indigo-400/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-white block leading-tight">Supply Chain</span>
                        <span class="text-[10px] text-indigo-400 font-extrabold uppercase tracking-wider">ERP Suite v2.5</span>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto">
                <div class="px-3 pb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-500">Core Modules</span>
                </div>

                <!-- HOME DASHBOARD -->
                <a href="{{ route('home') ?? '#' }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Home Dashboard</span>
                </a>

                <!-- FORECASTING DROPDOWN -->
                <div class="space-y-1">
                    <button type="button" onclick="toggleSubmenu('forecasting-submenu', 'forecasting-chevron')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-indigo-400 group-hover:text-indigo-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span>Demand Forecasting</span>
                        </div>
                        <svg id="forecasting-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="forecasting-submenu" class="submenu-transition max-h-0 opacity-0 pl-9 pr-2 space-y-1">
                        <a href="#" class="block px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-300 hover:text-white hover:bg-indigo-600/30 transition">Demand Planning</a>
                        <a href="#" class="block px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-300 hover:text-white hover:bg-indigo-600/30 transition">Historical Sales Analytics</a>
                    </div>
                </div>

                <!-- PROCUREMENT & SUPPLIERS DROPDOWN (ACTIVE & OPEN) -->
                <div class="space-y-1">
                    <button type="button" onclick="toggleSubmenu('procurement-submenu', 'procurement-chevron')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-800 text-white font-semibold text-xs border border-slate-700/60 shadow-sm group">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-indigo-400 group-hover:text-indigo-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Procurement &amp; Suppliers</span>
                        </div>
                        <svg id="procurement-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-300 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div id="procurement-submenu" class="submenu-transition max-h-40 opacity-100 pl-7 pr-2 space-y-1">
                        <a href="/procurement" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            <span>Reorder Recommendations</span>
                        </a>
                        <a href="/procurement/suppliers" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span>Supplier Management</span>
                        </a>
                        <a href="/procurement/po-management" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>Purchase Order Management</span>
                        </a>
                        <a href="/procurement/goods-receipt" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-white bg-indigo-600/30 border border-indigo-500/30 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M15 11l-3 3-3-3"></path></svg>
                            <span>Goods Receipt & Invoices</span>
                        </a>
                    </div>
                </div>

                <!-- LOGISTICS SUB-MODULE DROPDOWN -->
                <div class="space-y-1">
                    <button type="button" onclick="toggleSubmenu('logistics-submenu', 'logistics-chevron')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-emerald-400 group-hover:text-emerald-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Logistics Sub-Module</span>
                        </div>
                        <svg id="logistics-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="logistics-submenu" class="submenu-transition max-h-0 opacity-0 pl-7 pr-2 space-y-1">
                        <a href="#" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Shipment Schedules</span>
                        </a>
                        <a href="#" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span>Delivery Tracking</span>
                        </a>
                        <a href="#" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            <span>Shipping Routes</span>
                        </a>
                    </div>
                </div>

                <!-- INVENTORY & WAREHOUSE -->
                <a href="#" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0l3-4m0 0l3 4"></path>
                    </svg>
                    <span>Inventory &amp; Warehouse</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                <a href="#" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-rose-300 hover:text-white hover:bg-rose-600/20 font-bold text-xs bg-rose-950/20 border border-rose-500/20 transition">
                    <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Leave System</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 flex flex-col overflow-y-auto">
            
            <!-- Header -->
            <header class="flex justify-between items-center px-10 py-8 bg-white border-b border-slate-100">
                <div>
                    <h2 class="text-[22px] font-extrabold text-slate-900 tracking-tight">Goods Receipt &amp; Invoice Matching</h2>
                    <p class="text-sm text-slate-500 mt-1">Standalone UI Mode (No Database Dependency Required)</p>
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
    </div>

    <!-- Dropdown / Submenu Toggle Script -->
    <script>
        function toggleSubmenu(submenuId, chevronId) {
            const submenu = document.getElementById(submenuId);
            const chevron = document.getElementById(chevronId);
            
            if (submenu.style.maxHeight && submenu.style.maxHeight !== '0px') {
                submenu.style.maxHeight = '0px';
                submenu.style.opacity = '0';
                chevron.classList.remove('rotate-180');
            } else {
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
                submenu.style.opacity = '1';
                chevron.classList.add('rotate-180');
            }
        }
    </script>
</body>
</html>