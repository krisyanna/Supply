<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3. Logistics & Transportation Management | Full ERP Suite</title>

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

        /* Clean Scrollbars */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .submenu-transition {
            transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease-in-out;
            overflow: hidden;
        }

        .modal-overlay {
            background-color: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(8px);
        }

        @keyframes radar-pulse {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.6); opacity: 0.2; }
            100% { transform: scale(2.2); opacity: 0; }
        }
        .animate-radar {
            animation: radar-pulse 2.2s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen overflow-x-hidden antialiased">

    <!-- SIMULATED DRIVER CALL OVERLAY MODAL -->
    <div id="simulated-call-overlay" class="fixed inset-0 z-50 modal-overlay flex items-center justify-center p-4 hidden">
        <div class="bg-slate-900 text-white w-full max-w-sm p-7 rounded-3xl shadow-2xl border border-slate-800 text-center flex flex-col items-center space-y-5 relative overflow-hidden">
            <div class="relative flex items-center justify-center mt-2">
                <div class="absolute w-28 h-28 bg-indigo-500/20 rounded-full animate-radar"></div>
                <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center text-white border-2 border-indigo-300 shadow-xl relative z-10">
                    <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
            </div>

            <div class="space-y-1 relative z-10">
                <span class="text-[10px] font-extrabold tracking-widest text-indigo-400 uppercase bg-indigo-950 px-3 py-1 rounded-full border border-indigo-500/30">Active Telemetry Call</span>
                <h3 id="call-driver-name" class="text-xl font-bold text-white pt-2">Erich De Torres</h3>
                <p id="call-driver-number" class="text-xs text-slate-400 font-mono">+63 917 888 2002</p>
            </div>

            <div class="w-full bg-slate-800/80 rounded-2xl p-3 border border-slate-700/60 flex items-center justify-between px-4 text-xs font-medium text-slate-300">
                <span class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span id="call-status-text">Connecting...</span>
                </span>
                <span class="font-mono text-slate-400" id="call-timer">00:04</span>
            </div>

            <button type="button" onclick="hangUpSimulatedCall()" class="w-12 h-14 bg-rose-600 hover:bg-rose-500 rounded-full flex items-center justify-center text-white shadow-lg transition active:scale-95">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z"></path>
                </svg>
            </button>
        </div>
    </div>

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

                <a href="{{ route('home') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <span>Procurement & Suppliers</span>
                </a>

                <!-- LOGISTICS SUB-MODULE DROPDOWN -->
                <div class="space-y-1">
                    <button type="button" onclick="toggleSubmenu('logistics-submenu', 'logistics-chevron')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-800 text-white font-semibold text-xs border border-slate-700/60 shadow-sm">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Logistics Sub-Module</span>
                        </div>
                        <svg id="logistics-chevron" class="w-3.5 h-3.5 text-white transition-transform duration-300 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div id="logistics-submenu" class="submenu-transition max-h-96 opacity-100 pl-7 pr-2 space-y-1">
                        <button type="button" onclick="switchTab('schedules')" id="sub-btn-schedules" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Shipment Schedules</span>
                        </button>
                        
                        <button type="button" onclick="switchTab('tracking')" id="sub-btn-tracking" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-white bg-indigo-600/30 border border-indigo-500/30 transition">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            <span>Delivery Tracking</span>
                        </button>
                        
                        <button type="button" onclick="switchTab('routes')" id="sub-btn-routes" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            <span>Shipping Routes</span>
                        </button>
                        
                        <button type="button" onclick="switchTab('status')" id="sub-btn-status" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span>Transportation Status</span>
                        </button>
                    </div>
                </div>

                <a href="{{ route('inventory') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0T9 7m3 4t3-4"></path>
                    </svg>
                    <span>Inventory & Warehouse</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-rose-300 hover:text-white hover:bg-rose-600/20 font-bold text-xs bg-rose-950/20 border border-rose-500/20 transition">
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
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Dashboard</h1>
                    <p class="text-xs text-slate-500 font-medium">3. Logistics & Transportation Management (Integrated ERP Suite)</p>
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <div class="relative w-60">
                        <input type="text" id="global-search-input" onkeyup="globalDashboardSearch()" placeholder="Search everywhere..." class="w-full pl-8 pr-4 py-1.5 bg-slate-50 border border-indigo-300 rounded-full text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition shadow-inner">
                        <svg class="w-3.5 h-3.5 text-indigo-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <button type="button" onclick="openFilterModal()" class="px-3.5 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-xs">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        <span>Filter</span>
                    </button>

                    <button type="button" onclick="downloadLogisticsReport()" class="px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-xs">
                        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span>Download report</span>
                    </button>

                    <button type="button" onclick="openModal('addModal')" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-xs active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Add Shipment</span>
                    </button>
                </div>
            </header>

            <div class="p-8 max-w-7xl w-full mx-auto flex-1 space-y-6">

                <!-- INTEGRATED DATA SOURCES BAR -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-3.5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3">
                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-lg font-extrabold text-[10px] uppercase border border-blue-100">Procurement</span>
                        <div class="text-xs">
                            <span class="text-slate-400 block text-[9px] uppercase font-bold">Purchase Orders</span>
                            <span class="font-bold text-slate-800">{{ count($purchaseOrders) }} POs Linked</span>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3">
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg font-extrabold text-[10px] uppercase border border-emerald-100">Inventory</span>
                        <div class="text-xs">
                            <span class="text-slate-400 block text-[9px] uppercase font-bold">Warehouses & Products</span>
                            <span class="font-bold text-slate-800">{{ count($warehouses) }} Depots / {{ count($products) }} SKUs</span>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3">
                        <span class="px-2.5 py-1 bg-purple-50 text-purple-700 rounded-lg font-extrabold text-[10px] uppercase border border-purple-100">Sales</span>
                        <div class="text-xs">
                            <span class="text-slate-400 block text-[9px] uppercase font-bold">Customer Orders</span>
                            <span class="font-bold text-slate-800">{{ count($customerOrders) }} Outbound Orders</span>
                        </div>
                    </div>
                </div>

                <!-- KPI CARDS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                        <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">ACTIVE SHIPMENTS</span>
                        <div class="text-2xl font-extrabold text-slate-900 mt-1 font-mono">{{ count($shipments) }}</div>
                        <span class="text-[11px] font-semibold text-emerald-600 mt-1.5 block">MySQL rows compiled</span>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                        <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">DELAYED</span>
                        <div class="text-2xl font-extrabold text-slate-900 mt-1 font-mono">0</div>
                        <span class="text-[11px] font-semibold text-amber-600 mt-1.5 block">Requires active response</span>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                        <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">FUEL EFFICIENCY</span>
                        <div class="text-2xl font-extrabold text-slate-900 mt-1">6.7 <span class="text-xs font-normal text-slate-500">km/L</span></div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                        <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">TOTAL DELIVERY BUDGET</span>
                        <div class="text-2xl font-extrabold text-slate-900 mt-1 font-mono">₱34,850.00</div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TAB 1: SHIPMENT SCHEDULES                  -->
                <!-- ========================================== -->
                <div id="view-schedules" class="tab-view space-y-6 hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                        
                        <!-- LEFT: ACTIVE SHIPMENTS LIST WITH INTERACTIVE FILTER PILLS -->
                        <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="font-bold text-slate-900 text-sm">Active Shipments</h3>

                                <!-- INTERACTIVE FILTER PILLS BAR -->
                                <div class="flex items-center bg-slate-100/90 p-1 rounded-2xl text-[11px] font-bold text-slate-500 gap-1 border border-slate-200/60">
                                    <button type="button" onclick="filterShipments('all')" id="filter-btn-all" class="filter-pill-btn px-3 py-1 bg-white text-indigo-600 rounded-xl shadow-xs transition-all">
                                        All
                                    </button>
                                    <button type="button" onclick="filterShipments('In transit')" id="filter-btn-intransit" class="filter-pill-btn px-3 py-1 hover:text-slate-900 rounded-xl transition-all">
                                        In transit
                                    </button>
                                    <button type="button" onclick="filterShipments('Delayed')" id="filter-btn-delayed" class="filter-pill-btn px-3 py-1 hover:text-slate-900 rounded-xl transition-all">
                                        Delayed
                                    </button>
                                    <button type="button" onclick="filterShipments('Delivered')" id="filter-btn-delivered" class="filter-pill-btn px-3 py-1 hover:text-slate-900 rounded-xl transition-all">
                                        Delivered
                                    </button>
                                </div>
                            </div>

                            <!-- SHIPMENT ROWS -->
                            <div class="divide-y divide-slate-100 text-xs" id="shipments-container">
                                @foreach($shipments as $s)
                                <div class="shipment-row py-3 flex items-center justify-between group transition-all cursor-pointer hover:bg-indigo-50/30 px-2 rounded-xl" onclick="selectAndGoToTracking('{{ $s['shipment_code'] }}')" data-status="{{ $s['status'] === 'En Route' ? 'In transit' : $s['status'] }}">
                                    <div class="flex items-center gap-3">
                                        <span class="w-2.5 h-2.5 rounded-full {{ $s['status'] === 'Delivered' ? 'bg-emerald-500' : 'bg-indigo-500 animate-pulse' }}"></span>
                                        <div>
                                            <span class="font-bold font-mono text-slate-900 block text-xs">#{{ $s['shipment_code'] }}</span>
                                            <span class="text-slate-400 font-medium text-[11px]">{{ $s['driver_name'] }}</span>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <span class="font-bold text-slate-800 block text-xs">{{ $s['route_path'] }}</span>
                                        <span class="text-slate-400 font-medium text-[11px]">{{ $s['estimated_arrival'] }}</span>
                                    </div>

                                    <div class="text-right">
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold inline-block uppercase {{ $s['status'] === 'Delivered' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-indigo-50 text-indigo-700 border border-indigo-200' }}">
                                            {{ $s['status'] }}
                                        </span>
                                        <span class="text-slate-400 block text-[10px] mt-0.5 font-mono">{{ $s['time_left'] }}</span>
                                    </div>
                                </div>
                                @endforeach

                                <!-- EMPTY FILTER STATE MESSAGE -->
                                <div id="no-shipments-msg" class="py-8 text-center space-y-2 hidden">
                                    <p class="text-xs font-bold text-slate-500">No shipments found under this filter category.</p>
                                    <button type="button" onclick="filterShipments('all')" class="text-[11px] font-extrabold text-indigo-600 hover:underline">Reset to View All</button>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT: MAPS PREVIEW CONTAINER -->
                        <div class="lg:col-span-5 bg-indigo-50/50 p-5 rounded-2xl border border-indigo-100 flex flex-col justify-between relative overflow-hidden h-[330px]">
                            <div class="flex items-center justify-between relative z-10">
                                <span class="px-3 py-1 bg-white text-indigo-700 rounded-full text-xs font-bold border border-indigo-200 shadow-xs flex items-center gap-1">
                                    Maps Preview <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                            </div>

                            <svg class="absolute inset-0 w-full h-full p-4" viewBox="0 0 400 300" fill="none">
                                <path d="M 50 200 C 150 100, 250 120, 350 250" stroke="#3b82f6" stroke-width="5" stroke-linecap="round" />
                                <path d="M 50 200 Q 200 230, 350 250" stroke="#f59e0b" stroke-width="3" stroke-dasharray="6 6" />
                                <circle cx="150" cy="180" r="16" fill="#3b82f6" fill-opacity="0.3" class="animate-radar"/>
                                <circle cx="150" cy="180" r="7" fill="#2563eb" stroke="#ffffff" stroke-width="2"/>
                                <circle cx="320" cy="220" r="14" fill="#a855f7" fill-opacity="0.3"/>
                                <circle cx="320" cy="220" r="6" fill="#9333ea" stroke="#ffffff" stroke-width="2"/>
                                <text x="50" y="190" fill="#1e293b" font-size="10" font-weight="bold">Cavite</text>
                                <text x="120" y="150" fill="#1e293b" font-size="10" font-weight="bold">Bacoor Bay</text>
                                <text x="270" y="160" fill="#1e293b" font-size="10" font-weight="bold">Taguig</text>
                                <text x="220" y="230" fill="#1e293b" font-size="10" font-weight="bold">Imus</text>
                            </svg>

                            <button type="button" onclick="switchTab('tracking')" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition shadow-lg relative z-10 text-center">
                                Click to view interactive tracking & map
                            </button>
                        </div>

                    </div>

                    <!-- BOTTOM ANALYTICS ROW -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                        <div class="lg:col-span-6 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
                            <h3 class="font-extrabold text-slate-400 text-[10px] uppercase tracking-wider">Fleet Fuel Efficiency</h3>
                            <div class="bg-slate-50 p-4 rounded-xl flex items-end justify-between h-40 gap-3 border border-slate-100">
                                <div class="flex-1 bg-indigo-100 rounded-t-lg h-[40%] flex items-center justify-center text-[10px] font-bold text-indigo-700">Vehicle 1</div>
                                <div class="flex-1 bg-sky-100 rounded-t-lg h-[70%] flex items-center justify-center text-[10px] font-bold text-sky-700">Vehicle 2</div>
                                <div class="flex-1 bg-emerald-100 rounded-t-lg h-[30%] flex items-center justify-center text-[10px] font-bold text-emerald-700">Vehicle 3</div>
                                <div class="flex-1 bg-amber-100 rounded-t-lg h-[85%] flex items-center justify-center text-[10px] font-bold text-amber-700">Vehicle 4</div>
                            </div>
                        </div>

                        <div class="lg:col-span-3 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
                            <h3 class="font-extrabold text-slate-400 text-[10px] uppercase tracking-wider">Shipment by City</h3>
                            <div class="space-y-2 text-xs font-bold">
                                <div class="bg-slate-50 p-2.5 rounded-xl flex justify-between border border-slate-100"><span>Cavite</span><span class="text-indigo-600 font-mono">89%</span></div>
                                <div class="bg-slate-50 p-2.5 rounded-xl flex justify-between border border-slate-100"><span>Laguna</span><span class="text-indigo-600 font-mono">78%</span></div>
                                <div class="bg-slate-50 p-2.5 rounded-xl flex justify-between border border-slate-100"><span>Batangas</span><span class="text-amber-600 font-mono">51%</span></div>
                            </div>
                        </div>

                        <div class="lg:col-span-3 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
                            <h3 class="font-extrabold text-slate-400 text-[10px] uppercase tracking-wider">Driver Status</h3>
                            <div class="flex items-center justify-between gap-2">
                                <div class="relative w-20 h-20 flex items-center justify-center">
                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e2e8f0" stroke-width="3"/>
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#10b981" stroke-width="3.5" stroke-dasharray="83, 100"/>
                                    </svg>
                                    <span class="absolute text-sm font-extrabold text-slate-900 font-mono">100</span>
                                </div>
                                <div class="space-y-1 text-[11px] font-bold text-slate-600">
                                    <div class="flex justify-between gap-2"><span>On Route</span><strong class="font-mono text-emerald-600">83</strong></div>
                                    <div class="flex justify-between gap-2"><span>Available</span><strong class="font-mono text-amber-600">11</strong></div>
                                    <div class="flex justify-between gap-2"><span>Off Shift</span><strong class="font-mono text-slate-400">6</strong></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TAB 2: ENHANCED DELIVERY TRACKING WITH MAP -->
                <!-- ========================================== -->
                <div id="view-tracking" class="tab-view space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        
                        <!-- LEFT SIDE: TRACKING CARDS LIST -->
                        <div class="lg:col-span-5 space-y-4">
                            
                            <!-- SEARCH & FILTER TOOLBAR -->
                            <div class="flex items-center gap-2">
                                <div class="relative flex-1">
                                    <input type="text" id="tracking-search-input" onkeyup="searchTrackingCards()" placeholder="Enter shipment ID..." class="w-full pl-9 pr-8 py-2.5 bg-white border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-xs">
                                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <button type="button" onclick="alert('Filtering applied')" class="p-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-2xl text-slate-600 shadow-xs transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                </button>
                            </div>

                            <!-- CARDS LIST -->
                            <div class="space-y-3" id="tracking-cards-container">
                                @foreach($shipments as $s)
                                <div class="tracking-card p-4 rounded-3xl border bg-white space-y-3 shadow-xs hover:border-indigo-400 transition-all cursor-pointer group" onclick="selectAndGoToTracking('{{ $s['shipment_code'] }}')" data-code="{{ $s['shipment_code'] }}" data-driver="{{ $s['driver_name'] }}">
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="font-extrabold text-slate-900 text-sm font-mono group-hover:text-indigo-600 transition">#{{ $s['shipment_code'] }}</span>
                                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase border tracking-wider {{ $s['status'] === 'Delivered' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                            {{ $s['status'] }}
                                        </span>
                                    </div>

                                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full bg-amber-500 transition-all duration-500" style="width: {{ $s['progress_pct'] }}%"></div>
                                    </div>

                                    <div class="flex justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                                        <span>Cavite</span>
                                        <span>Laguna</span>
                                    </div>

                                    <div class="flex items-center justify-between pt-2 border-t border-slate-100" onclick="event.stopPropagation()">
                                        <div>
                                            <p class="font-bold text-slate-900 text-xs">{{ $s['driver_name'] }}</p>
                                            <p class="text-[9px] text-slate-400 font-bold uppercase">{{ $s['courier'] }}</p>
                                        </div>

                                        <div class="flex items-center gap-1.5">
                                            <button type="button" onclick="alert('Opening Direct Chat with Driver {{ $s['driver_name'] }}...')" class="p-1.5 bg-slate-50 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 rounded-xl transition border border-slate-200/60 shadow-xs" title="Chat">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                            </button>
                                            <button type="button" onclick="initiateSimulatedCall('{{ $s['driver_name'] }}', '{{ $s['phone_number'] }}')" class="p-1.5 bg-slate-50 hover:bg-emerald-50 text-slate-600 hover:text-emerald-600 rounded-xl transition border border-slate-200/60 shadow-xs" title="Call">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            </button>
                                            <button type="button" onclick="openModal('addModal')" class="p-1.5 bg-slate-50 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 rounded-xl transition border border-slate-200/60 shadow-xs" title="Edit">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <button type="button" onclick="confirmDeleteTrackingCard(this, '{{ $s['shipment_code'] }}')" class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl transition border border-rose-100 shadow-xs" title="Delete">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- RIGHT SIDE: STYLIZED DARK MAP WITH COMPACT, HUGGING FLOATING CARD -->
                        <div class="lg:col-span-7 bg-[#11192e] rounded-3xl border border-slate-800 relative overflow-hidden h-[580px] shadow-2xl flex items-center justify-center p-6">
                            
                            <!-- TOP-LEFT FASTEST ROUTE BADGE -->
                            <div class="absolute top-6 left-6 z-20 bg-indigo-600 text-white px-4 py-2 rounded-2xl shadow-xl border border-indigo-400/30 flex flex-col">
                                <span class="text-sm font-extrabold" id="map-travel-time">1 hr 29 min</span>
                                <span class="text-[9px] font-bold text-indigo-200 uppercase tracking-widest">Fastest Route</span>
                            </div>

                            <!-- CENTER FLOATING DRIVER TELEMETRY CARD (COMPACT HEIGHT - NO EXTRA EMPTY SPACE) -->
                            <div class="absolute right-6 top-6 w-80 bg-slate-50/95 backdrop-blur-md rounded-3xl p-4 border border-slate-200/80 shadow-2xl z-20 flex flex-col space-y-3 text-xs">
                                
                                <!-- DRIVER & COMPACT CALL BUTTON -->
                                <div class="flex items-center justify-between border-b border-slate-200/60 pb-2.5">
                                    <div>
                                        <h4 class="font-extrabold text-slate-900 text-sm tracking-tight" id="float-driver-name">Erich De Torres</h4>
                                        <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400 block mt-0.5" id="float-courier">JNT EXPRESS</span>
                                    </div>
                                    <button type="button" onclick="callCurrentDriver()" class="w-8 h-8 bg-slate-200/80 hover:bg-emerald-500 hover:text-white text-slate-700 rounded-full flex items-center justify-center transition shadow-xs" title="Call Driver">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </button>
                                </div>

                                <div>
                                    <span class="text-[8px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">SHIPMENT ID</span>
                                    <h3 class="text-xs font-extrabold text-slate-900 font-mono tracking-tight" id="float-shipment-id">#ABC-01234</h3>
                                </div>

                                <!-- COMPACT TIMELINE CHECKPOINTS -->
                                <div class="space-y-2.5 pt-0.5 relative border-l-2 border-slate-200 ml-2 pl-3">
                                    <div class="relative">
                                        <span class="absolute -left-[17px] top-1 w-2 h-2 rounded-full bg-amber-500 ring-4 ring-amber-100"></span>
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-extrabold text-slate-800 text-[11px]" id="float-time-eta">Estimated 13 Sept 2026</p>
                                                <span class="text-[9px] font-extrabold text-amber-600 block" id="float-status-4">En Route</span>
                                            </div>
                                            <span class="text-[9px] font-mono text-slate-400">10:20 AM</span>
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <span class="absolute -left-[17px] top-1 w-2 h-2 rounded-full bg-amber-500"></span>
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-extrabold text-slate-800 text-[11px]">12 Sept 2026</p>
                                                <span class="text-[9px] font-extrabold text-amber-600 block">In Transit</span>
                                            </div>
                                            <span class="text-[9px] font-mono text-slate-400">09:15 AM</span>
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <span class="absolute -left-[17px] top-1 w-2 h-2 rounded-full bg-amber-500"></span>
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-extrabold text-slate-800 text-[11px]">11 Sept 2026</p>
                                                <span class="text-[9px] font-extrabold text-amber-600 block">In Sorting Centre</span>
                                            </div>
                                            <span class="text-[9px] font-mono text-slate-400">06:21 AM</span>
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <span class="absolute -left-[17px] top-1 w-2 h-2 rounded-full bg-amber-500"></span>
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-extrabold text-slate-800 text-[11px]">10 Sept 2026</p>
                                                <span class="text-[9px] font-extrabold text-amber-600 block">Order Confirmed</span>
                                            </div>
                                            <span class="text-[9px] font-mono text-slate-400">07:24 AM</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SVG GRAPHIC STYLIZED CURVED MAP VECTORS -->
                            <svg class="absolute inset-0 w-full h-full p-4 relative z-10" viewBox="0 0 600 500" fill="none">
                                <path d="M 50 280 Q 200 240, 320 340 T 550 420" stroke="#3b82f6" stroke-width="6" stroke-linecap="round" />
                                <path d="M 50 360 Q 280 480, 550 420" stroke="#10b981" stroke-width="5" stroke-linecap="round" />
                                <text x="180" y="220" fill="#475569" font-size="28" font-weight="900" opacity="0.4">Los Baños</text>
                                <text x="180" y="460" fill="#475569" font-size="24" font-weight="900" opacity="0.4">Alaminos</text>
                                <g id="status-live-truck" class="cursor-pointer">
                                    <circle id="truck-circle-ping" cx="480" cy="390" r="16" fill="#ef4444" fill-opacity="0.4" class="animate-ping"/>
                                    <circle id="truck-circle-main" cx="480" cy="390" r="8" fill="#ef4444" stroke="#ffffff" stroke-width="2"/>
                                </g>
                            </svg>

                        </div>

                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TAB 3: SHIPPING ROUTES & EXACT "SEE LIST"  -->
                <!-- ========================================== -->
                <div id="view-routes" class="tab-view space-y-6 hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        
                        <!-- LEFT SIDEBAR CATEGORY LIST & DRIVERS -->
                        <div class="lg:col-span-4 space-y-4">
                            <div class="relative w-full">
                                <input type="text" placeholder="Search driver or order ID..." class="w-full pl-9 pr-8 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>

                            <!-- DRIVERS "SEE ORDER" CARDS -->
                            <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-xs space-y-2.5">
                                @foreach($shipments as $s)
                                <div class="flex items-center justify-between text-xs p-2.5 bg-slate-50/80 rounded-2xl border border-slate-100 hover:border-indigo-200 transition">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-extrabold flex items-center justify-center text-[10px]">👤</div>
                                        <div>
                                            <span class="font-extrabold text-slate-900 block leading-tight">{{ $s['driver_name'] }}</span>
                                            <span class="text-[10px] text-slate-400 font-mono">#{{ $s['shipment_code'] }}</span>
                                        </div>
                                    </div>
                                    <button type="button" onclick="loadOrderDetailsRoute('{{ $s['shipment_code'] }}')" class="px-3.5 py-1.5 bg-white hover:bg-indigo-600 hover:text-white border border-slate-200 text-slate-700 text-[11px] font-extrabold rounded-full transition shadow-xs">
                                        See order
                                    </button>
                                </div>
                                @endforeach
                            </div>

                            <!-- EXACT MATCH CATEGORY CARDS FROM USER SCREENSHOT -->
                            <div class="space-y-3 pt-1">
                                
                                <!-- PAID -->
                                <div id="cat-card-PAID" class="cat-filter-card bg-indigo-50/70 border border-indigo-200/80 p-3.5 rounded-3xl flex justify-between items-center text-xs font-extrabold transition-all">
                                    <span class="flex items-center gap-2.5 text-indigo-700">
                                        <span class="w-3 h-3 rounded-full bg-indigo-600"></span> PAID
                                    </span>
                                    <button type="button" onclick="filterCategoryList('PAID')" class="px-4 py-1.5 bg-white hover:bg-indigo-600 hover:text-white text-slate-800 rounded-full shadow-xs font-bold text-[11px] transition border border-slate-200/50">
                                        See List
                                    </button>
                                </div>

                                <!-- PENDINGS -->
                                <div id="cat-card-PENDINGS" class="cat-filter-card bg-white border border-slate-200/90 p-3.5 rounded-3xl flex justify-between items-center text-xs font-extrabold transition-all">
                                    <span class="flex items-center gap-2.5 text-slate-800">
                                        <span class="w-3 h-3 rounded-full bg-amber-500"></span> PENDINGS
                                    </span>
                                    <button type="button" onclick="filterCategoryList('PENDINGS')" class="px-4 py-1.5 bg-slate-100/90 hover:bg-amber-500 hover:text-white text-slate-800 rounded-full font-bold text-[11px] transition">
                                        See List
                                    </button>
                                </div>

                                <!-- CASH ON DELIVERY -->
                                <div id="cat-card-COD" class="cat-filter-card bg-white border border-slate-200/90 p-3.5 rounded-3xl flex justify-between items-center text-xs font-extrabold transition-all">
                                    <span class="flex items-center gap-2.5 text-slate-800">
                                        <span class="w-3 h-3 rounded-full bg-sky-500"></span> CASH ON DELIVERY
                                    </span>
                                    <button type="button" onclick="filterCategoryList('COD')" class="px-4 py-1.5 bg-slate-100/90 hover:bg-sky-500 hover:text-white text-slate-800 rounded-full font-bold text-[11px] transition">
                                        See List
                                    </button>
                                </div>

                                <!-- IN TRANSIT -->
                                <div id="cat-card-IN TRANSIT" class="cat-filter-card bg-white border border-slate-200/90 p-3.5 rounded-3xl flex justify-between items-center text-xs font-extrabold transition-all">
                                    <span class="flex items-center gap-2.5 text-slate-800">
                                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span> IN TRANSIT
                                    </span>
                                    <button type="button" onclick="filterCategoryList('IN TRANSIT')" class="px-4 py-1.5 bg-slate-100/90 hover:bg-emerald-500 hover:text-white text-slate-800 rounded-full font-bold text-[11px] transition">
                                        See List
                                    </button>
                                </div>

                            </div>
                        </div>

                        <!-- RIGHT MAIN TABLES & ROUTE MAP -->
                        <div class="lg:col-span-8 space-y-6">
                            
                            <!-- DELIVERY SCHEDULE LOG LEDGER -->
                            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden p-5 space-y-4">
                                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                    Delivery Schedule Log Ledger
                                </h3>

                                <div class="overflow-x-auto text-xs">
                                    <table class="w-full text-left border-collapse">
                                        <thead class="text-slate-400 font-bold border-b border-slate-100">
                                            <tr>
                                                <th class="pb-3">Day/Date</th>
                                                <th class="pb-3">Order Code</th>
                                                <th class="pb-3">Driver Name</th>
                                                <th class="pb-3">Details</th>
                                                <th class="pb-3">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-50 font-medium text-slate-700">
                                            @foreach($shipments as $s)
                                            <tr class="hover:bg-slate-50/80 transition">
                                                <td class="py-3 text-slate-500">{{ $s['date_logged'] }}</td>
                                                <td class="py-3 font-bold font-mono text-indigo-600 cursor-pointer hover:underline" onclick="loadOrderDetailsRoute('{{ $s['shipment_code'] }}')">#{{ $s['shipment_code'] }}</td>
                                                <td class="py-3 font-semibold text-slate-900">{{ $s['driver_name'] }}</td>
                                                <td class="py-3 font-medium">{{ $s['cargo_details'] }}</td>
                                                <td class="py-3">
                                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $s['status'] === 'Delivered' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                                        {{ $s['status'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- DYNAMICALLY FILTERED CATEGORY ORDERS TABLE -->
                            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden p-5 space-y-4">
                                <h3 id="category-table-title" class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                    List of Paid Orders
                                </h3>

                                <div class="overflow-x-auto text-xs">
                                    <table class="w-full text-left border-collapse">
                                        <thead class="text-slate-400 font-bold border-b border-slate-100">
                                            <tr>
                                                <th class="pb-3">Serial</th>
                                                <th class="pb-3">Client Name</th>
                                                <th class="pb-3">Route</th>
                                                <th class="pb-3">Operational Cost</th>
                                                <th class="pb-3">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="category-orders-tbody" class="divide-y divide-slate-50 font-medium text-slate-700">
                                            <tr>
                                                <td class="py-3 font-bold text-slate-500 font-mono">1</td>
                                                <td class="py-3 font-bold text-slate-900">Erich De Torres</td>
                                                <td class="py-3">Cavite - Laguna</td>
                                                <td class="py-3 font-mono font-bold text-emerald-600">₱17,000</td>
                                                <td class="py-3"><span class="text-xs font-bold text-slate-800">En Route</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- ROUTE VECTORS MAP OVERVIEW -->
                            <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs space-y-4" id="route-vectors-section">
                                <h3 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                    Route Vectors Map Overview
                                </h3>

                                <div class="bg-[#d5e8d4] rounded-3xl border border-emerald-200 p-4 relative overflow-hidden h-64 flex flex-col justify-between shadow-inner">
                                    <div class="flex items-center gap-2 relative z-10">
                                        <span class="px-3 py-1 bg-indigo-600 text-white rounded-full text-[10px] font-extrabold shadow-sm flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span> GPS Live Vectors Active
                                        </span>
                                    </div>

                                    <svg class="absolute inset-0 w-full h-full p-4 relative z-0" viewBox="0 0 500 200" fill="none">
                                        <path id="vector-map-line" d="M 180 40 L 260 120 L 380 90" stroke="#2563eb" stroke-width="5" stroke-linecap="round" />
                                        <circle cx="180" cy="40" r="7" fill="#dc2626" stroke="#ffffff" stroke-width="2"/>
                                        <text x="185" y="42" fill="#0f172a" font-size="10" font-weight="extrabold">Origin</text>
                                        <circle cx="380" cy="90" r="8" fill="#10b981" stroke="#ffffff" stroke-width="2"/>
                                        <text id="vector-dest-text" x="350" y="85" fill="#0f172a" font-size="10" font-weight="extrabold">Laguna</text>
                                    </svg>

                                    <div class="bg-slate-800/80 backdrop-blur-md text-white p-3 rounded-2xl max-w-xs border border-slate-700 shadow-lg relative z-10 space-y-0.5">
                                        <p class="font-extrabold text-amber-400 text-xs" id="vector-duration">Estimated duration: 1 hr 7 min</p>
                                        <p class="text-[10px] text-slate-300 font-mono" id="vector-distance">Total distance: 24.9 km</p>
                                    </div>
                                </div>

                                <div class="bg-slate-50 p-5 rounded-3xl border border-slate-200/80 grid grid-cols-2 md:grid-cols-3 gap-4 text-xs font-semibold">
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase block">ORDER ID</span>
                                        <strong id="dt-order-id" class="text-slate-900 font-mono text-sm">#ABC-01234</strong>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase block">CUSTOMER NAME</span>
                                        <strong id="dt-customer-name" class="text-slate-900 text-sm">Erich De Torres</strong>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase block">ORDER STATUS</span>
                                        <span id="dt-order-status" class="px-2.5 py-0.5 bg-indigo-100 text-indigo-700 rounded-full text-[10px] font-extrabold uppercase inline-block mt-0.5">EN ROUTE</span>
                                    </div>

                                    <div class="col-span-2">
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase block">DELIVERY ADDRESS</span>
                                        <p id="dt-delivery-addr" class="text-slate-800 font-medium">137 Gomez St, Brgy 2, Laguna City</p>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase block">PHONE #</span>
                                        <p id="dt-phone" class="text-slate-800 font-mono">+63 912 575 4567</p>
                                    </div>

                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase block">ORDER DETAILS</span>
                                        <p id="dt-cargo" class="text-slate-800 font-medium">Vertex [Mother Board] Ryzen-5</p>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase block">QUANTITY</span>
                                        <p id="dt-qty" class="text-slate-800 font-mono">10</p>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase block">PAYMENT STATUS</span>
                                        <strong id="dt-payment" class="text-emerald-600">Paid</strong>
                                    </div>

                                    <div class="col-span-3 pt-2 border-t border-slate-200/60">
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase block">DELIVERY COST</span>
                                        <strong id="dt-cost" class="text-indigo-600 font-mono text-sm">Php 17,000</strong>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TAB 4: COMPLETE TRANSPORTATION STATUS      -->
                <!-- ========================================== -->
                <div id="view-status" class="tab-view space-y-6 hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        
                        <!-- LEFT SIDE: DYNAMIC SHIPMENT TELEMETRY CARD WITH NEXT/PREV SWITCHER -->
                        <div class="lg:col-span-5 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-5">
                            
                            <!-- ORDER CODE & NEXT/PREV BUTTONS HEADER -->
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <div>
                                    <div class="flex items-center gap-2.5">
                                        <h2 id="tel-shipment-code" class="text-xl font-extrabold text-slate-900 font-mono"># ABC-01234</h2>
                                        <span id="tel-status-badge" class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 border border-indigo-200 font-bold rounded-full text-[10px] uppercase flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-ping"></span>
                                            In Transit
                                        </span>
                                    </div>
                                    <p id="tel-sub-details" class="text-[11px] text-slate-400 font-medium mt-0.5">
                                        Shipping Date: <strong id="tel-ship-date">Sept 11, 2026</strong> • Courier: <strong id="tel-courier" class="text-slate-700">J&T Express</strong>
                                    </p>
                                </div>

                                <!-- NEXT & PREVIOUS SWITCHER BUTTONS -->
                                <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
                                    <button type="button" onclick="navigateShipment(-1)" class="w-8 h-8 bg-white hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition shadow-xs flex items-center justify-center text-xs active:scale-95" title="Previous Active Shipment">
                                        &lt;
                                    </button>
                                    <button type="button" onclick="navigateShipment(1)" class="w-8 h-8 bg-white hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition shadow-xs flex items-center justify-center text-xs active:scale-95" title="Next Active Shipment">
                                        &gt;
                                    </button>
                                </div>
                            </div>

                            <!-- DRIVER HOTLINE & ACTION BUTTONS -->
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div id="tel-driver-avatar" class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-xs">
                                        ED
                                    </div>
                                    <div>
                                        <h4 id="tel-driver-name" class="text-xs font-bold text-slate-900 leading-snug">Erich De Torres</h4>
                                        <span id="tel-driver-phone" class="text-[10px] text-slate-500 font-mono">+63 917 888 2002</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="callCurrentDriver()" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        Call
                                    </button>
                                    <button type="button" onclick="alert('Customer SMS Notification Dispatched!')" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold transition shadow-xs">
                                        Notify
                                    </button>
                                </div>
                            </div>

                            <!-- INTEGRATED DATA SOURCES REFERENCE TAGS -->
                            <div class="grid grid-cols-2 gap-2 text-[11px]">
                                <div class="bg-blue-50/60 p-2.5 rounded-xl border border-blue-100">
                                    <span class="text-[9px] text-blue-500 font-extrabold uppercase block">PROCUREMENT PO</span>
                                    <strong id="tel-po-ref" class="text-blue-900 font-mono">PO-2026-001</strong>
                                </div>
                                <div class="bg-purple-50/60 p-2.5 rounded-xl border border-purple-100">
                                    <span class="text-[9px] text-purple-500 font-extrabold uppercase block">SALES ORDER</span>
                                    <strong id="tel-sales-ref" class="text-purple-900 font-mono">ORD-001 (SM Prime)</strong>
                                </div>
                            </div>

                            <!-- ORIGIN & DESTINATION CARD -->
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70 space-y-3 text-xs">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-3 h-3 rounded-full bg-indigo-600 mt-0.5 flex-shrink-0"></div>
                                    <div>
                                        <span class="font-extrabold text-slate-800 block text-[11px] uppercase tracking-wider">Origin Warehouse (Inventory)</span>
                                        <p id="tel-origin-addr" class="text-slate-600 font-medium">Cavite Central Warehouse — 2118 Ridge St. Cavite, 3564</p>
                                    </div>
                                </div>

                                <div class="border-l-2 border-dashed border-slate-300 ml-1.5 pl-4 py-1 text-[10px] text-slate-400 font-mono" id="tel-route-summary">
                                    Distance: 48.2 km • Route Corridor via Governor Drive
                                </div>

                                <div class="flex items-start gap-2.5">
                                    <div class="w-3 h-3 rounded-full bg-emerald-500 mt-0.5 flex-shrink-0"></div>
                                    <div>
                                        <span class="font-extrabold text-slate-800 block text-[11px] uppercase tracking-wider">Destination Hub (Sales Delivery)</span>
                                        <p id="tel-dest-addr" class="text-slate-600 font-medium">Laguna Distribution Site — 137 Gomez St, Brgy 2, Laguna City</p>
                                    </div>
                                </div>
                            </div>

                            <!-- PROGRESS STEPS BAR -->
                            <div class="space-y-2">
                                <div class="flex justify-between text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">
                                    <span class="text-emerald-600">Departure</span>
                                    <span class="text-emerald-600">Sorting Hub</span>
                                    <span class="text-indigo-600">In Transit</span>
                                    <span>Arrival</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden flex">
                                    <div id="tel-progress-bar" class="bg-emerald-500 h-full w-[68%]" title="En Route Progress"></div>
                                    <div class="bg-indigo-500 h-full w-[12%] animate-pulse"></div>
                                </div>
                                <div class="flex justify-between text-[10px] font-semibold text-slate-500 pt-1">
                                    <span id="tel-time-start">Depot Dispatched (08:00 AM)</span>
                                    <span id="tel-time-eta">Est. Arrival: 13 Sept 2026</span>
                                </div>
                            </div>

                            <!-- VEHICLE SENSOR METRICS -->
                            <div class="grid grid-cols-3 gap-2 text-center text-xs pt-1 border-t border-slate-100">
                                <div class="p-2 bg-slate-50 rounded-lg">
                                    <span class="text-[9px] text-slate-400 uppercase font-bold block">Current Speed</span>
                                    <strong id="tel-speed" class="text-slate-900 font-mono">62 km/h</strong>
                                </div>
                                <div class="p-2 bg-slate-50 rounded-lg">
                                    <span class="text-[9px] text-slate-400 uppercase font-bold block">Cargo Temp</span>
                                    <strong id="tel-cargo-temp" class="text-emerald-600 font-mono">22°C (Optimal)</strong>
                                </div>
                                <div class="p-2 bg-slate-50 rounded-lg">
                                    <span class="text-[9px] text-slate-400 uppercase font-bold block">Fuel Level</span>
                                    <strong id="tel-fuel-level" class="text-indigo-600 font-mono">94% Range</strong>
                                </div>
                            </div>

                        </div>

                        <!-- RIGHT SIDE: HIGH-TECH LIVE GPS VECTOR RADAR MAP -->
                        <div class="lg:col-span-7 bg-[#0b1329] rounded-3xl border border-slate-800 p-6 relative overflow-hidden h-[580px] flex flex-col justify-between shadow-2xl">
                            
                            <!-- GRID OVERLAY -->
                            <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e293b_1px,transparent_1px),linear-gradient(to_bottom,#1e293b_1px,transparent_1px)] bg-[size:35px_35px] opacity-35"></div>

                            <!-- TOP MAP HUD HEADER -->
                            <div class="flex justify-between items-center relative z-20">
                                <div class="bg-slate-900/90 backdrop-blur-md px-3.5 py-1.5 rounded-xl border border-slate-700 text-xs shadow-lg flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                    <span class="font-extrabold text-white text-[11px]" id="map-hud-title">Live Telemetry GPS Radar View</span>
                                </div>
                                <div class="bg-slate-900/90 backdrop-blur-md px-3 py-1 rounded-xl border border-slate-700 text-[10px] font-mono text-indigo-300" id="map-hud-coords">
                                    LAT: 14.2141° N | LON: 121.0522° E
                                </div>
                            </div>

                            <!-- SVG GRAPHIC VECTOR MAP -->
                            <svg class="absolute inset-0 w-full h-full p-6 relative z-10" viewBox="0 0 600 500" fill="none">
                                
                                <!-- MAIN ROUTE CURVE -->
                                <path id="status-route-line" d="M 100 380 Q 250 180, 480 120" stroke="#4f46e5" stroke-width="5" stroke-linecap="round" stroke-dasharray="6 6" class="animate-pulse" />

                                <!-- CHECKPOINT NODE 1: ORIGIN -->
                                <g class="cursor-pointer" onclick="alert('Checkpoint 1: Origin Depot')">
                                    <circle cx="100" cy="380" r="14" fill="#4f46e5" fill-opacity="0.3" class="animate-radar"/>
                                    <circle cx="100" cy="380" r="7" fill="#6366f1" stroke="#ffffff" stroke-width="2"/>
                                    <text id="map-node-origin" x="100" y="415" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">Origin Hub</text>
                                </g>

                                <!-- CHECKPOINT NODE 2: INTERMEDIATE TOLLWAY -->
                                <g class="cursor-pointer" onclick="alert('Checkpoint 2: Toll Plaza Checkpoint')">
                                    <circle cx="280" cy="240" r="10" fill="#f59e0b" fill-opacity="0.3"/>
                                    <circle cx="280" cy="240" r="5" fill="#fbbf24" stroke="#ffffff" stroke-width="1.5"/>
                                    <text x="280" y="220" fill="#cbd5e1" font-size="10" font-weight="bold" text-anchor="middle">Transit Interchange</text>
                                </g>

                                <!-- CHECKPOINT NODE 3: DESTINATION -->
                                <g class="cursor-pointer" onclick="alert('Checkpoint 3: Destination Regional Hub')">
                                    <circle cx="480" cy="120" r="14" fill="#10b981" fill-opacity="0.3" class="animate-radar"/>
                                    <circle cx="480" cy="120" r="7" fill="#34d399" stroke="#ffffff" stroke-width="2"/>
                                    <text id="map-node-dest" x="480" y="95" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">Destination Site</text>
                                </g>

                                <!-- LIVE MOVING TRUCK ICON NODE -->
                                <g id="status-live-truck" class="cursor-pointer">
                                    <circle id="truck-circle-ping" cx="280" cy="240" r="18" fill="#ec4899" fill-opacity="0.4" class="animate-ping"/>
                                    <circle id="truck-circle-main" cx="280" cy="240" r="9" fill="#f43f5e" stroke="#ffffff" stroke-width="2"/>
                                    <text id="truck-status-label" x="280" y="270" fill="#f43f5e" font-size="10" font-weight="extrabold" text-anchor="middle">🚚 TRK-ABC-01234 (En Route)</text>
                                </g>

                            </svg>

                            <!-- BOTTOM TELEMETRY STATUS HUD FOOTER CARD -->
                            <div class="bg-slate-900/90 backdrop-blur-md p-4 rounded-xl border border-slate-700 text-xs text-white space-y-2 shadow-2xl relative z-20">
                                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                                    <span id="map-hud-corridor" class="font-extrabold text-indigo-400 uppercase tracking-widest text-[10px]">Active Route Corridor: Cavite ➔ Laguna Transit</span>
                                    <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-400 font-mono font-bold rounded text-[10px]">GPS SYNCED</span>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-[11px]">
                                    <div>
                                        <span class="text-slate-400 block text-[9px] uppercase font-bold">Assigned Code</span>
                                        <strong id="map-hud-code" class="text-white font-mono"># ABC-01234</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[9px] uppercase font-bold">Driver Name</span>
                                        <strong id="map-hud-driver" class="text-emerald-400 font-mono">Erich De Torres</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[9px] uppercase font-bold">Estimated Time Left</span>
                                        <strong id="map-hud-time" class="text-amber-400 font-mono">4h 22m remaining</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[9px] uppercase font-bold">Telemetry Health</span>
                                        <strong class="text-indigo-300 font-mono">Normal (99.8%)</strong>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- ADD SHIPMENT MODAL -->
    <div id="addModal" class="fixed inset-0 z-50 modal-overlay flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-lg p-6 relative">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3 mb-4">
                <h3 class="text-base font-bold text-slate-800">Add New Logistics Shipment</h3>
                <button type="button" onclick="closeModal('addModal')" class="text-slate-400 font-bold hover:text-slate-700">✕</button>
            </div>

            <form onsubmit="event.preventDefault(); alert('Shipment dispatch record created!'); closeModal('addModal');" class="space-y-3 text-xs font-semibold text-slate-600">
                <div>
                    <label class="block mb-1">Shipment Code</label>
                    <input type="text" required placeholder="ABC-01234" class="w-full p-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block mb-1">Driver Name</label>
                    <input type="text" required placeholder="Erich De Torres" class="w-full p-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block mb-1">Freight Cost (PHP)</label>
                    <input type="number" required placeholder="17000" class="w-full p-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div class="flex justify-end space-x-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeModal('addModal')" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl font-bold">Cancel</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-bold shadow-xs">Save Dispatch</button>
                </div>
            </form>
        </div>
    </div>

    <!-- FILTER MODAL POPUP -->
    <div id="filterModal" class="fixed inset-0 z-50 modal-overlay flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-sm p-6 space-y-4">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h3 class="text-sm font-extrabold text-slate-900">Filter Logistics Data</h3>
                <button type="button" onclick="closeFilterModal()" class="text-slate-400 hover:text-slate-700 font-bold">✕</button>
            </div>
            <div class="space-y-2 text-xs font-semibold text-slate-700">
                <label class="block cursor-pointer"><input type="checkbox" checked class="mr-2"> En Route Shipments</label>
                <label class="block cursor-pointer"><input type="checkbox" checked class="mr-2"> Delivered Shipments</label>
                <label class="block cursor-pointer"><input type="checkbox" checked class="mr-2"> Paid Orders</label>
            </div>
            <button type="button" onclick="closeFilterModal(); alert('Filter applied successfully!');" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl transition">Apply Filter</button>
        </div>
    </div>

    <!-- JAVASCRIPT CONTROLLERS & DYNAMIC ENGINES -->
    <script>
        function toggleSubmenu(menuId, chevronId) {
            const menu = document.getElementById(menuId);
            const chevron = document.getElementById(chevronId);
            if (menu.classList.contains('max-h-0')) {
                menu.classList.remove('max-h-0', 'opacity-0');
                menu.classList.add('max-h-96', 'opacity-100');
                if(chevron) chevron.classList.add('rotate-180');
            } else {
                menu.classList.remove('max-h-96', 'opacity-100');
                menu.classList.add('max-h-0', 'opacity-0');
                if(chevron) chevron.classList.remove('rotate-180');
            }
        }

        function switchTab(tabId) {
            document.querySelectorAll('.tab-view').forEach(view => view.classList.add('hidden'));
            
            const targetView = document.getElementById(`view-${tabId}`);
            if (targetView) targetView.classList.remove('hidden');

            ['schedules', 'tracking', 'routes', 'status'].forEach(id => {
                const btn = document.getElementById(`sub-btn-${id}`);
                if (btn) {
                    btn.className = "w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition";
                }
            });

            const activeBtn = document.getElementById(`sub-btn-${tabId}`);
            if (activeBtn) {
                activeBtn.className = "w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-white bg-indigo-600/30 border border-indigo-500/30";
            }
        }

        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

        function openFilterModal() { document.getElementById('filterModal').classList.remove('hidden'); }
        function closeFilterModal() { document.getElementById('filterModal').classList.add('hidden'); }

        function downloadLogisticsReport() {
            alert('Generating and downloading full Logistics ERP Report CSV...');
        }

        function globalDashboardSearch() {
            const query = document.getElementById('global-search-input').value.toLowerCase();
            if(!query) return;
            const trackingCards = document.querySelectorAll('.tracking-card');
            let found = false;
            trackingCards.forEach(card => {
                const code = card.getAttribute('data-code').toLowerCase();
                const driver = card.getAttribute('data-driver').toLowerCase();
                if(code.includes(query) || driver.includes(query)) found = true;
            });
            if(found) {
                switchTab('tracking');
                document.getElementById('tracking-search-input').value = query;
                searchTrackingCards();
            }
        }

        let callInterval = null;
        function initiateSimulatedCall(driverName, phoneNumber) {
            document.getElementById('call-driver-name').innerText = driverName;
            document.getElementById('call-driver-number').innerText = phoneNumber || '+63 917 888 2002';
            document.getElementById('call-status-text').innerText = "Connecting live line...";
            document.getElementById('simulated-call-overlay').classList.remove('hidden');

            let seconds = 0;
            clearInterval(callInterval);
            callInterval = setInterval(() => {
                seconds++;
                const mins = String(Math.floor(seconds / 60)).padStart(2, '0');
                const secs = String(seconds % 60).padStart(2, '0');
                document.getElementById('call-timer').innerText = `${mins}:${secs}`;
                if(seconds === 2) {
                    document.getElementById('call-status-text').innerText = "Connected • Live Voice";
                }
            }, 1000);
        }

        function hangUpSimulatedCall() {
            clearInterval(callInterval);
            document.getElementById('simulated-call-overlay').classList.add('hidden');
        }

        function filterShipments(category) {
            const rows = document.querySelectorAll('.shipment-row');
            rows.forEach(row => {
                const status = row.getAttribute('data-status');
                if (category === 'all' || status === category) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }

        function searchTrackingCards() {
            const query = document.getElementById('tracking-search-input').value.toLowerCase();
            const cards = document.querySelectorAll('.tracking-card');
            cards.forEach(card => {
                const code = card.getAttribute('data-code').toLowerCase();
                const driver = card.getAttribute('data-driver').toLowerCase();
                if (code.includes(query) || driver.includes(query)) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        function confirmDeleteTrackingCard(button, code) {
            if (confirm(`Remove shipment #${code}?`)) {
                button.closest('.tracking-card').remove();
            }
        }

        const activeShipments = [
            {
                code: 'ABC-01234', status: 'En Route', statusBg: 'bg-indigo-50 text-indigo-700 border-indigo-200', statusDot: 'bg-indigo-600',
                shipDate: 'Sept 11, 2026', courier: 'JNT EXPRESS', driverName: 'Erich De Torres', driverPhone: '+63 912 575 4567', avatarText: 'ED',
                poRef: 'PO-2026-001', salesRef: 'ORD-001 (SM Prime)', origin: 'Cavite Central Warehouse', dest: '137 Gomez St, Brgy 2, Laguna City',
                cargo: 'Vertex [Mother Board] Ryzen-5', qty: '10', cost: 'Php 17,000', payment: 'Paid', progressPct: '68%',
                eta: 'Estimated 13 Sept 2026', travelTime: '1 hr 29 min', distance: '24.9 km', speed: '62 km/h', temp: '22°C (Optimal)', fuel: '94% Range',
                coords: 'LAT: 14.2141° N | LON: 121.0522° E', corridor: 'Active Route Corridor: Cavite ➔ Laguna Transit',
                pathD: 'M 100 380 Q 250 180, 480 120', originName: 'Cavite Depot (Origin)', destName: 'Laguna Hub (Destination)'
            },
            {
                code: 'DEF-56789', status: 'En Route', statusBg: 'bg-amber-50 text-amber-700 border-indigo-200', statusDot: 'bg-amber-600',
                shipDate: 'Sept 11, 2026', courier: 'JNT EXPRESS', driverName: 'Kristy Ann Paracale', driverPhone: '+63 920 333 3003', avatarText: 'KP',
                poRef: 'PO-2026-002', salesRef: 'ORD-002 (Robinsons)', origin: 'Manila Container Port Terminal', dest: 'Bulacan Logistics Warehouse',
                cargo: 'Ryzen-9 Core Kit Combo', qty: '45', cost: 'Php 12,850', payment: 'Pending', progressPct: '40%',
                eta: 'Estimated 13 Sept 2026', travelTime: '2 hr 10 min', distance: '64.5 km', speed: '18 km/h (Traffic Watch)', temp: '24°C (Normal)', fuel: '81% Range',
                coords: 'LAT: 14.5995° N | LON: 120.9842° E', corridor: 'Active Route Corridor: Manila Port ➔ Bulacan Hub',
                pathD: 'M 120 120 Q 300 350, 500 220', originName: 'Manila Port Terminal', destName: 'Bulacan Hub (Destination)'
            },
            {
                code: 'GHI-10111', status: 'Delivered', statusBg: 'bg-emerald-50 text-emerald-700 border-indigo-200', statusDot: 'bg-emerald-600',
                shipDate: 'Sept 10, 2026', courier: 'JNT EXPRESS', driverName: 'Juliana Aquino', driverPhone: '+63 912 555 1001', avatarText: 'JA',
                poRef: 'PO-2026-001', salesRef: 'ORD-001 (SM Prime)', origin: 'Pangasinan Central Depot', dest: 'Calamba Distribution Center',
                cargo: 'Groceries Logistics Bundle', qty: '300', cost: 'Php 5,000', payment: 'Paid', progressPct: '100%',
                eta: '13 Sept 2026 (Delivered)', travelTime: '0 hr 00 min', distance: '210.8 km', speed: '0 km/h (Parked)', temp: '20°C (Storage Idle)', fuel: '65% Range',
                coords: 'LAT: 14.2123° N | LON: 121.1663° E', corridor: 'Route Corridor: Pangasinan ➔ Laguna (Completed)',
                pathD: 'M 80 400 Q 280 200, 480 120', originName: 'Pangasinan Depot', destName: 'Laguna Hub (Arrived)'
            }
        ];

        let currentShipmentIndex = 0;

        function renderShipmentTelemetry(index) {
            const data = activeShipments[index];
            if(!data) return;

            document.getElementById('tel-shipment-code').innerText = `# ${data.code}`;
            document.getElementById('tel-status-badge').className = `px-2.5 py-0.5 font-bold rounded-full text-[10px] uppercase flex items-center gap-1 ${data.statusBg}`;
            document.getElementById('tel-status-badge').innerHTML = `<span class="w-1.5 h-1.5 rounded-full ${data.statusDot} animate-ping"></span> ${data.status}`;
            
            document.getElementById('tel-ship-date').innerText = data.shipDate;
            document.getElementById('tel-courier').innerText = data.courier;
            document.getElementById('tel-driver-avatar').innerText = data.avatarText;
            document.getElementById('tel-driver-name').innerText = data.driverName;
            document.getElementById('tel-driver-phone').innerText = data.driverPhone;
            document.getElementById('tel-po-ref').innerText = data.poRef;
            document.getElementById('tel-sales-ref').innerText = data.salesRef;
            document.getElementById('tel-origin-addr').innerText = data.origin;
            document.getElementById('tel-dest-addr').innerText = data.dest;
            document.getElementById('tel-route-summary').innerText = data.routeSummary;
            document.getElementById('tel-progress-bar').style.width = data.progressPct;
            document.getElementById('tel-time-eta').innerText = `Est. Arrival: ${data.eta}`;
            document.getElementById('tel-speed').innerText = data.speed;
            document.getElementById('tel-cargo-temp').innerText = data.temp;
            document.getElementById('tel-fuel-level').innerText = data.fuel;

            document.getElementById('map-hud-coords').innerText = data.coords;
            document.getElementById('map-hud-corridor').innerText = data.corridor;
            document.getElementById('map-hud-code').innerText = `# ${data.code}`;
            document.getElementById('map-hud-driver').innerText = data.driverName;
            document.getElementById('map-hud-time').innerText = data.eta;
            document.getElementById('truck-status-label').innerText = `🚚 TRK-${data.code} (${data.status})`;
            document.getElementById('status-route-line').setAttribute('d', data.pathD);
            document.getElementById('map-node-origin').textContent = data.originName;
            document.getElementById('map-node-dest').textContent = data.destName;
        }

        window.selectAndGoToTracking = function(code) {
            const cleanCode = code.replace('#', '').trim().toUpperCase();
            const index = activeShipments.findIndex(s => s.code.trim().toUpperCase() === cleanCode);
            if (index !== -1) {
                currentShipmentIndex = index;
                const data = activeShipments[index];
                document.getElementById('map-travel-time').innerText = data.travelTime;
                document.getElementById('float-driver-name').innerText = data.driverName;
                document.getElementById('float-courier').innerText = data.courier;
                document.getElementById('float-shipment-id').innerText = `#${data.code}`;
                document.getElementById('float-time-eta').innerText = data.eta;
            }
            switchTab('tracking');
        };

        window.loadOrderDetailsRoute = function(code) {
            const cleanCode = code.replace('#', '').trim().toUpperCase();
            const data = activeShipments.find(s => s.code.trim().toUpperCase() === cleanCode);
            if (data) {
                document.getElementById('dt-order-id').innerText = `#${data.code}`;
                document.getElementById('dt-customer-name').innerText = data.driverName;
                document.getElementById('dt-order-status').innerText = data.status.toUpperCase();
                document.getElementById('dt-delivery-addr').innerText = data.dest;
                document.getElementById('dt-phone').innerText = data.driverPhone;
                document.getElementById('dt-cargo').innerText = data.cargo;
                document.getElementById('dt-qty').innerText = data.qty;
                document.getElementById('dt-payment').innerText = data.payment;
                document.getElementById('dt-cost').innerText = data.cost;
                document.getElementById('vector-duration').innerText = `Estimated duration: ${data.travelTime}`;
                document.getElementById('vector-distance').innerText = `Total distance: ${data.distance}`;
            }
            switchTab('routes');
            document.getElementById('route-vectors-section')?.scrollIntoView({ behavior: 'smooth' });
        };

        const categoryData = {
            'PAID': [
                { serial: '1', client: 'Erich De Torres', route: 'Cavite - Laguna', cost: '₱17,000', status: 'En Route', color: 'text-slate-800' },
                { serial: '2', client: 'Juliana Aquino', route: 'Pangasinan - Laguna', cost: '₱5,000', status: 'Delivered', color: 'text-emerald-600' }
            ],
            'PENDINGS': [
                { serial: '1', client: 'Kristy Ann Paracale', route: 'Manila - Bulacan', cost: '₱12,850', status: 'Pending Verification', color: 'text-amber-600' }
            ],
            'COD': [
                { serial: '1', client: 'Kristy Ann Paracale', route: 'Manila - Bulacan', cost: '₱12,850', status: 'Pending COD Collect', color: 'text-sky-600' }
            ],
            'IN TRANSIT': [
                { serial: '1', client: 'Erich De Torres', route: 'Cavite - Laguna', cost: '₱17,000', status: 'En Route', color: 'text-indigo-600' },
                { serial: '2', client: 'Kristy Ann Paracale', route: 'Manila - Bulacan', cost: '₱12,850', status: 'En Route', color: 'text-indigo-600' }
            ]
        };

        function filterCategoryList(catKey) {
            const titleEl = document.getElementById('category-table-title');
            const tbody = document.getElementById('category-orders-tbody');
            const records = categoryData[catKey] || [];

            titleEl.innerHTML = `<span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> List of ${catKey === 'COD' ? 'Cash on Delivery' : catKey.charAt(0) + catKey.slice(1).toLowerCase()} Orders`;

            tbody.innerHTML = '';
            records.forEach(item => {
                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3 font-bold text-slate-500 font-mono">${item.serial}</td>
                        <td class="py-3 font-bold text-slate-900">${item.client}</td>
                        <td class="py-3">${item.route}</td>
                        <td class="py-3 font-mono font-bold text-emerald-600">${item.cost}</td>
                        <td class="py-3"><span class="text-xs font-bold ${item.color}">${item.status}</span></td>
                    </tr>
                `;
            });

            document.querySelectorAll('.cat-filter-card').forEach(card => {
                card.className = "cat-filter-card bg-white border border-slate-200/90 p-3.5 rounded-3xl flex justify-between items-center text-xs font-extrabold transition-all";
                const btn = card.querySelector('button');
                if (btn) btn.className = "px-4 py-1.5 bg-slate-100/90 hover:bg-slate-200 text-slate-800 rounded-full font-bold text-[11px] transition";
            });

            const activeCard = document.getElementById(`cat-card-${catKey}`);
            if (activeCard) {
                activeCard.className = "cat-filter-card bg-indigo-50/70 border border-indigo-200/80 p-3.5 rounded-3xl flex justify-between items-center text-xs font-extrabold transition-all";
                const activeBtn = activeCard.querySelector('button');
                if (activeBtn) activeBtn.className = "px-4 py-1.5 bg-white hover:bg-indigo-600 hover:text-white text-slate-800 rounded-full shadow-xs font-bold text-[11px] transition border border-slate-200/50";
            }
        }

        function navigateShipment(direction) {
            currentShipmentIndex += direction;
            if (currentShipmentIndex >= activeShipments.length) currentShipmentIndex = 0;
            if (currentShipmentIndex < 0) currentShipmentIndex = activeShipments.length - 1;
            renderShipmentTelemetry(currentShipmentIndex);
        }

        function callCurrentDriver() {
            const data = activeShipments[currentShipmentIndex];
            if(data) initiateSimulatedCall(data.driverName, data.driverPhone);
        }

        let truckProgress = 0.45;
        function animateStatusTruck() {
            truckProgress += 0.003;
            if (truckProgress > 0.92) truckProgress = 0.08;

            const path = document.getElementById('status-route-line');
            if (path && path.getTotalLength) {
                const len = path.getTotalLength();
                const pt = path.getPointAtLength(truckProgress * len);

                const cMain = document.getElementById('truck-circle-main');
                const cPing = document.getElementById('truck-circle-ping');
                const label = document.getElementById('truck-status-label');

                if (cMain) { cMain.setAttribute('cx', pt.x); cMain.setAttribute('cy', pt.y); }
                if (cPing) { cPing.setAttribute('cx', pt.x); cPing.setAttribute('cy', pt.y); }
                if (label) { label.setAttribute('x', pt.x); label.setAttribute('y', pt.y + 30); }
            }
        }

        document.addEventListener("DOMContentLoaded", () => { 
            switchTab('tracking'); // Default to Tab 2 Delivery Tracking on page load
            renderShipmentTelemetry(0);
            setInterval(animateStatusTruck, 80);
        });
    </script>
</body>
</html>