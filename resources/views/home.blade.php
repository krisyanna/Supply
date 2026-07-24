<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Dashboard | Full ERP Suite</title>

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

                <!-- HOME DASHBOARD — ACTIVE (this is the current page) -->
                <a href="{{ route('home') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-slate-800 text-white font-semibold text-xs border border-slate-700/60 shadow-sm">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Home Dashboard</span>
                </a>

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
                        <a href="{{ route('forecasting.demand') }}" class="block px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-300 hover:text-white hover:bg-indigo-600/30 transition">Demand Planning</a>
                        <a href="{{ route('forecasting.historical') }}" class="block px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-300 hover:text-white hover:bg-indigo-600/30 transition">Historical Sales Analytics</a>
                    </div>
                </div>

                <a href="{{ route('procurement.index') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Procurement &amp; Suppliers</span>
                </a>

                <!-- LOGISTICS SUB-MODULE DROPDOWN — collapsed by default (we're on Home) -->
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
                <a href="{{ route('welcome') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-rose-300 hover:text-white hover:bg-rose-600/20 font-bold text-xs bg-rose-950/20 border border-rose-500/20 transition">
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
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Home Dashboard</h1>
                    <p id="pageSubtitle" class="text-xs text-slate-500 font-medium">Loading dashboard…</p>
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <div class="relative w-60">
                        <input type="text" placeholder="Search everywhere..." class="w-full pl-8 pr-4 py-1.5 bg-slate-50 border border-slate-200 rounded-full text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </header>

            <div class="p-8 max-w-7xl w-full mx-auto flex-1 space-y-6">

                <div class="text-2xl font-extrabold text-slate-900">
                    Welcome back, <span id="userName" class="text-indigo-600">…</span>
                </div>

                <!-- KPI STAT CARDS — rendered entirely from JS via renderStatCards() -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="statsRow"></div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                    <!-- INVENTORY OVERVIEW DONUT -->
                    <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                        <h3 class="font-bold text-slate-900 text-sm">Inventory Overview</h3>
                        <div class="flex items-center gap-6">
                            <canvas id="inventoryDonut" width="190" height="190"></canvas>
                            <div class="space-y-2.5 text-xs font-semibold text-slate-700" id="donutLegend"></div>
                        </div>
                    </div>

                    <!-- STOCK REMINDER -->
                    <div class="lg:col-span-5 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                        <h3 class="font-bold text-slate-900 text-sm">Stock Reminder</h3>
                        <div class="overflow-x-auto text-xs">
                            <table class="w-full text-left border-collapse">
                                <thead class="text-slate-400 font-bold border-b border-slate-100">
                                    <tr><th class="pb-3">Product</th><th class="pb-3">Status</th></tr>
                                </thead>
                                <tbody id="stockReminderBody" class="divide-y divide-slate-50 font-medium text-slate-700">
                                    <tr><td colspan="2" class="py-6 text-center text-slate-400 italic">Loading…</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- RECENT ACTIVITIES -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <h3 class="font-bold text-slate-900 text-sm">Recent Activities</h3>
                    <div class="overflow-x-auto text-xs">
                        <table class="w-full text-left border-collapse">
                            <thead class="text-slate-400 font-bold border-b border-slate-100">
                                <tr><th class="pb-3 w-32">Time</th><th class="pb-3">Activity</th></tr>
                            </thead>
                            <tbody id="activityBody" class="divide-y divide-slate-50 font-medium text-slate-700">
                                <tr><td colspan="2" class="py-6 text-center text-slate-400 italic">Loading…</td></tr>
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
         DASHBOARD DATA LAYER — nothing above is hardcoded content;
         everything below fetches from your API and paints the DOM.
         ============================================================ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
    <script>
    const API_BASE_URL = ''; // e.g. 'https://api.yourapp.com' — leave '' for same-origin

    const ENDPOINTS = {
        currentUser:       `${API_BASE_URL}/api/users/me`,
        dashboardSummary:  `${API_BASE_URL}/api/dashboard/summary`,
        inventoryOverview: `${API_BASE_URL}/api/dashboard/inventory-overview`,
        stockReminders:    `${API_BASE_URL}/api/dashboard/stock-reminders`,
        recentActivities:  `${API_BASE_URL}/api/dashboard/recent-activities`
    };

    /* Icon set for stat cards, keyed by an id the API returns in
       dashboardSummary.stats[i].icon — Tailwind bg-* classes, so the
       backend controls which icon+color each card gets. */
    const ICONS = {
        box: {
            bg: 'bg-indigo-600',
            svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>'
        },
        orders: {
            bg: 'bg-sky-600',
            svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>'
        },
        shipment: {
            bg: 'bg-amber-500',
            svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>'
        },
        suppliers: {
            bg: 'bg-emerald-600',
            svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 010 7.75"></path></svg>'
        }
    };

    /* Maps an API status string to a Tailwind badge. Adjust keys to
       match whatever your backend actually sends. */
    const STOCK_STATUS_MAP = {
        out_of_stock: { label: 'Out of stock', classes: 'bg-rose-50 text-rose-700 border border-rose-200' },
        low_stock:    { label: 'Low stock',    classes: 'bg-amber-50 text-amber-700 border border-amber-200' },
        overstocked:  { label: 'Overstocked',  classes: 'bg-indigo-50 text-indigo-700 border border-indigo-200' },
        restocked:    { label: 'Restocked',    classes: 'bg-emerald-50 text-emerald-700 border border-emerald-200' },
        in_stock:     { label: 'In stock',     classes: 'bg-emerald-50 text-emerald-700 border border-emerald-200' }
    };

    /* Fixed color per inventory-overview donut segment. Keys must match
       whatever category names the API returns in segments[i].key */
    const DONUT_COLORS = {
        in_stock:     '#059669',
        restocked:    '#34d399',
        low_stock:    '#fbbf24',
        out_of_stock: '#f43f5e',
        reserved:     '#4f46e5'
    };

    let donutChart = null;

    async function fetchJSON(url, options = {}) {
        const res = await fetch(url, {
            headers: { 'Content-Type': 'application/json' },
            // credentials: 'include', // uncomment if your API relies on cookies/session auth
            ...options
        });
        if (!res.ok) throw new Error(`Request to ${url} failed with status ${res.status}`);
        return res.json();
    }

    function renderUser(user) {
        document.getElementById('userName').textContent = (user && user.firstName) ? `${user.firstName}!` : 'there!';
    }

    // Expected shape: { stats: [{ id, label, value, note, icon }] }
    function renderStatCards(summary) {
        const row = document.getElementById('statsRow');
        row.innerHTML = '';
        const stats = (summary && summary.stats) || [];

        if (stats.length === 0) {
            row.innerHTML = `<div class="col-span-full text-xs font-semibold text-rose-600">No dashboard stats available.</div>`;
            return;
        }

        stats.forEach(stat => {
            const icon = ICONS[stat.icon] || ICONS.box;
            const card = document.createElement('div');
            card.className = 'bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2';
            card.innerHTML = `
                <div class="w-9 h-9 ${icon.bg} rounded-xl flex items-center justify-center">${icon.svg}</div>
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">${escapeHTML(stat.label)}</span>
                <div class="text-2xl font-extrabold text-slate-900 font-mono">${escapeHTML(formatNumber(stat.value))}</div>
                <span class="text-[11px] font-semibold text-slate-500 block">${escapeHTML(stat.note || '')}</span>
            `;
            row.appendChild(card);
        });
    }

    // Expected shape: { segments: [{ key, label, value }] }
    function renderInventoryDonut(overview) {
        const segments = (overview && overview.segments) || [];
        const legend = document.getElementById('donutLegend');
        legend.innerHTML = '';

        if (segments.length === 0) {
            legend.innerHTML = `<div class="text-xs font-semibold text-rose-600">No inventory data available.</div>`;
            if (donutChart) { donutChart.destroy(); donutChart = null; }
            return;
        }

        segments.forEach(seg => {
            const color = DONUT_COLORS[seg.key] || '#94a3b8';
            const item = document.createElement('div');
            item.className = 'flex items-center gap-2';
            item.innerHTML = `<span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:${color};"></span>${escapeHTML(seg.label)}`;
            legend.appendChild(item);
        });

        const ctx = document.getElementById('inventoryDonut').getContext('2d');
        const chartData = {
            labels: segments.map(s => s.label),
            datasets: [{
                data: segments.map(s => s.value),
                backgroundColor: segments.map(s => DONUT_COLORS[s.key] || '#94a3b8'),
                borderWidth: 0,
                cutout: '68%'
            }]
        };

        if (donutChart) {
            donutChart.data = chartData;
            donutChart.update();
        } else {
            donutChart = new Chart(ctx, {
                type: 'doughnut',
                data: chartData,
                options: { responsive: false, plugins: { legend: { display: false } } }
            });
        }
    }

    // Expected shape: { items: [{ id, product, status }] }
    function renderStockReminders(data) {
        const body = document.getElementById('stockReminderBody');
        const items = (data && data.items) || [];

        if (items.length === 0) {
            body.innerHTML = `<tr><td colspan="2" class="py-6 text-center text-slate-400 italic">No stock alerts right now.</td></tr>`;
            return;
        }

        body.innerHTML = items.map(item => {
            const status = STOCK_STATUS_MAP[item.status] || { label: item.status, classes: 'bg-slate-50 text-slate-600 border border-slate-200' };
            return `
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="py-3 font-semibold text-slate-900">${escapeHTML(item.product)}</td>
                    <td class="py-3"><span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase inline-block ${status.classes}">${escapeHTML(status.label)}</span></td>
                </tr>
            `;
        }).join('');
    }

    // Expected shape: { items: [{ id, time, activity }] }
    function renderRecentActivities(data) {
        const body = document.getElementById('activityBody');
        const items = (data && data.items) || [];

        if (items.length === 0) {
            body.innerHTML = `<tr><td colspan="2" class="py-6 text-center text-slate-400 italic">No recent activity.</td></tr>`;
            return;
        }

        body.innerHTML = items.map(item => `
            <tr class="hover:bg-slate-50/80 transition">
                <td class="py-3 text-slate-400 font-mono">${escapeHTML(item.time)}</td>
                <td class="py-3 font-medium text-slate-800">${escapeHTML(item.activity)}</td>
            </tr>
        `).join('');
    }

    async function initDashboard() {
        document.getElementById('pageSubtitle').textContent = 'Overview of your supply chain, live from the database.';

        fetchJSON(ENDPOINTS.currentUser)
            .then(renderUser)
            .catch(() => { document.getElementById('userName').textContent = 'there!'; });

        fetchJSON(ENDPOINTS.dashboardSummary)
            .then(renderStatCards)
            .catch(() => {
                document.getElementById('statsRow').innerHTML =
                    `<div class="col-span-full text-xs font-semibold text-rose-600">Could not load dashboard stats.</div>`;
            });

        fetchJSON(ENDPOINTS.inventoryOverview)
            .then(renderInventoryDonut)
            .catch(() => {
                document.getElementById('donutLegend').innerHTML =
                    `<div class="text-xs font-semibold text-rose-600">Could not load inventory overview.</div>`;
            });

        fetchJSON(ENDPOINTS.stockReminders)
            .then(renderStockReminders)
            .catch(() => {
                document.getElementById('stockReminderBody').innerHTML =
                    `<tr><td colspan="2" class="py-6 text-center text-rose-600">Could not load stock reminders.</td></tr>`;
            });

        fetchJSON(ENDPOINTS.recentActivities)
            .then(renderRecentActivities)
            .catch(() => {
                document.getElementById('activityBody').innerHTML =
                    `<tr><td colspan="2" class="py-6 text-center text-rose-600">Could not load recent activity.</td></tr>`;
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

    document.addEventListener('DOMContentLoaded', initDashboard);
    </script>
</body>
</html>
