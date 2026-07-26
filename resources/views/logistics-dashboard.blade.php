@extends('layouts.app')

@section('content')
<div class="bg-slate-50 text-slate-900 min-h-screen overflow-x-hidden antialiased w-full">

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

            <button type="button" onclick="hangUpSimulatedCall()" class="w-12 h-14 bg-rose-600 hover:bg-rose-500 rounded-full flex items-center justify-center text-white shadow-lg transition active:scale-95">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- MAIN DISPLAY PANEL -->
    <main class="flex-1 flex flex-col overflow-y-auto bg-slate-50 w-full">
        
        <!-- HEADER TOOLBAR -->
        <header class="bg-white px-8 py-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-slate-200/80 sticky top-0 z-30 shadow-xs">
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Dashboard</h1>
                <p class="text-xs text-slate-500 font-medium">3. Logistics & Transportation Management (Integrated ERP Suite)</p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <div class="relative w-60">
                    <input type="text" id="global-search-input" onkeyup="globalDashboardSearch()" placeholder="Search shipments..." class="w-full pl-8 pr-4 py-1.5 bg-slate-50 border border-indigo-300 rounded-full text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition shadow-inner">
                    <svg class="w-3.5 h-3.5 text-indigo-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <button type="button" onclick="openFilterModal()" class="px-3.5 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-xs">
                    <span>Filter</span>
                </button>

                <button type="button" onclick="downloadLogisticsReport()" class="px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-xs">
                    <span>Download report</span>
                </button>

                <button type="button" onclick="openModal('addModal')" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-xs active:scale-95">
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
                        <span class="font-bold text-slate-800">{{ count($purchaseOrders ?? []) }} POs Linked</span>
                    </div>
                </div>

                <div class="bg-white p-3.5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3">
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg font-extrabold text-[10px] uppercase border border-emerald-100">Inventory</span>
                    <div class="text-xs">
                        <span class="text-slate-400 block text-[9px] uppercase font-bold">Warehouses & Products</span>
                        <span class="font-bold text-slate-800">{{ count($warehouses ?? []) }} Depots / {{ count($products ?? []) }} SKUs</span>
                    </div>
                </div>

                <div class="bg-white p-3.5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3">
                    <span class="px-2.5 py-1 bg-purple-50 text-purple-700 rounded-lg font-extrabold text-[10px] uppercase border border-purple-100">Sales</span>
                    <div class="text-xs">
                        <span class="text-slate-400 block text-[9px] uppercase font-bold">Customer Orders</span>
                        <span class="font-bold text-slate-800">{{ count($customerOrders ?? []) }} Outbound Orders</span>
                    </div>
                </div>
            </div>

            <!-- KPI CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">TOTAL SHIPMENTS</span>
                    <div class="text-2xl font-extrabold text-slate-900 mt-1 font-mono">Database Connected</div>
                    <span class="text-[11px] font-semibold text-emerald-600 mt-1.5 block">Synchronized from MySQL</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">DELAYED</span>
                    <div class="text-2xl font-extrabold text-slate-900 mt-1 font-mono" id="kpi-delayed">0</div>
                    <span class="text-[11px] font-semibold text-amber-600 mt-1.5 block">Requires active response</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">FUEL EFFICIENCY</span>
                    <div class="text-2xl font-extrabold text-slate-900 mt-1">6.7 <span class="text-xs font-normal text-slate-500">km/L</span></div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">TOTAL DELIVERY REVENUE/COST</span>
                    <div class="text-2xl font-extrabold text-slate-900 mt-1 font-mono">₱963,550.00</div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TAB 1: SHIPMENT SCHEDULES                  -->
            <!-- ========================================== -->
            <div id="view-schedules" class="tab-view space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                    
                    <!-- LEFT: MOCK DATA LIST WITH FILTER PILLS -->
                    <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-slate-900 text-sm">Active Shipments (Database List)</h3>

                            <div class="flex items-center bg-slate-100/90 p-1 rounded-2xl text-[11px] font-bold text-slate-500 gap-1 border border-slate-200/60">
                                <button type="button" onclick="filterShipments('all')" id="filter-btn-all" class="filter-pill-btn px-3 py-1 bg-white text-indigo-600 rounded-xl shadow-xs transition-all">All</button>
                                <button type="button" onclick="filterShipments('In Transit')" id="filter-btn-intransit" class="filter-pill-btn px-3 py-1 hover:text-slate-900 rounded-xl transition-all">In Transit</button>
                                <button type="button" onclick="filterShipments('Delayed')" id="filter-btn-delayed" class="filter-pill-btn px-3 py-1 hover:text-slate-900 rounded-xl transition-all">Delayed</button>
                                <button type="button" onclick="filterShipments('Delivered')" id="filter-btn-delivered" class="filter-pill-btn px-3 py-1 hover:text-slate-900 rounded-xl transition-all">Delivered</button>
                            </div>
                        </div>

                        <!-- ROWS CONTAINER -->
                        <div class="divide-y divide-slate-100 text-xs max-h-[400px] overflow-y-auto pr-2" id="shipments-container">
                            <!-- Populated dynamically via JavaScript -->
                        </div>
                    </div>

                    <!-- RIGHT: MAPS PREVIEW CONTAINER -->
                    <div class="lg:col-span-5 bg-indigo-50/50 p-5 rounded-2xl border border-indigo-100 flex flex-col justify-between relative overflow-hidden h-[330px]">
                        <div class="flex items-center justify-between relative z-10">
                            <span class="px-3 py-1 bg-white text-indigo-700 rounded-full text-xs font-bold border border-indigo-200 shadow-xs flex items-center gap-1">
                                Maps Preview
                            </span>
                        </div>
                        <svg class="absolute inset-0 w-full h-full p-4" viewBox="0 0 400 300" fill="none">
                            <path d="M 50 200 C 150 100, 250 120, 350 250" stroke="#3b82f6" stroke-width="5" stroke-linecap="round" />
                            <text x="50" y="190" fill="#1e293b" font-size="10" font-weight="bold">Cavite Hub</text>
                            <text x="270" y="160" fill="#1e293b" font-size="10" font-weight="bold">Regional Distribution</text>
                        </svg>
                        <button type="button" onclick="switchTab('tracking')" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition shadow-lg relative z-10 text-center">
                            Click to view interactive tracking & map
                        </button>
                    </div>

                </div>

                <!-- BOTTOM ANALYTICS ROW -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                    <!-- Items Shipped Per City -->
                    <div class="lg:col-span-6 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
                        <h3 class="font-extrabold text-slate-400 text-[10px] uppercase tracking-wider">Items Shipped Per City (Synchronized)</h3>
                        <div class="space-y-2 text-xs font-bold" id="city-items-breakdown">
                            <!-- Injected dynamically -->
                        </div>
                    </div>

                    <!-- Package Status Breakdown -->
                    <div class="lg:col-span-6 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
                        <h3 class="font-extrabold text-slate-400 text-[10px] uppercase tracking-wider">Package Status Breakdown</h3>
                        <div class="grid grid-cols-3 gap-3 text-center text-xs pt-2">
                            <div class="p-3 bg-indigo-50 border border-indigo-100 rounded-2xl">
                                <span class="text-[9px] text-indigo-500 uppercase font-bold block">In Transit</span>
                                <strong id="pkg-status-transit" class="text-indigo-900 font-mono text-lg">0</strong>
                            </div>
                            <div class="p-3 bg-amber-50 border border-amber-100 rounded-2xl">
                                <span class="text-[9px] text-amber-500 uppercase font-bold block">Delayed</span>
                                <strong id="pkg-status-delayed" class="text-amber-900 font-mono text-lg">0</strong>
                            </div>
                            <div class="p-3 bg-emerald-50 border border-emerald-100 rounded-2xl">
                                <span class="text-[9px] text-emerald-500 uppercase font-bold block">Delivered</span>
                                <strong id="pkg-status-delivered" class="text-emerald-900 font-mono text-lg">0</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TAB 2: ENHANCED DELIVERY TRACKING           -->
            <!-- ========================================== -->
            <div id="view-tracking" class="tab-view space-y-6 hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <div class="lg:col-span-5 space-y-4">
                        <div class="flex items-center gap-2">
                            <div class="relative flex-1">
                                <input type="text" id="tracking-search-input" onkeyup="searchTrackingCards()" placeholder="Search OrderID or Name..." class="w-full pl-9 pr-8 py-2.5 bg-white border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-xs">
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>

                        <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2" id="tracking-cards-container">
                            <!-- Populated dynamically -->
                        </div>
                    </div>

                    <div class="lg:col-span-7 bg-[#11192e] rounded-3xl border border-slate-800 relative overflow-hidden h-[580px] shadow-2xl p-6 text-white">
                        <div id="tracking-map-shell" class="w-full h-full"></div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TAB 3: SHIPPING ROUTES & STATUS UPDATER     -->
            <!-- ========================================== -->
            <div id="view-routes" class="tab-view space-y-6 hidden">
                <div class="grid grid-cols-1 xl:grid-cols-[1.1fr_0.9fr] gap-6">
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden p-5 space-y-4">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">Live Shipment Route Network</h3>
                                <p class="text-xs text-slate-500 mt-1">Tap a lane or route card to inspect the current status, estimated arrival, and carrier notes.</p>
                            </div>
                            <div class="text-right">
                                <div id="route-count-badge" class="text-[11px] font-extrabold text-slate-900">0 active routes</div>
                                <div class="text-[10px] text-slate-400 uppercase tracking-wider">Interactive map</div>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-950 p-3">
                            <svg id="route-map-svg" viewBox="0 0 400 240" class="w-full h-[280px]"></svg>
                        </div>

                        <div id="route-legend" class="flex flex-wrap gap-2 text-[10px] text-slate-500"></div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-5">
                            <h4 class="text-sm font-extrabold text-slate-900">Selected Route</h4>
                            <div id="selected-route-card" class="mt-4 rounded-2xl border border-slate-100 bg-slate-50 p-4 min-h-[140px]"></div>
                        </div>

                        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-5">
                            <h4 class="text-sm font-extrabold text-slate-900">Active Route List</h4>
                            <div id="route-list" class="mt-3 space-y-2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TAB 4: TRANSPORTATION STATUS                -->
            <!-- ========================================== -->
            <div id="view-status" class="tab-view space-y-6 hidden">
                <div class="grid grid-cols-1 xl:grid-cols-[1.1fr_0.9fr] gap-6">
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h2 class="text-xl font-extrabold text-slate-900">Transportation Status Overview</h2>
                                <p class="text-xs text-slate-500 mt-1">Operational view of all live shipments, vehicle readiness, and current delivery status.</p>
                            </div>
                            <span id="status-summary-pill" class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-extrabold uppercase tracking-wider"></span>
                        </div>
                        <div id="status-list" class="space-y-3"></div>
                    </div>

                    <div class="bg-slate-950 text-white p-6 rounded-3xl border border-slate-800 shadow-xs space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-400">Fleet snapshot</h3>
                            <span class="rounded-full border border-emerald-500/30 bg-emerald-500/10 px-2.5 py-1 text-[10px] font-semibold text-emerald-300">Live</span>
                        </div>
                        <div id="status-summary-grid" class="grid grid-cols-2 gap-3"></div>
                        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-3 text-xs text-slate-300">
                            <div class="font-semibold text-white">Dispatch readiness</div>
                            <div class="mt-2 flex items-center justify-between">
                                <span>Last checkpoint sync</span>
                                <span id="fleet-sync-time" class="font-mono text-emerald-300">--</span>
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <span>Active vehicles</span>
                                <span id="fleet-active-count" class="font-mono text-indigo-300">0</span>
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
        <form id="addShipmentForm" onsubmit="handleAddShipment(event)" class="space-y-3 text-xs font-semibold text-slate-600">
            <div>
                <label class="block mb-1">Order ID</label>
                <input id="add-order-id" type="text" required placeholder="ORD-151" class="w-full p-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            <div>
                <label class="block mb-1">Client Name</label>
                <input id="add-client-name" type="text" required placeholder="John Doe" class="w-full p-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            <div>
                <label class="block mb-1">Product</label>
                <input id="add-product" type="text" required placeholder="Smart Sensor" class="w-full p-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block mb-1">Amount</label>
                    <input id="add-amount" type="text" required placeholder="₱10,000.00" class="w-full p-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block mb-1">Items</label>
                    <input id="add-items" type="number" required min="1" value="1" class="w-full p-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block mb-1">City</label>
                    <input id="add-city" type="text" required placeholder="Manila" class="w-full p-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block mb-1">Status</label>
                    <select id="add-status" class="w-full p-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="In Transit">In Transit</option>
                        <option value="Delayed">Delayed</option>
                        <option value="Delivered">Delivered</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('addModal')" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl font-bold">Cancel</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-bold shadow-xs">Save Dispatch</button>
            </div>
        </form>
    </div>
</div>

<!-- STATUS UPDATE MODAL (PENCIL ICON EDIT) -->
<div id="statusUpdateModal" class="fixed inset-0 z-50 modal-overlay flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-sm p-6 relative space-y-4">
        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
            <h3 class="text-sm font-extrabold text-slate-900">Update Delivery Status</h3>
            <button type="button" onclick="closeModal('statusUpdateModal')" class="text-slate-400 hover:text-slate-700 font-bold">✕</button>
        </div>

        <form id="statusUpdateForm" onsubmit="handleStatusUpdate(event)" class="space-y-3 text-xs font-semibold text-slate-700">
            <div>
                <label class="block mb-1 text-slate-400 uppercase text-[10px]">Order ID</label>
                <input type="text" id="modal-order-id" readonly class="w-full p-2 bg-slate-100 border border-slate-200 rounded-xl font-mono text-slate-800">
            </div>

            <div>
                <label class="block mb-1 text-slate-400 uppercase text-[10px]">Select New Status</label>
                <select id="modal-status-select" class="w-full p-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    <option value="In Transit">In Transit</option>
                    <option value="Delayed">Delayed</option>
                    <option value="Delivered">Delivered</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('statusUpdateModal')" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl font-bold">Cancel</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-bold shadow-xs">Save Changes</button>
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
        <button type="button" onclick="closeFilterModal(); alert('Filter applied successfully!');" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl transition">Apply Filter</button>
    </div>
</div>

<!-- JAVASCRIPT CONNECTED TO DATABASE VIA @json($shipments) -->
<script>
    function buildDemoShipments(baseShipments) {
        const sampleShipments = [
            { orderID: 'ORD-108', Name: 'Rina Cruz', product: 'Wireless Router', amount: '₱8,200.00', items: 3, total: '₱24,600.00', city: 'Bulacan', status: 'In Transit' },
            { orderID: 'ORD-109', Name: 'Lito Garcia', product: 'Smart Sensor Kit', amount: '₱11,400.00', items: 5, total: '₱57,000.00', city: 'Laguna', status: 'Delayed' },
            { orderID: 'ORD-110', Name: 'Sofia Tan', product: 'Industrial Tablet', amount: '₱14,900.00', items: 2, total: '₱29,800.00', city: 'Batangas', status: 'Delivered' },
            { orderID: 'ORD-111', Name: 'Mika Reyes', product: 'Portable Scanner', amount: '₱6,300.00', items: 4, total: '₱25,200.00', city: 'Manila', status: 'In Transit' },
            { orderID: 'ORD-112', Name: 'Jules Navarro', product: 'Thermal Printer', amount: '₱9,700.00', items: 6, total: '₱58,200.00', city: 'Cavite', status: 'Delayed' },
            { orderID: 'ORD-113', Name: 'Ava Lim', product: 'Docking Station', amount: '₱7,600.00', items: 3, total: '₱22,800.00', city: 'Bulacan', status: 'In Transit' }
        ];

        return [
            ...baseShipments,
            ...sampleShipments.filter(sample => !baseShipments.some(existing => existing.orderID === sample.orderID))
        ];
    }

    const activeShipments = buildDemoShipments(@json($shipments));

    function hangUpSimulatedCall() {
        const overlay = document.getElementById('simulated-call-overlay');
        if (overlay) {
            overlay.classList.add('hidden');
        }
    }

    function globalDashboardSearch() {
        const query = (document.getElementById('global-search-input')?.value || '').toLowerCase().trim();
        const rows = document.querySelectorAll('.shipment-row');
        const cards = document.querySelectorAll('.tracking-card');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.classList.toggle('hidden', query && !text.includes(query));
        });

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.classList.toggle('hidden', query && !text.includes(query));
        });
    }

    function renderDashboardData() {
        const containerSchedules = document.getElementById('shipments-container');
        const containerTracking = document.getElementById('tracking-cards-container');
        const tableLedger = document.getElementById('ledger-table-tbody');
        
        if (containerSchedules) containerSchedules.innerHTML = '';
        if (containerTracking) containerTracking.innerHTML = '';
        if (tableLedger) tableLedger.innerHTML = '';

        let transitCount = 0;
        let delayedCount = 0;
        let deliveredCount = 0;
        let cityItemsCount = { Cavite: 0, Laguna: 0, Batangas: 0, Manila: 0, Bulacan: 0 };

        activeShipments.forEach(s => {
            if(s.status === 'In Transit') transitCount++;
            else if(s.status === 'Delayed') delayedCount++;
            else if(s.status === 'Delivered') deliveredCount++;

            if(cityItemsCount[s.city] !== undefined) {
                cityItemsCount[s.city] += parseInt(s.items);
            }

            let badgeColor = s.status === 'Delivered' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : (s.status === 'Delayed' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-indigo-50 text-indigo-700 border-indigo-200');

            if (containerSchedules) {
                containerSchedules.innerHTML += `
                    <div class="shipment-row py-3 flex items-center justify-between group transition-all cursor-pointer hover:bg-indigo-50/30 px-2 rounded-xl" data-status="${s.status}">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full ${s.status === 'Delivered' ? 'bg-emerald-500' : 'bg-indigo-500'}"></span>
                            <div>
                                <span class="font-bold font-mono text-slate-900 block text-xs">#${s.orderID}</span>
                                <span class="text-slate-400 font-medium text-[11px]">${s.Name} (${s.city})</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <span class="font-bold text-slate-800 block text-xs">${s.product}</span>
                            <span class="text-slate-400 font-medium text-[11px]">${s.total}</span>
                        </div>
                        <div class="text-right">
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold inline-block uppercase ${badgeColor}">
                                ${s.status}
                            </span>
                        </div>
                    </div>
                `;
            }

            if (containerTracking) {
                containerTracking.innerHTML += `
                    <div class="tracking-card p-4 rounded-3xl border ${selectedTrackingShipmentId === s.orderID ? 'border-indigo-400 ring-2 ring-indigo-200 bg-indigo-50/70' : 'border-slate-200 bg-white'} space-y-3 shadow-xs hover:border-indigo-400 transition-all cursor-pointer group" data-code="${s.orderID}" data-driver="${s.Name}" onclick="selectTrackingShipment('${s.orderID}')">
                        <div class="flex justify-between items-center">
                            <span class="font-extrabold text-slate-900 text-sm font-mono">#${s.orderID}</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase border tracking-wider ${badgeColor}">${s.status}</span>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                            <div>
                                <p class="font-bold text-slate-900 text-xs">${s.Name} - ${s.product}</p>
                                <p class="text-[9px] text-slate-400 font-bold uppercase">City: ${s.city} | Total: ${s.total}</p>
                            </div>
                            <button type="button" onclick="event.stopPropagation(); openStatusModal('${s.orderID}')" class="p-1.5 bg-slate-50 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 rounded-xl transition border border-slate-200/60 shadow-xs" title="Edit Status">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                        </div>
                    </div>
                `;
            }

            if (tableLedger) {
                tableLedger.innerHTML += `
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3 px-2 font-bold font-mono text-indigo-600">#${s.orderID}</td>
                        <td class="py-3 px-2 font-semibold text-slate-900">${s.Name}</td>
                        <td class="py-3 px-2">${s.product}</td>
                        <td class="py-3 px-2 font-mono">${s.amount}</td>
                        <td class="py-3 px-2 font-mono">${s.items}</td>
                        <td class="py-3 px-2 font-mono font-bold text-emerald-600">${s.total}</td>
                        <td class="py-3 px-2">${s.city}</td>
                        <td class="py-3 px-2">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase ${badgeColor}">${s.status}</span>
                        </td>
                        <td class="py-3 px-2">
                            <button type="button" onclick="openStatusModal('${s.orderID}')" class="px-2.5 py-1 bg-indigo-600 text-white rounded text-[11px] font-semibold hover:bg-indigo-700">Edit</button>
                        </td>
                    </tr>
                `;
            }
        });

        const transitEl = document.getElementById('pkg-status-transit');
        const delayedEl = document.getElementById('pkg-status-delayed');
        const deliveredEl = document.getElementById('pkg-status-delivered');
        const delayedKpiEl = document.getElementById('kpi-delayed');

        if (transitEl) transitEl.innerText = transitCount;
        if (delayedEl) delayedEl.innerText = delayedCount;
        if (deliveredEl) deliveredEl.innerText = deliveredCount;
        if (delayedKpiEl) delayedKpiEl.innerText = delayedCount;

        const cityContainer = document.getElementById('city-items-breakdown');
        if (cityContainer) {
            cityContainer.innerHTML = '';
            for (const [city, count] of Object.entries(cityItemsCount)) {
                cityContainer.innerHTML += `
                    <div class="bg-slate-50 p-2.5 rounded-xl flex justify-between border border-slate-100">
                        <span>${city}</span>
                        <span class="text-indigo-600 font-mono font-bold">${count} Items Shipped</span>
                    </div>
                `;
            }
        }

        renderTrackingMap();
        renderRouteView();
        renderStatusView();
    }

    function setFilterButtonState(category) {
        const normalized = category.toLowerCase();
        document.querySelectorAll('.filter-pill-btn').forEach(button => {
            const buttonId = button.id || '';
            const isActive = normalized === 'all'
                ? buttonId === 'filter-btn-all'
                : buttonId === `filter-btn-${normalized.replace(/\s+/g, '')}`;

            button.classList.toggle('bg-white', isActive);
            button.classList.toggle('text-indigo-600', isActive);
            button.classList.toggle('shadow-xs', isActive);
            button.classList.toggle('rounded-xl', true);
        });
    }

    let selectedRouteId = null;
    let selectedTrackingShipmentId = null;

    function renderTrackingMap() {
        const shell = document.getElementById('tracking-map-shell');
        if (!shell) return;

        const positions = [
            { x: 70, y: 180 },
            { x: 175, y: 130 },
            { x: 245, y: 160 },
            { x: 320, y: 110 },
            { x: 145, y: 70 },
            { x: 290, y: 190 },
            { x: 120, y: 140 },
            { x: 225, y: 200 },
            { x: 335, y: 150 },
            { x: 205, y: 95 },
            { x: 95, y: 95 },
            { x: 265, y: 120 }
        ];

        const points = activeShipments.map((shipment, index) => {
            const position = positions[index % positions.length];
            return {
                ...shipment,
                ...position,
                statusColor: shipment.status === 'Delayed' ? '#f59e0b' : shipment.status === 'Delivered' ? '#10b981' : '#818cf8'
            };
        });

        const selectedShipment = points.find(point => point.orderID === selectedTrackingShipmentId) || points[0];
        if (selectedTrackingShipmentId === null && selectedShipment) {
            selectedTrackingShipmentId = selectedShipment.orderID;
        }

        shell.innerHTML = `
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-indigo-400 text-xs font-extrabold uppercase tracking-widest block">Live GPS Tracking Map</span>
                        <h3 class="text-xl font-bold">Interactive Telemetry Active</h3>
                    </div>
                    <div class="text-right text-[11px] text-slate-400">
                        <div class="font-bold text-white">${points.length} active routes</div>
                        <div>Tap a marker to inspect</div>
                    </div>
                </div>
                <div class="mt-4 flex-1 rounded-3xl border border-slate-800 bg-gradient-to-br from-slate-950 to-indigo-950 p-3">
                    <svg viewBox="0 0 400 280" class="w-full h-full">
                        <rect x="20" y="20" width="360" height="240" rx="24" fill="#0f172a" stroke="#334155" stroke-width="1"></rect>
                        <path d="M 70 180 C 120 150, 170 120, 220 140 S 300 180, 340 115" stroke="#475569" stroke-width="2" stroke-dasharray="4 4" fill="none"></path>
                        <path d="M 70 180 C 115 190, 150 205, 190 170 S 290 135, 330 170" stroke="#334155" stroke-width="2" fill="none"></path>
                        ${points.map(point => `
                            <circle class="tracking-marker cursor-pointer" data-tracking-id="${point.orderID}" cx="${point.x}" cy="${point.y}" r="11" fill="${point.statusColor}" stroke="#fff" stroke-width="2"></circle>
                        `).join('')}
                    </svg>
                </div>
                <div class="mt-3 rounded-2xl border border-slate-800 bg-slate-900/70 p-3 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <div class="font-extrabold text-white">${selectedShipment ? `#${selectedShipment.orderID}` : 'No selection'}</div>
                            <div class="text-xs text-slate-400">${selectedShipment ? `${selectedShipment.Name} • ${selectedShipment.city}` : 'Select a shipment marker'}</div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase ${selectedShipment && selectedShipment.status === 'Delayed' ? 'bg-amber-100 text-amber-700' : selectedShipment && selectedShipment.status === 'Delivered' ? 'bg-emerald-100 text-emerald-700' : 'bg-indigo-100 text-indigo-700'}">${selectedShipment ? selectedShipment.status : 'Idle'}</span>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-2 text-[11px] text-slate-300">
                        <div class="rounded-xl bg-slate-800/80 p-2">
                            <div class="text-[10px] uppercase tracking-wider text-slate-400">Route</div>
                            <div class="font-semibold text-white mt-1">${selectedShipment ? `${selectedShipment.city} corridor` : 'Awaiting selection'}</div>
                        </div>
                        <div class="rounded-xl bg-slate-800/80 p-2">
                            <div class="text-[10px] uppercase tracking-wider text-slate-400">ETA</div>
                            <div class="font-semibold text-white mt-1">${selectedShipment ? (selectedShipment.status === 'Delivered' ? 'Completed' : selectedShipment.status === 'Delayed' ? '45 min delay' : '2.5 hrs') : '--'}</div>
                        </div>
                    </div>
                    <div class="mt-2 rounded-xl border border-slate-700 bg-slate-950/70 p-2 text-[11px] text-slate-300">
                        <div class="text-[10px] uppercase tracking-wider text-slate-400">Delivery pulse</div>
                        <div class="mt-1 text-slate-200">${selectedShipment ? (selectedShipment.status === 'Delayed' ? 'Traffic hold detected; rerouting to preserve delivery window.' : selectedShipment.status === 'Delivered' ? 'Package completed and handed over to receiver.' : 'Vehicle is en route with geofence and temperature monitoring active.') : 'Select a shipment to inspect its live status.'}</div>
                    </div>
                </div>
            </div>
        `;

        shell.querySelectorAll('.tracking-marker').forEach(marker => {
            marker.addEventListener('click', () => {
                selectedTrackingShipmentId = marker.getAttribute('data-tracking-id');
                renderTrackingMap();
            });
        });
    }

    function selectTrackingShipment(orderID) {
        selectedTrackingShipmentId = orderID;
        renderDashboardData();
    }

    function renderRouteView() {
        const routeList = document.getElementById('route-list');
        const routeMap = document.getElementById('route-map-svg');
        const routeCard = document.getElementById('selected-route-card');
        const routeLegend = document.getElementById('route-legend');
        const countBadge = document.getElementById('route-count-badge');
        if (!routeList || !routeMap || !routeCard || !routeLegend || !countBadge) return;

        const routeNodes = {
            'Cavite Hub': { x: 70, y: 180 },
            Cavite: { x: 100, y: 174 },
            Laguna: { x: 165, y: 145 },
            Batangas: { x: 240, y: 158 },
            Manila: { x: 305, y: 112 },
            Bulacan: { x: 325, y: 160 }
        };

        const routes = activeShipments.map((shipment, index) => {
            const destination = shipment.city || 'Manila';
            const from = routeNodes['Cavite Hub'];
            const to = routeNodes[destination] || routeNodes.Manila;
            const progress = shipment.status === 'Delivered' ? 100 : shipment.status === 'Delayed' ? 72 : 86;
            const eta = shipment.status === 'Delivered' ? 'Completed' : shipment.status === 'Delayed' ? '2h delay' : `${Math.max(2, 5 - index)}h left`;
            const lane = `${shipment.city || 'Metro'} route`;

            return {
                id: shipment.orderID,
                lane,
                eta,
                progress,
                customer: shipment.Name,
                status: shipment.status,
                product: shipment.product,
                from,
                to,
                path: index % 2 === 0
                    ? `M ${from.x} ${from.y} C ${from.x + 40} ${from.y - 30}, ${to.x - 45} ${to.y - 25}, ${to.x} ${to.y}`
                    : `M ${from.x} ${from.y} C ${from.x + 25} ${from.y + 25}, ${to.x - 25} ${to.y + 25}, ${to.x} ${to.y}`
            };
        });

        countBadge.innerText = `${routes.length} active routes`;
        routeLegend.innerHTML = [
            '<span class="px-2.5 py-1 rounded-full border border-emerald-200 bg-emerald-50 text-emerald-700">On-time lanes</span>',
            '<span class="px-2.5 py-1 rounded-full border border-amber-200 bg-amber-50 text-amber-700">Delayed lanes</span>',
            '<span class="px-2.5 py-1 rounded-full border border-indigo-200 bg-indigo-50 text-indigo-700">In transit lanes</span>'
        ].join('');

        const mapMarkup = `
            <rect x="0" y="0" width="400" height="240" rx="24" fill="#0f172a"></rect>
            <rect x="20" y="20" width="360" height="200" rx="20" stroke="#334155" stroke-width="1" fill="transparent"></rect>
            <path d="M 40 200 C 110 150, 170 190, 220 155 S 330 110, 360 90" stroke="#475569" stroke-width="2" stroke-dasharray="4 4" fill="none"></path>
            ${routes.map(route => `<path d="${route.path}" stroke="${route.status === 'Delayed' ? '#f59e0b' : route.status === 'Delivered' ? '#10b981' : '#818cf8'}" stroke-width="4" stroke-linecap="round" fill="none" opacity="0.9"></path>`).join('')}
            <circle cx="70" cy="180" r="10" fill="#38bdf8"></circle>
            <circle cx="305" cy="112" r="10" fill="#38bdf8"></circle>
            ${routes.map(route => `<circle class="route-node cursor-pointer" data-route-id="${route.id}" cx="${route.to.x}" cy="${route.to.y}" r="8" fill="${route.status === 'Delayed' ? '#f59e0b' : route.status === 'Delivered' ? '#10b981' : '#818cf8'}" stroke="#fff" stroke-width="2"></circle>`).join('')}
        `;

        if (routeMap) routeMap.innerHTML = mapMarkup;
        if (routeList) routeList.innerHTML = routes.map(route => `
            <button type="button" data-route-select="${route.id}" onclick="selectRoute('${route.id}')" class="w-full rounded-2xl border ${route.id === selectedRouteId ? 'border-indigo-400 bg-indigo-50 text-indigo-700' : 'border-slate-200 bg-white text-slate-700'} p-3 text-left transition">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <div class="text-[11px] font-extrabold uppercase tracking-wider">${route.lane}</div>
                        <div class="text-[11px] font-medium mt-1">${route.customer}</div>
                    </div>
                    <span class="text-[10px] font-extrabold px-2.5 py-1 rounded-full ${route.status === 'Delayed' ? 'bg-amber-100 text-amber-700' : route.status === 'Delivered' ? 'bg-emerald-100 text-emerald-700' : 'bg-indigo-100 text-indigo-700'}">${route.status}</span>
                </div>
            </button>
        `).join('');

        if (routeMap) {
            routeMap.querySelectorAll('.route-node').forEach(node => {
                node.addEventListener('click', () => selectRoute(node.getAttribute('data-route-id')));
            });
        }

        const firstRoute = routes[0];
        selectRoute(firstRoute ? firstRoute.id : null);
    }

    function selectRoute(routeId) {
        selectedRouteId = routeId;
        const route = activeShipments.find(shipment => shipment.orderID === routeId);
        const routeCard = document.getElementById('selected-route-card');
        if (!routeCard || !route) return;

        const progress = route.status === 'Delivered' ? 100 : route.status === 'Delayed' ? 72 : 86;
        if (routeCard) routeCard.innerHTML = `
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Route detail</div>
                        <div class="text-base font-extrabold text-slate-900">${route.city || 'Metro'} delivery lane</div>
                    </div>
                    <span class="text-[10px] font-extrabold px-2.5 py-1 rounded-full ${route.status === 'Delayed' ? 'bg-amber-100 text-amber-700' : route.status === 'Delivered' ? 'bg-emerald-100 text-emerald-700' : 'bg-indigo-100 text-indigo-700'}">${route.status}</span>
                </div>
                <div class="grid grid-cols-2 gap-3 text-xs text-slate-600">
                    <div class="rounded-xl bg-white p-3 border border-slate-200">
                        <div class="text-[10px] uppercase tracking-wider text-slate-400">Customer</div>
                        <div class="font-bold text-slate-900 mt-1">${route.Name}</div>
                    </div>
                    <div class="rounded-xl bg-white p-3 border border-slate-200">
                        <div class="text-[10px] uppercase tracking-wider text-slate-400">Distance</div>
                        <div class="font-bold text-slate-900 mt-1">${Math.round(70 + (activeShipments.findIndex(item => item.orderID === route.orderID) * 10))} km</div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between text-[11px] font-semibold text-slate-500">
                        <span>Route progress</span>
                        <span>${progress}%</span>
                    </div>
                    <div class="mt-1 h-2 rounded-full bg-slate-200 overflow-hidden">
                        <div class="h-full rounded-full bg-indigo-600" style="width: ${progress}%"></div>
                    </div>
                </div>
                <div class="rounded-xl bg-slate-900 text-white p-3 text-xs">
                    <div class="font-semibold">Cavite Hub → ${route.city || 'Metro'} • ${route.product}</div>
                    <div class="text-slate-400 mt-1">Driver notes: ${route.status === 'Delayed' ? 'Traffic hold and fuel stop' : 'On schedule with a live geofence check'}.</div>
                </div>
            </div>
        `;

        document.querySelectorAll('[data-route-select]').forEach(button => {
            const isActive = button.getAttribute('data-route-select') === routeId;
            button.classList.toggle('border-indigo-400', isActive);
            button.classList.toggle('bg-indigo-50', isActive);
            button.classList.toggle('text-indigo-700', isActive);
            button.classList.toggle('border-slate-200', !isActive);
            button.classList.toggle('bg-white', !isActive);
            button.classList.toggle('text-slate-700', !isActive);
        });
    }

    function renderStatusView() {
        const statusList = document.getElementById('status-list');
        const summaryPill = document.getElementById('status-summary-pill');
        const summaryGrid = document.getElementById('status-summary-grid');
        const fleetSyncTime = document.getElementById('fleet-sync-time');
        const fleetActiveCount = document.getElementById('fleet-active-count');
        if (!statusList || !summaryPill || !summaryGrid) return;

        const transitCount = activeShipments.filter(item => item.status === 'In Transit').length;
        const delayedCount = activeShipments.filter(item => item.status === 'Delayed').length;
        const deliveredCount = activeShipments.filter(item => item.status === 'Delivered').length;
        const activeVehicles = activeShipments.length;
        const readyVehicles = Math.max(1, activeVehicles - delayedCount);

        summaryPill.innerText = `${transitCount} live shipments`;
        summaryGrid.innerHTML = `
            <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-3">
                <div class="text-[10px] uppercase tracking-wider text-slate-400">In transit</div>
                <div class="text-xl font-extrabold mt-1">${transitCount}</div>
            </div>
            <div class="rounded-2xl border border-amber-800 bg-amber-500/10 p-3">
                <div class="text-[10px] uppercase tracking-wider text-amber-300">Delayed</div>
                <div class="text-xl font-extrabold mt-1">${delayedCount}</div>
            </div>
            <div class="rounded-2xl border border-emerald-800 bg-emerald-500/10 p-3 col-span-2">
                <div class="text-[10px] uppercase tracking-wider text-emerald-300">Delivered</div>
                <div class="text-xl font-extrabold mt-1">${deliveredCount}</div>
            </div>
            <div class="rounded-2xl border border-indigo-800 bg-indigo-500/10 p-3">
                <div class="text-[10px] uppercase tracking-wider text-indigo-300">Ready vehicles</div>
                <div class="text-xl font-extrabold mt-1">${readyVehicles}</div>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-3">
                <div class="text-[10px] uppercase tracking-wider text-slate-400">Priority lanes</div>
                <div class="text-xl font-extrabold mt-1">${Math.max(1, delayedCount + 1)}</div>
            </div>
        `;

        if (fleetSyncTime) fleetSyncTime.innerText = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        if (fleetActiveCount) fleetActiveCount.innerText = activeVehicles;

        statusList.innerHTML = activeShipments.map(shipment => {
            const progress = shipment.status === 'Delivered' ? 100 : shipment.status === 'Delayed' ? 68 : 84;
            const badgeClass = shipment.status === 'Delivered' ? 'bg-emerald-100 text-emerald-700' : shipment.status === 'Delayed' ? 'bg-amber-100 text-amber-700' : 'bg-indigo-100 text-indigo-700';
            return `
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="text-[11px] font-extrabold text-slate-900">#${shipment.orderID}</div>
                            <div class="text-xs text-slate-500 mt-1">${shipment.Name} • ${shipment.city}</div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase ${badgeClass}">${shipment.status}</span>
                    </div>
                    <div class="mt-3">
                        <div class="flex items-center justify-between text-[11px] text-slate-500">
                            <span>${shipment.product}</span>
                            <span>${progress}% complete</span>
                        </div>
                        <div class="mt-1 h-2 rounded-full bg-slate-200 overflow-hidden">
                            <div class="h-full rounded-full ${shipment.status === 'Delayed' ? 'bg-amber-500' : shipment.status === 'Delivered' ? 'bg-emerald-500' : 'bg-indigo-600'}" style="width: ${progress}%"></div>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-[10px] uppercase tracking-wider text-slate-400">
                        <span>Next checkpoint</span>
                        <span>${shipment.city}</span>
                    </div>
                </div>
            `;
        }).join('');
    }

    function switchTab(tabId) {
        document.querySelectorAll('.tab-view').forEach(view => view.classList.add('hidden'));
        const targetView = document.getElementById(`view-${tabId}`);
        if (targetView) targetView.classList.remove('hidden');

        const url = new URL(window.location.href);
        if (tabId) {
            url.searchParams.set('tab', tabId);
        } else {
            url.searchParams.delete('tab');
        }
        window.history.replaceState({}, '', url);
        updateSidebarHighlight(tabId);
    }

    function handleSidebarTabClick(event) {
        const tab = event.currentTarget?.getAttribute('data-logistics-tab');
        if (!tab) {
            return;
        }

        event.preventDefault();
        switchTab(tab);
    }

    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    function openFilterModal() { document.getElementById('filterModal').classList.remove('hidden'); }
    function closeFilterModal() { document.getElementById('filterModal').classList.add('hidden'); }

    function handleAddShipment(event) {
        event.preventDefault();

        const payload = {
            orderID: document.getElementById('add-order-id').value.trim(),
            Name: document.getElementById('add-client-name').value.trim(),
            product: document.getElementById('add-product').value.trim(),
            amount: document.getElementById('add-amount').value.trim(),
            items: parseInt(document.getElementById('add-items').value, 10) || 1,
            total: `₱${((parseInt(document.getElementById('add-items').value, 10) || 1) * 12000).toLocaleString('en-PH')}.00`,
            city: document.getElementById('add-city').value.trim(),
            status: document.getElementById('add-status').value
        };

        fetch('/logistics/shipments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                activeShipments.unshift(payload);
                closeModal('addModal');
                document.getElementById('addShipmentForm').reset();
                renderDashboardData();
                alert(`Shipment ${payload.orderID} was added successfully.`);
            }
        })
        .catch(error => {
            console.error('Error adding shipment:', error);
            alert('Unable to save shipment right now.');
        });
    }

    function downloadLogisticsReport() {
        alert('Generating and downloading full Logistics ERP Report CSV with Database Records...');
    }

    function filterShipments(category) {
        setFilterButtonState(category);
        const rows = document.querySelectorAll('.shipment-row');
        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            const isVisible = category === 'all' || status.toLowerCase() === category.toLowerCase();
            row.classList.toggle('hidden', !isVisible);
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

    let selectedOrderId = null;
    function openStatusModal(orderID) {
        selectedOrderId = orderID;
        document.getElementById('modal-order-id').value = orderID;
        openModal('statusUpdateModal');
    }

    function handleStatusUpdate(event) {
        event.preventDefault();
        const newStatus = document.getElementById('modal-status-select').value;
        
        fetch(`/logistics/shipments/${selectedOrderId}/update-status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const shipment = activeShipments.find(s => s.orderID === selectedOrderId);
                if(shipment) {
                    shipment.status = newStatus;
                }
                closeModal('statusUpdateModal');
                renderDashboardData();
                alert(`Order ${selectedOrderId} status successfully updated to ${newStatus}!`);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function updateSidebarHighlight(activeTab) {
        const normalizedTab = ['schedules', 'tracking', 'routes', 'status'].includes(activeTab || '') ? activeTab : 'schedules';

        document.querySelectorAll('[data-logistics-tab]').forEach(link => {
            const isActive = link.getAttribute('data-logistics-tab') === normalizedTab;

            link.classList.remove(
                'bg-slate-800',
                'text-white',
                'border',
                'border-slate-700/60',
                'shadow-sm',
                'text-slate-400',
                'hover:text-white',
                'bg-indigo-600/30',
                'border-indigo-500/30'
            );

            if (isActive) {
                link.classList.add('bg-slate-800', 'text-white', 'border', 'border-slate-700/60', 'shadow-sm');
                link.setAttribute('aria-current', 'page');
            } else {
                link.classList.add('text-slate-400', 'hover:text-white');
                link.removeAttribute('aria-current');
            }
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        renderDashboardData();

        document.querySelectorAll('[data-logistics-tab]').forEach(link => {
            link.addEventListener('click', handleSidebarTabClick);
        });

        const params = new URLSearchParams(window.location.search);
        const requestedTab = params.get('tab');
        const tabToShow = ['schedules', 'tracking', 'routes', 'status'].includes(requestedTab || '') ? requestedTab : 'schedules';
        switchTab(tabToShow);
        updateSidebarHighlight(tabToShow);
        setFilterButtonState('all');
    });
</script>
@endsection