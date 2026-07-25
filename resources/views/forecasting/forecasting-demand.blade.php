<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demand Forecasting | Full ERP Suite</title>

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

                <!-- HOME DASHBOARD — not active on this page -->
                <a href="{{ route('home') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Home Dashboard</span>
                </a>

                <!-- FORECASTING SIDE BAR — ACTIVE (this is the current page), expanded -->
                <div class="space-y-1">
                    <button type="button" onclick="toggleSubmenu('forecasting-submenu', 'forecasting-chevron')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-800 text-white font-semibold text-xs border border-slate-700/60 shadow-sm">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span>Demand Forecasting</span>
                        </div>
                        <svg id="forecasting-chevron" class="w-3.5 h-3.5 text-white transition-transform duration-300 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="forecasting-submenu" class="submenu-transition max-h-96 opacity-100 pl-9 pr-2 space-y-1">
                        <a href="{{ route('forecasting.demand') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-white bg-indigo-600/30 border border-indigo-500/30 transition">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 20h16M7 16v-4M12 20V8M17 20v-7"/>
                            </svg>
                            <span>Forecasting</span>
                        </a>
                    </div>
                </div>

                <!-- PROCUREMENT & SUPPLIERS DROPDOWN — collapsed (not on this page) -->
                <div class="space-y-1">
                    <button type="button" onclick="toggleSubmenu('procurement-submenu', 'procurement-chevron')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Procurement</span>
                        </div>
                        <svg id="procurement-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div id="procurement-submenu" class="submenu-transition max-h-0 opacity-0 pl-7 pr-2 space-y-1">
                        <!-- NOTE: /procurement currently has two competing route definitions in
                             web.php — a stub named 'suppliers.index' that redirects to Logistics,
                             and an unnamed ProcurementController::index route defined after it
                             (dead code, since Laravel matches the first route for a URI). Using
                             a plain path here until that's resolved and the routes are named. -->
                        <a href="/procurement" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2 2 4-4"></path>
                            </svg>
                            <span>Reorder Recommendations</span>
                        </a>
                        <a href="/procurement/suppliers" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 010 7.75"></path>
                            </svg>
                            <span>Supplier Management</span>
                        </a>
                        <a href="/procurement/po-management" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Purchase Order Management</span>
                        </a>
                        <a href="/procurement/goods-receipt" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"></path>
                            </svg>
                            <span>Goods Receipt &amp; Invoices</span>
                        </a>
                    </div>
                </div>

                <!-- LOGISTICS SUB-MODULE DROPDOWN — collapsed (not on this page) -->
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
                        <a href="{{ route('logistics.dashboard') }}" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Shipment Schedules</span>
                        </a>
                        <a href="{{ route('logistics.dashboard') }}" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            <span>Delivery Tracking</span>
                        </a>
                        <a href="{{ route('logistics.dashboard') }}" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            <span>Shipping Routes</span>
                        </a>
                        <a href="{{ route('logistics.dashboard') }}" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span>Transportation Status</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('inventory') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0l3-4m0 0l3 4"></path>
                    </svg>
                    <span>Inventory &amp; Warehouse</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                <a href="{{ route('home') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-rose-300 hover:text-white hover:bg-rose-600/20 font-bold text-xs bg-rose-950/20 border border-rose-500/20 transition">
                    <!-- TODO: point this at a real logout route once you add one
                         (e.g. Route::post('/logout', ...)->name('logout')) -->
                    <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Leave System</span>
                </a>
            </div>
        </aside>

        <!-- MAIN DISPLAY PANEL -->
        <main class="flex-1 flex flex-col overflow-y-auto bg-slate-50">

            <!-- HEADER TOOLBAR -->
            <header class="bg-white px-8 py-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-slate-200/80 sticky top-0 z-30 shadow-xs">
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Demand Forecasting</h1>

                <div class="flex flex-wrap items-center gap-2.5">
                    <div class="relative">
                        <select id="dateRangeSelect" class="appearance-none pl-3.5 pr-8 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                            <option value="30d">Last 30 Days</option>
                            <option value="90d">Last 90 Days</option>
                            <option value="6m">Last 6 Months</option>
                            <option value="12m">Last 12 Months</option>
                        </select>
                        <svg class="w-3.5 h-3.5 text-slate-400 absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>

                    <div class="relative">
                        <select id="categorySelect" class="appearance-none pl-3.5 pr-8 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer min-w-[140px]">
                            <option value="">All Categories</option>
                        </select>
                        <svg class="w-3.5 h-3.5 text-slate-400 absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>

                    <button type="button" onclick="loadForecastData()" class="px-4 py-2 bg-white border border-indigo-200 hover:bg-indigo-50 text-indigo-600 text-xs font-extrabold rounded-full transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Search</span>
                    </button>
                </div>
            </header>

            <div class="p-8 max-w-7xl w-full mx-auto flex-1 space-y-6">

                <!-- KPI STAT CARDS — rendered entirely from JS via renderStatCards() -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="statsRow"></div>

                <!-- HISTORICAL SALES VS FORECAST CHART -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-slate-900 text-sm">Historical Sales vs Forecast</h3>
                        <div class="flex items-center gap-4 text-[11px] font-bold text-slate-500">
                            <span class="flex items-center gap-1.5"><span class="w-3 h-[3px] rounded-full bg-emerald-500 inline-block"></span> Actual Sales</span>
                            <span class="flex items-center gap-1.5"><span class="w-3 h-[3px] rounded-full bg-rose-400 inline-block"></span> Forecast</span>
                        </div>
                    </div>
                    <div id="chartLoadingMsg" class="text-xs font-semibold text-slate-400 italic py-16 text-center">Loading chart…</div>
                    <canvas id="salesForecastChart" height="90" class="hidden"></canvas>
                </div>

                <!-- PRODUCT DEMAND FORECAST TABLE -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden p-5 space-y-4">
                    <h3 class="font-bold text-slate-900 text-sm">Product Demand Forecast</h3>
                    <div class="overflow-x-auto text-xs">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-100/80 text-slate-500 font-bold">
                                <tr>
                                    <th class="py-2.5 px-3 rounded-l-lg">Product</th>
                                    <th class="py-2.5 px-3">Current Stock</th>
                                    <th class="py-2.5 px-3">Last Month Sale</th>
                                    <th class="py-2.5 px-3">Forecast</th>
                                    <th class="py-2.5 px-3 rounded-r-lg">Status</th>
                                </tr>
                            </thead>
                            <tbody id="productForecastBody" class="divide-y divide-slate-50 font-semibold text-slate-700">
                                <tr><td colspan="5" class="py-6 text-center text-slate-400 italic font-normal">Loading…</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PLANNING RECOMMENDATIONS TABLE -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden p-5 space-y-4">
                    <h3 class="font-bold text-slate-900 text-sm">Planning Recommendations</h3>
                    <div class="overflow-x-auto text-xs">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-100/80 text-slate-500 font-bold">
                                <tr>
                                    <th class="py-2.5 px-3 rounded-l-lg">Product</th>
                                    <th class="py-2.5 px-3 rounded-r-lg">Recommendation</th>
                                </tr>
                            </thead>
                            <tbody id="recommendationsBody" class="divide-y divide-slate-50 font-semibold text-slate-700">
                                <tr><td colspan="2" class="py-6 text-center text-slate-400 italic font-normal">Loading…</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        function toggleSubmenu(menuId, chevronId) {
            const menu = document.getElementById(menuId);
            const chevron = document.getElementById(chevronId);
            if (menu.classList.contains('max-h-0')) {
                menu.classList.remove('max-h-0', 'opacity-0');
                menu.classList.add('max-h-96', 'opacity-100');
                if (chevron) chevron.classList.add('rotate-180');
            } else {
                menu.classList.remove('max-h-96', 'opacity-100');
                menu.classList.add('max-h-0', 'opacity-0');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        }
    </script>

    <!-- ============================================================
         DATA LAYER — nothing above is hardcoded business data;
         everything below fetches from the Sales module API/DB and
         paints the DOM. Adjust ENDPOINTS + expected shapes to match
         your actual backend.
         ============================================================ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
    <script>
    const API_BASE_URL = ''; // e.g. 'https://api.yourapp.com' — leave '' for same-origin

    const ENDPOINTS = {
        categories:          `${API_BASE_URL}/api/sales/categories`,
        forecastSummary:     `${API_BASE_URL}/api/forecasting/summary`,
        historicalVsForecast:`${API_BASE_URL}/api/forecasting/historical-vs-forecast`,
        productForecast:     `${API_BASE_URL}/api/forecasting/product-demand`,
        recommendations:     `${API_BASE_URL}/api/forecasting/recommendations`
    };

    /* Icon set for the 4 KPI cards, keyed by an id the API returns in
       summary.stats[i].icon — backend controls which icon each card gets. */
    const ICONS = {
        cube: '<svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
        calendar: '<svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
        growth: '<svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
        none: ''
    };

    /* Maps a demand-status string from the API to a colored dot + label.
       Adjust keys to match whatever your backend sends. */
    const DEMAND_STATUS_MAP = {
        high_demand:     { label: 'High Demand',     dot: 'bg-emerald-500' },
        moderate_demand: { label: 'Moderate Demand', dot: 'bg-amber-400' },
        low_demand:      { label: 'Low Demand',      dot: 'bg-rose-500' }
    };

    let forecastChart = null;

    async function fetchJSON(url, options = {}) {
        const res = await fetch(url, {
            headers: { 'Content-Type': 'application/json' },
            // credentials: 'include', // uncomment if your API relies on cookies/session auth
            ...options
        });
        if (!res.ok) throw new Error(`Request to ${url} failed with status ${res.status}`);
        return res.json();
    }

    function currentFilters() {
        return {
            range: document.getElementById('dateRangeSelect').value,
            category: document.getElementById('categorySelect').value
        };
    }

    function buildQuery(params) {
        const query = new URLSearchParams();
        Object.entries(params).forEach(([k, v]) => { if (v) query.set(k, v); });
        const qs = query.toString();
        return qs ? `?${qs}` : '';
    }

    // Expected shape: { categories: [{ value, label }] }
    async function loadCategories() {
        try {
            const data = await fetchJSON(ENDPOINTS.categories);
            const select = document.getElementById('categorySelect');
            (data.categories || []).forEach(cat => {
                const opt = document.createElement('option');
                opt.value = cat.value;
                opt.textContent = cat.label;
                select.appendChild(opt);
            });
        } catch (e) {
            // Non-fatal — filter just stays at "All Categories"
        }
    }

    // Expected shape: { stats: [{ id, label, value, note, icon }] }
    function renderStatCards(summary) {
        const row = document.getElementById('statsRow');
        row.innerHTML = '';
        const stats = (summary && summary.stats) || [];

        if (stats.length === 0) {
            row.innerHTML = `<div class="col-span-full text-xs font-semibold text-rose-600">No forecast stats available.</div>`;
            return;
        }

        stats.forEach(stat => {
            const iconSvg = ICONS[stat.icon] || '';
            const valueColor = stat.positive === true ? 'text-emerald-600' : (stat.positive === false ? 'text-rose-600' : 'text-slate-900');
            const card = document.createElement('div');
            card.className = 'bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-start justify-between gap-3';
            card.innerHTML = `
                <div class="space-y-1">
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">${escapeHTML(stat.label)}</span>
                    <div class="text-2xl font-extrabold ${valueColor} font-mono">${escapeHTML(stat.value)}</div>
                    <span class="text-[11px] font-semibold text-slate-500 block">${escapeHTML(stat.note || '')}</span>
                </div>
                ${iconSvg ? `<div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0">${iconSvg}</div>` : ''}
            `;
            row.appendChild(card);
        });
    }

    // Expected shape: { labels: ['Jan','Feb',...], actual: [n,n,...], forecast: [n,n,...] }
    function renderForecastChart(data) {
        const labels = (data && data.labels) || [];
        const actual = (data && data.actual) || [];
        const forecast = (data && data.forecast) || [];

        document.getElementById('chartLoadingMsg').classList.add('hidden');

        if (labels.length === 0) {
            document.getElementById('chartLoadingMsg').textContent = 'No historical/forecast data available.';
            document.getElementById('chartLoadingMsg').classList.remove('hidden');
            return;
        }

        document.getElementById('salesForecastChart').classList.remove('hidden');
        const ctx = document.getElementById('salesForecastChart').getContext('2d');

        const chartData = {
            labels,
            datasets: [
                {
                    label: 'Actual Sales',
                    data: actual,
                    borderColor: '#10b981',
                    backgroundColor: '#10b981',
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointBackgroundColor: '#0f172a',
                    tension: 0.3,
                    spanGaps: true
                },
                {
                    label: 'Forecast',
                    data: forecast,
                    borderColor: '#fb7185',
                    backgroundColor: '#fb7185',
                    borderWidth: 2.5,
                    borderDash: [4, 4],
                    pointRadius: 2,
                    tension: 0.3,
                    spanGaps: true
                }
            ]
        };

        if (forecastChart) {
            forecastChart.data = chartData;
            forecastChart.update();
        } else {
            forecastChart = new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 }, color: '#94a3b8' } },
                        x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#94a3b8' } }
                    }
                }
            });
        }
    }

    // Expected shape: { items: [{ id, product, currentStock, lastMonthSale, forecast, status }] }
    function renderProductForecast(data) {
        const body = document.getElementById('productForecastBody');
        const items = (data && data.items) || [];

        if (items.length === 0) {
            body.innerHTML = `<tr><td colspan="5" class="py-6 text-center text-slate-400 italic font-normal">No product forecast data available.</td></tr>`;
            return;
        }

        body.innerHTML = items.map(item => {
            const status = DEMAND_STATUS_MAP[item.status] || { label: item.status || '—', dot: 'bg-slate-300' };
            return `
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="py-3 px-3 font-bold text-slate-900">${escapeHTML(item.product)}</td>
                    <td class="py-3 px-3 font-mono">${escapeHTML(formatNumber(item.currentStock))}</td>
                    <td class="py-3 px-3 font-mono">${escapeHTML(formatNumber(item.lastMonthSale))}</td>
                    <td class="py-3 px-3 font-mono">${escapeHTML(formatNumber(item.forecast))}</td>
                    <td class="py-3 px-3">
                        <span class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full ${status.dot} flex-shrink-0"></span>
                            ${escapeHTML(status.label)}
                        </span>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Expected shape: { items: [{ id, product, recommendation }] }
    function renderRecommendations(data) {
        const body = document.getElementById('recommendationsBody');
        const items = (data && data.items) || [];

        if (items.length === 0) {
            body.innerHTML = `<tr><td colspan="2" class="py-6 text-center text-slate-400 italic font-normal">No planning recommendations available.</td></tr>`;
            return;
        }

        body.innerHTML = items.map(item => `
            <tr class="hover:bg-slate-50/80 transition">
                <td class="py-3 px-3 font-bold text-slate-900">${escapeHTML(item.product)}</td>
                <td class="py-3 px-3 font-medium text-slate-600">${escapeHTML(item.recommendation)}</td>
            </tr>
        `).join('');
    }

    async function loadForecastData() {
        const filters = currentFilters();
        const qs = buildQuery(filters);

        fetchJSON(ENDPOINTS.forecastSummary + qs)
            .then(renderStatCards)
            .catch(() => {
                document.getElementById('statsRow').innerHTML =
                    `<div class="col-span-full text-xs font-semibold text-rose-600">Could not load forecast stats.</div>`;
            });

        fetchJSON(ENDPOINTS.historicalVsForecast + qs)
            .then(renderForecastChart)
            .catch(() => {
                document.getElementById('chartLoadingMsg').textContent = 'Could not load chart data.';
                document.getElementById('chartLoadingMsg').classList.remove('hidden');
                document.getElementById('salesForecastChart').classList.add('hidden');
            });

        fetchJSON(ENDPOINTS.productForecast + qs)
            .then(renderProductForecast)
            .catch(() => {
                document.getElementById('productForecastBody').innerHTML =
                    `<tr><td colspan="5" class="py-6 text-center text-rose-600 font-normal">Could not load product forecast.</td></tr>`;
            });

        fetchJSON(ENDPOINTS.recommendations + qs)
            .then(renderRecommendations)
            .catch(() => {
                document.getElementById('recommendationsBody').innerHTML =
                    `<tr><td colspan="2" class="py-6 text-center text-rose-600 font-normal">Could not load recommendations.</td></tr>`;
            });
    }

    function formatNumber(n) {
        if (typeof n !== 'number') return n;
        return n.toLocaleString();
    }
    function escapeHTML(str) {
        if (str === null || str === undefined) return '';
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadCategories();
        loadForecastData();
    });
    </script>
</body>
</html>
