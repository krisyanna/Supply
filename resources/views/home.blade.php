@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- =========================================================
         HOME DASHBOARD SECTION
         (Note: if your top navbar with the "Search everywhere" box
         and the Admin User avatar already lives in layouts.app,
         make sure IT contains the #globalSearchInput /
         #globalSearchResults / #userName elements instead of the
         ones below — don't duplicate IDs on the same page.)
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 mb-6 border-b border-slate-200">
        <div>
            <div class="flex items-center flex-wrap gap-3">
                <h1 class="text-2xl font-extrabold text-slate-900 m-0">Home Dashboard</h1>
                <span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 rounded-full px-2.5 py-1 whitespace-nowrap">
                    Welcome back, <span id="userName">Admin User!</span>
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1 mb-0" id="pageSubtitle">Overview of your supply chain, live from database.</p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            {{-- Global search --}}
            <div class="position-relative" style="width: 260px;">
                <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-full px-3 py-2 focus-within:border-indigo-300 focus-within:ring-2 focus-within:ring-indigo-100 transition">
                    <i class="fas fa-search text-slate-400 text-xs"></i>
                    <input type="text" id="globalSearchInput" class="border-0 flex-1 text-sm text-slate-700 focus:outline-none bg-transparent" placeholder="Search everywhere..." autocomplete="off">
                    <button type="button" id="globalSearchClear" class="hidden text-slate-300 hover:text-slate-500" title="Clear search">
                        <i class="fas fa-times-circle text-xs"></i>
                    </button>
                </div>
                <div id="globalSearchResults" class="hidden position-absolute bg-white border border-slate-200 rounded-xl shadow-lg mt-2 w-100 overflow-hidden" style="max-height: 320px; overflow-y: auto; z-index: 1000; right: 0;"></div>
            </div>

            {{-- Profile menu --}}
            <div class="position-relative shrink-0">
                <button type="button" id="profileMenuToggle" class="flex items-center gap-2 bg-white border border-slate-200 rounded-full pl-1.5 pr-3 py-1.5 hover:border-slate-300 transition">
                    <span class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0" id="profileInitials">AD</span>
                    <span class="d-none d-md-flex flex-column text-left" style="line-height: 1.1;">
                        <strong class="text-xs text-slate-800" id="profileName">Admin User</strong>
                        <small class="text-slate-400" style="font-size: 10px;" id="profileRole">System Admin</small>
                    </span>
                    <i class="fas fa-chevron-down text-slate-400" style="font-size: 10px;"></i>
                </button>
                <div id="profileMenuDropdown" class="hidden position-absolute bg-white border border-slate-200 rounded-xl shadow-lg mt-2 py-1 overflow-hidden" style="right: 0; width: 200px; z-index: 1000;">
                    <div class="px-3 py-2 border-bottom border-slate-100">
                        <div class="text-xs font-bold text-slate-800">Admin User</div>
                        <div class="text-[11px] text-slate-400">admin@company.com</div>
                    </div>
                    <a href="{{ Route::has('profile.show') ? route('profile.show') : (Route::has('profile.edit') ? route('profile.edit') : '#') }}" class="d-flex align-items-center gap-2 px-3 py-2 text-xs text-slate-700 hover:bg-slate-50 text-decoration-none">
                        <i class="fas fa-user text-slate-400" style="width: 14px;"></i> View Profile
                    </a>
                    <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}" class="d-flex align-items-center gap-2 px-3 py-2 text-xs text-slate-700 hover:bg-slate-50 text-decoration-none">
                        <i class="fas fa-cog text-slate-400" style="width: 14px;"></i> Account Settings
                    </a>
                    <div class="border-top border-slate-100 my-1"></div>
                    <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="m-0">
                        @csrf
                        <button type="submit" class="d-flex align-items-center gap-2 px-3 py-2 text-xs text-danger bg-transparent border-0 w-100 text-left">
                            <i class="fas fa-sign-out-alt" style="width: 14px;"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- KPI STAT CARDS — rendered entirely from JS via renderStatCards() --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-5" id="statsRow"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5" id="moduleSummaryRow">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Delivery Tracking</h3>
                    <p class="text-xs text-slate-500">Live logistics snapshot from the shipments API.</p>
                </div>
                <span id="deliveryTrackingStatus" class="text-[10px] font-semibold uppercase text-slate-400"></span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="deliveryTrackingMetrics"></div>
            <div id="deliveryTrackingList" class="space-y-3 text-sm text-slate-600"></div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Purchase Order Ledger</h3>
                    <p class="text-xs text-slate-500">Procurement ledger summary with the latest orders.</p>
                </div>
                <span id="poLedgerStatus" class="text-[10px] font-semibold uppercase text-slate-400"></span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="poLedgerMetrics"></div>
            <div id="poLedgerList" class="space-y-3 text-sm text-slate-600"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mb-5">
        <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="font-bold text-slate-900 text-sm">Inventory Overview</h3>
            <div class="flex items-center gap-6">
                <canvas id="inventoryDonut" width="190" height="190"></canvas>
                <div class="space-y-2.5 text-xs font-semibold text-slate-700" id="donutLegend"></div>
            </div>
        </div>

        <div class="lg:col-span-5 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
            <h3 class="font-bold text-slate-900 text-sm">Stock Reminders</h3>
            <table class="w-100 text-xs">
                <thead>
                    <tr class="text-left text-slate-400 uppercase text-[10px]">
                        <th class="pb-2 font-bold">Product</th>
                        <th class="pb-2 font-bold">Status</th>
                    </tr>
                </thead>
                <tbody id="stockReminderBody" class="divide-y divide-slate-100"></tbody>
            </table>
        </div>
    </div>

    {{-- =========================================================
         RECENT ACTIVITY (compact) + INVENTORY MANAGEMENT (preview)
         side by side
    ========================================================== --}}
    @php
        $inventoryPreviewLimit = 6;
        $inventoryRawItems = $items instanceof \Illuminate\Pagination\LengthAwarePaginator
            ? $items->getCollection()
            : collect($items ?? []);
        $inventoryTotalCount = $items instanceof \Illuminate\Pagination\LengthAwarePaginator
            ? ($items->total() ?? $inventoryRawItems->count())
            : $inventoryRawItems->count();
        $inventoryPreviewItems = $inventoryRawItems->take($inventoryPreviewLimit);
        $inventoryViewAllUrl = Route::has('inventory.index') ? route('inventory.index') : url('/inventory');
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mb-5 items-start">

        <!-- Recent Activity: compact, scrollable, doesn't hog space -->
        <div class="lg:col-span-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <h3 class="font-bold text-slate-900 text-sm mb-3">Recent Activity</h3>
            <div style="max-height: 260px; overflow-y: auto;">
                <table class="w-100 text-xs mb-0">
                    <thead>
                        <tr class="text-left text-slate-400 uppercase" style="font-size: 10px;">
                            <th class="font-weight-bold pb-2" style="width: 90px;">Time</th>
                            <th class="font-weight-bold pb-2">Activity</th>
                        </tr>
                    </thead>
                    <tbody id="activityBody" class="divide-y divide-slate-100"></tbody>
                </table>
            </div>
        </div>

        <!-- Inventory Management: compact preview -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-5 pb-3 border-bottom border-slate-100">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-1">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <h3 class="font-bold text-slate-900 text-sm mb-0">Inventory Management</h3>
                        <div class="position-relative" style="width: 200px;">
                            <i class="fas fa-search text-slate-400" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size: 11px;"></i>
                            <input type="text" id="inventorySearchInput" class="form-control form-control-sm rounded-pill" style="padding-left: 30px; height: 30px;" placeholder="Search items..." autocomplete="off">
                        </div>
                    </div>
                    <a href="{{ $inventoryViewAllUrl }}" id="inventoryViewAllLink" data-base-href="{{ $inventoryViewAllUrl }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 text-decoration-none whitespace-nowrap">
                        View All &rarr;
                    </a>
                </div>
                <p class="text-xs text-slate-500 mb-3">Manage product stock levels, categories, and warehouse allocations.</p>

                <!-- Filters -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <select id="inventoryCategorySelect" class="custom-select custom-select-sm rounded-pill" style="max-width: 150px;">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select id="inventoryStatusSelect" class="custom-select custom-select-sm rounded-pill" style="max-width: 150px;">
                        <option value="">All Statuses</option>
                        <option value="in_stock">In Stock</option>
                        <option value="low_stock">Low Stock</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                    <button type="button" id="inventoryFilterReset" class="btn btn-sm btn-light rounded-pill font-weight-bold px-3" title="Clear filters">
                        <i class="fas fa-undo mr-1"></i> Clear
                    </button>
                </div>
            </div>

            <!-- Compact Inventory Table -->
            <div class="table-responsive">
                <table class="w-100 text-xs mb-0">
                    <thead>
                        <tr class="text-left text-slate-400 uppercase bg-slate-50" style="font-size: 10px;">
                            <th class="font-weight-bold py-2 px-4">Item</th>
                            <th class="font-weight-bold py-2 px-4 text-right">Quantity</th>
                            <th class="font-weight-bold py-2 px-4 text-right">Unit Cost</th>
                            <th class="font-weight-bold py-2 px-4 text-center">Status</th>
                            <th class="font-weight-bold py-2 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryPreviewBody" class="divide-y divide-slate-100">
                        @forelse($inventoryPreviewItems as $item)
                            @php
                                $statusKey = ($item->quantity ?? 0) > ($item->low_stock_threshold ?? 10)
                                    ? 'in_stock'
                                    : (($item->quantity ?? 0) > 0 ? 'low_stock' : 'out_of_stock');
                                $statusMeta = [
                                    'in_stock'     => ['label' => 'In Stock', 'bg' => '#ecfdf5', 'color' => '#047857', 'border' => '#a7f3d0'],
                                    'low_stock'    => ['label' => 'Low Stock', 'bg' => '#fffbeb', 'color' => '#b45309', 'border' => '#fde68a'],
                                    'out_of_stock' => ['label' => 'Out of Stock', 'bg' => '#fff1f2', 'color' => '#be123c', 'border' => '#fecdd3'],
                                ][$statusKey];
                                $searchBlob = strtolower(($item->name ?? '') . ' ' . ($item->code ?? $item->sku ?? '') . ' ' . ($item->category->name ?? '') . ' ' . ($item->warehouse->name ?? ''));
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition" data-row
                                data-search="{{ $searchBlob }}"
                                data-category="{{ $item->category->id ?? '' }}"
                                data-status="{{ $statusKey }}">
                                <td class="py-2.5 px-4">
                                    <div class="font-weight-bold text-slate-900">{{ $item->name }}</div>
                                    <div class="text-slate-400" style="font-size: 11px;">
                                        {{ $item->code ?? $item->sku ?? '-' }} · {{ $item->category->name ?? 'General' }} · {{ $item->warehouse->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="py-2.5 px-4 text-right font-weight-bold text-slate-900">{{ number_format($item->quantity ?? 0) }}</td>
                                <td class="py-2.5 px-4 text-right text-slate-600">${{ number_format($item->unit_cost ?? $item->price ?? 0, 2) }}</td>
                                <td class="py-2.5 px-4 text-center">
                                    <span class="px-2 py-1 rounded-pill font-weight-bold text-uppercase d-inline-block" style="font-size: 10px; background: {{ $statusMeta['bg'] }}; color: {{ $statusMeta['color'] }}; border: 1px solid {{ $statusMeta['border'] }};">{{ $statusMeta['label'] }}</span>
                                </td>
                                <td class="py-2.5 px-4 text-right">
                                    @if(Route::has('inventory.edit'))
                                        <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-sm btn-link text-info p-0 mr-2" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                    @if(Route::has('inventory.destroy'))
                                        <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-slate-400">
                                    <i class="fas fa-boxes mb-2 d-block" style="font-size: 22px; color: #cbd5e1;"></i>
                                    No inventory records found.
                                </td>
                            </tr>
                        @endforelse
                        <tr id="inventoryPreviewEmptyRow" style="display:none;">
                            <td colspan="5" class="text-center py-4 text-slate-400">
                                <i class="fas fa-filter mb-2 d-block" style="font-size: 20px; color: #cbd5e1;"></i>
                                No items match your filters.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="px-5 py-3 border-top border-slate-100 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-slate-500" style="font-size: 11px;">
                    Showing {{ $inventoryPreviewItems->count() }} of {{ number_format($inventoryTotalCount) }} items
                </small>
                <a href="{{ $inventoryViewAllUrl }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 text-decoration-none">
                    View all inventory &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/chart.umd.min.js') }}"></script>
<script>
const API_BASE_URL = '';

const ENDPOINTS = {
    products: `${API_BASE_URL}/api/products`,
    sales: `${API_BASE_URL}/api/sales`,
    forecast: `${API_BASE_URL}/api/forecast-demand`,
    purchaseOrders: `${API_BASE_URL}/api/purchase-orders`,
    shipments: `${API_BASE_URL}/api/shipments`,
    warehouses: `${API_BASE_URL}/api/warehouses`
};

const ICONS = {
    box: { bg: 'bg-indigo-600', svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>' },
    orders: { bg: 'bg-sky-600', svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>' },
    shipment: { bg: 'bg-amber-500', svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>' },
    warehouse: { bg: 'bg-violet-600', svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-5 9 5v10a1 1 0 01-1 1h-4v-6H8v6H4a1 1 0 01-1-1V9z"></path></svg>' },
    growth: { bg: 'bg-slate-900', svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 17l6-6 4 4 8-8"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 7h7v7"></path></svg>' }
};

const STOCK_STATUS_MAP = {
    out_of_stock: { label: 'Out of stock', classes: 'bg-rose-50 text-rose-700 border border-rose-200' },
    low_stock:    { label: 'Low stock',    classes: 'bg-amber-50 text-amber-700 border border-amber-200' },
    overstocked:  { label: 'Overstocked',  classes: 'bg-indigo-50 text-indigo-700 border border-indigo-200' },
    restocked:    { label: 'Restocked',    classes: 'bg-emerald-50 text-emerald-700 border border-emerald-200' },
    in_stock:     { label: 'In stock',     classes: 'bg-emerald-50 text-emerald-700 border border-emerald-200' }
};

const DONUT_COLORS = {
    in_stock: '#059669', restocked: '#34d399', low_stock: '#fbbf24', out_of_stock: '#f43f5e', reserved: '#4f46e5'
};

let donutChart = null;
let globalProductsCache = [];
let globalSalesCache = [];
let globalPurchaseOrdersCache = [];
let globalShipmentsCache = [];

function getStock(product) {
    return Number(product?.current_stock ?? product?.stock ?? product?.quantity ?? 0);
}

function getSoldQty(sale) {
    return Number(sale?.quantity_sold ?? sale?.quantity ?? sale?.qty ?? 0);
}

function getProductName(product) {
    return product?.product_name || product?.name || product?.product || 'Unknown product';
}

function waitForChart(callback, retries = 20) {
    if (typeof Chart !== 'undefined') {
        callback();
    } else if (retries > 0) {
        setTimeout(() => waitForChart(callback, retries - 1), 100);
    } else {
        console.error('Chart.js never loaded after waiting.');
        const legend = document.getElementById('donutLegend');
        if (legend) {
            legend.innerHTML = `<div class="text-xs font-semibold text-rose-600">Chart library failed to load.</div>`;
        }
    }
}

async function fetchJSON(url, options = {}) {
    const res = await fetch(url, { headers: { 'Content-Type': 'application/json' }, ...options });
    if (!res.ok) throw new Error(`Request to ${url} failed with status ${res.status}`);
    return res.json();
}

function renderUser(user) {
    const el = document.getElementById('userName');
    if (el) el.textContent = (user && user.firstName) ? `${user.firstName}!` : 'Admin User!';
}

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
        if (stat.url) {
            card.classList.add('cursor-pointer', 'hover:border-slate-300');
            card.addEventListener('click', () => { window.location.href = stat.url; });
        }
        card.innerHTML = `
            <div class="w-9 h-9 ${icon.bg} rounded-xl flex items-center justify-center">${icon.svg}</div>
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">${escapeHTML(stat.label)}</span>
            <div class="text-2xl font-extrabold text-slate-900 font-mono">${escapeHTML(formatNumber(stat.value))}</div>
            <span class="text-[11px] font-semibold text-slate-500 block">${escapeHTML(stat.note || '')}</span>
        `;
        row.appendChild(card);
    });
}

function renderModuleSummaries({ shipments = [], purchaseOrders = [] }) {
    const activeShipments = shipments.filter(shipment => {
        const status = String(shipment.status || '').toLowerCase();
        return status !== 'delivered' && status !== 'completed';
    }).length;
    const delayedShipments = shipments.filter(shipment => String(shipment.status || '').toLowerCase() === 'delayed').length;
    const latestShipments = shipments.slice(0, 3);
    const totalPOs = purchaseOrders.length;
    const pendingPOs = purchaseOrders.filter(po => String(po.status || '').toLowerCase() === 'pending approval').length;
    const latestPOs = purchaseOrders.slice(0, 3);

    document.getElementById('deliveryTrackingStatus').textContent = `${activeShipments} active`;
    document.getElementById('deliveryTrackingMetrics').innerHTML = `
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Active Shipments</div>
            <div class="mt-2 text-2xl font-black text-amber-700">${activeShipments}</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Delayed Shipments</div>
            <div class="mt-2 text-2xl font-black text-rose-600">${delayedShipments}</div>
        </div>
    `;

    document.getElementById('deliveryTrackingList').innerHTML = latestShipments.length > 0
        ? latestShipments.map(shipment => `
            <div class="rounded-2xl border border-slate-200 bg-white p-3">
                <div class="font-semibold text-slate-900">${escapeHTML(shipment.orderID || shipment.id || 'Shipment')}</div>
                <div class="text-[11px] text-slate-500 mt-1">${escapeHTML(shipment.product || shipment.name || 'Unnamed')} • ${escapeHTML(shipment.city || 'Unknown city')}</div>
                <div class="mt-2 text-[11px] text-slate-600"><span class="font-semibold">Status:</span> ${escapeHTML(shipment.status || 'Unknown')}</div>
            </div>
        `).join('')
        : `<div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-slate-500">No shipments available.</div>`;

    document.getElementById('poLedgerStatus').textContent = `${totalPOs} total`;
    document.getElementById('poLedgerMetrics').innerHTML = `
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Total POs</div>
            <div class="mt-2 text-2xl font-black text-emerald-600">${totalPOs}</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Pending Approval</div>
            <div class="mt-2 text-2xl font-black text-indigo-600">${pendingPOs}</div>
        </div>
    `;

    document.getElementById('poLedgerList').innerHTML = latestPOs.length > 0
        ? latestPOs.map(po => `
            <div class="rounded-2xl border border-slate-200 bg-white p-3">
                <div class="font-semibold text-slate-900">${escapeHTML(po.po_number || `PO-${po.id}`)}</div>
                <div class="text-[11px] text-slate-500 mt-1">${escapeHTML(po.supplier || po.supplier_name || 'Unknown supplier')}</div>
                <div class="mt-2 text-[11px] text-slate-600"><span class="font-semibold">Status:</span> ${escapeHTML(po.status || 'Unknown')}</div>
            </div>
        `).join('')
        : `<div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-slate-500">No purchase orders available.</div>`;
}

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

    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded — skipping donut chart render.');
        legend.innerHTML += `<div class="text-xs font-semibold text-rose-600 mt-2">Chart library failed to load.</div>`;
        return;
    }

    const ctx = document.getElementById('inventoryDonut').getContext('2d');
    const chartData = {
        labels: segments.map(s => s.label),
        datasets: [{ data: segments.map(s => s.value), backgroundColor: segments.map(s => DONUT_COLORS[s.key] || '#94a3b8'), borderWidth: 0, cutout: '68%' }]
    };
    if (donutChart) { donutChart.data = chartData; donutChart.update(); }
    else { donutChart = new Chart(ctx, { type: 'doughnut', data: chartData, options: { responsive: false, plugins: { legend: { display: false } } } }); }
}

function renderStockReminders(data) {
    const body = document.getElementById('stockReminderBody');
    const items = (data && data.items) || [];
    if (items.length === 0) {
        body.innerHTML = `<tr><td colspan="2" class="py-6 text-center text-slate-400 italic">No stock alerts right now.</td></tr>`;
        return;
    }
    body.innerHTML = items.map(item => {
        const status = STOCK_STATUS_MAP[item.status] || { label: item.status, classes: 'bg-slate-50 text-slate-600 border border-slate-200' };
        return `<tr class="hover:bg-slate-50/80 transition">
            <td class="py-3 font-semibold text-slate-900">${escapeHTML(item.product)}</td>
            <td class="py-3"><span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase inline-block ${status.classes}">${escapeHTML(status.label)}</span></td>
        </tr>`;
    }).join('');
}

function renderRecentActivities(data) {
    const body = document.getElementById('activityBody');
    const items = (data && data.items) || [];
    if (items.length === 0) {
        body.innerHTML = `<tr><td colspan="2" class="py-6 text-center text-slate-400 italic">No recent activity.</td></tr>`;
        return;
    }
    body.innerHTML = items.map(item => `<tr class="hover:bg-slate-50/80 transition">
        <td class="py-3 text-slate-400 font-mono">${escapeHTML(item.time)}</td>
        <td class="py-3 font-medium text-slate-800">${escapeHTML(item.activity)}</td>
    </tr>`).join('');
}

function formatNumber(n) { return typeof n === 'number' ? n.toLocaleString() : n; }

function escapeHTML(str) {
    if (str === null || str === undefined) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

/* ---------------------------------------------------------
   Comprehensive Multi-Module "Search Everywhere" Logic
--------------------------------------------------------- */
function setupGlobalSearch() {
    const searchInput = document.getElementById('globalSearchInput');
    const resultsContainer = document.getElementById('globalSearchResults');
    const clearBtn = document.getElementById('globalSearchClear');

    if (!searchInput || !resultsContainer) return;

    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim().toLowerCase();

        if (clearBtn) clearBtn.classList.toggle('hidden', query.length === 0);

        if (query.length === 0) {
            resultsContainer.innerHTML = '';
            resultsContainer.classList.add('hidden');
            return;
        }

        const matchedProducts = globalProductsCache.filter(p => {
            const name = getProductName(p).toLowerCase();
            const category = String(p.category || p.type || '').toLowerCase();
            return name.includes(query) || category.includes(query);
        }).slice(0, 4);

        const matchedSales = globalSalesCache.filter(s => {
            const prodName = getProductName(s).toLowerCase();
            const time = String(s.sale_date || s.created_at || s.sold_at || '').toLowerCase();
            return prodName.includes(query) || time.includes(query);
        }).slice(0, 4);

        const modules = [
            { name: 'Home Dashboard', url: '/dashboard' },
            { name: 'Procurement & Supplier Management', url: '/procurement/suppliers' },
            { name: 'Purchase Order Management', url: '/procurement/po-management' },
            { name: 'Logistics Sub-Module', url: '/logistics' },
            { name: 'Inventory & Warehouse', url: '/inventory' }
        ];
        const matchedModules = modules.filter(m => m.name.toLowerCase().includes(query));

        if (matchedProducts.length === 0 && matchedSales.length === 0 && matchedModules.length === 0) {
            resultsContainer.innerHTML = `<div class="p-3 text-slate-400 italic text-center">No results found for "${escapeHTML(query)}"</div>`;
            resultsContainer.classList.remove('hidden');
            return;
        }

        let html = '';

        if (matchedModules.length > 0) {
            html += `<div class="px-3 py-1.5 font-bold bg-slate-100 text-slate-500 uppercase text-[10px]">Modules & Pages</div>`;
            matchedModules.forEach(m => {
                html += `<a href="${m.url}" class="p-2.5 hover:bg-slate-50 flex justify-between items-center block text-slate-700 font-medium">
                    <span>${escapeHTML(m.name)}</span>
                    <span class="text-indigo-600 text-[10px] font-bold">Go &rarr;</span>
                </a>`;
            });
        }

        if (matchedProducts.length > 0) {
            html += `<div class="px-3 py-1.5 font-bold bg-slate-100 text-slate-500 uppercase text-[10px]">Inventory Products</div>`;
            matchedProducts.forEach(p => {
                html += `<div class="p-2.5 hover:bg-slate-50 flex justify-between items-center">
                    <span class="font-semibold text-slate-800">${escapeHTML(getProductName(p))}</span>
                    <span class="text-slate-500 font-mono text-[11px]">Stock: ${escapeHTML(getStock(p))}</span>
                </div>`;
            });
        }

        if (matchedSales.length > 0) {
            html += `<div class="px-3 py-1.5 font-bold bg-slate-100 text-slate-500 uppercase text-[10px]">Sales & Transactions</div>`;
            matchedSales.forEach(s => {
                html += `<div class="p-2.5 hover:bg-slate-50 flex justify-between items-center">
                    <span class="text-slate-700">Sold ${escapeHTML(getSoldQty(s))} unit(s) of ${escapeHTML(getProductName(s))}</span>
                    <span class="text-slate-400 text-[10px]">${escapeHTML(s.sale_date || s.created_at || 'Recent')}</span>
                </div>`;
            });
        }

        resultsContainer.innerHTML = html;
        resultsContainer.classList.remove('hidden');
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.focus();
            clearBtn.classList.add('hidden');
            resultsContainer.innerHTML = '';
            resultsContainer.classList.add('hidden');
        });
    }

    searchInput.addEventListener('focus', function() {
        if (searchInput.value.trim().length > 0 && resultsContainer.innerHTML.trim().length > 0) {
            resultsContainer.classList.remove('hidden');
        }
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target) && (!clearBtn || !clearBtn.contains(e.target))) {
            resultsContainer.classList.add('hidden');
        }
    });
}

/* ---------------------------------------------------------
   Profile dropdown menu
--------------------------------------------------------- */
function setupProfileMenu() {
    const toggle = document.getElementById('profileMenuToggle');
    const dropdown = document.getElementById('profileMenuDropdown');
    if (!toggle || !dropdown) return;

    toggle.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('hidden');
    });

    dropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    document.addEventListener('click', function(e) {
        if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') dropdown.classList.add('hidden');
    });
}

/* Populate the profile menu from a user object once you have real auth data available. */
function renderProfileMenu(user) {
    const firstName = user?.firstName || user?.name || 'Admin User';
    const role = user?.role || 'System Admin';
    const email = user?.email || 'admin@company.com';
    const initials = firstName.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();

    const initialsEl = document.getElementById('profileInitials');
    const nameEl = document.getElementById('profileName');
    const roleEl = document.getElementById('profileRole');
    if (initialsEl) initialsEl.textContent = initials;
    if (nameEl) nameEl.textContent = firstName;
    if (roleEl) roleEl.textContent = role;

    const dropdown = document.getElementById('profileMenuDropdown');
    if (dropdown) {
        const nameNode = dropdown.querySelector('.font-bold');
        const emailNode = dropdown.querySelector('.text-slate-400');
        if (nameNode) nameNode.textContent = firstName;
        if (emailNode) emailNode.textContent = email;
    }
}

/* ---------------------------------------------------------
   Inventory Management preview: live client-side filtering
--------------------------------------------------------- */
function setupInventoryPreviewFilter() {
    const searchInput = document.getElementById('inventorySearchInput');
    const categorySelect = document.getElementById('inventoryCategorySelect');
    const statusSelect = document.getElementById('inventoryStatusSelect');
    const resetBtn = document.getElementById('inventoryFilterReset');
    const viewAllLink = document.getElementById('inventoryViewAllLink');
    const rows = document.querySelectorAll('#inventoryPreviewBody tr[data-row]');
    const emptyRow = document.getElementById('inventoryPreviewEmptyRow');

    if (!searchInput && !categorySelect && !statusSelect) return;

    function syncViewAllLink(query, categoryId, status) {
        if (!viewAllLink) return;
        const base = viewAllLink.dataset.baseHref || viewAllLink.getAttribute('href');
        try {
            const url = new URL(base, window.location.origin);
            query ? url.searchParams.set('search', query) : url.searchParams.delete('search');
            categoryId ? url.searchParams.set('category', categoryId) : url.searchParams.delete('category');
            status ? url.searchParams.set('status', status) : url.searchParams.delete('status');
            viewAllLink.href = url.pathname + url.search;
        } catch (err) {
            // base href wasn't a valid URL (e.g. "#") — leave it as-is
        }
    }

    function applyFilters() {
        const query = (searchInput?.value || '').trim().toLowerCase();
        const categoryId = categorySelect?.value || '';
        const status = statusSelect?.value || '';
        let anyVisible = false;

        rows.forEach(row => {
            const matchesQuery = query === '' || (row.dataset.search || '').includes(query);
            const matchesCategory = categoryId === '' || row.dataset.category === categoryId;
            const matchesStatus = status === '' || row.dataset.status === status;
            const visible = matchesQuery && matchesCategory && matchesStatus;
            row.style.display = visible ? '' : 'none';
            if (visible) anyVisible = true;
        });

        if (emptyRow) emptyRow.style.display = (rows.length > 0 && !anyVisible) ? '' : 'none';
        syncViewAllLink(query, categoryId, status);
    }

    searchInput?.addEventListener('input', applyFilters);
    categorySelect?.addEventListener('change', applyFilters);
    statusSelect?.addEventListener('change', applyFilters);

    resetBtn?.addEventListener('click', function() {
        if (searchInput) searchInput.value = '';
        if (categorySelect) categorySelect.value = '';
        if (statusSelect) statusSelect.value = '';
        applyFilters();
    });
}

async function initDashboard() {
    const subtitleEl = document.getElementById('pageSubtitle');
    if (subtitleEl) subtitleEl.textContent = 'Overview of your supply chain, live from database.';

    setupGlobalSearch();
    setupProfileMenu();
    setupInventoryPreviewFilter();
    loadDashboardData();
}

async function loadDashboardData() {
    try {
        const [productResponse, salesResponse, forecastResponse, purchaseOrderResponse, shipmentResponse, warehouseResponse] = await Promise.all([
            fetchJSON(ENDPOINTS.products),
            fetchJSON(ENDPOINTS.sales),
            fetchJSON(ENDPOINTS.forecast),
            fetchJSON(ENDPOINTS.purchaseOrders),
            fetchJSON(ENDPOINTS.shipments),
            fetchJSON(ENDPOINTS.warehouses)
        ]);

        globalProductsCache = productResponse.data || [];
        globalSalesCache = salesResponse.data || [];
        globalPurchaseOrdersCache = purchaseOrderResponse.data || [];
        globalShipmentsCache = shipmentResponse.data || [];

        const forecastData = forecastResponse.data || [];
        const latestForecast = forecastData.length > 0 ? Number(forecastData[forecastData.length - 1].growth_rate || 0) : 0;
        const totalPOs = purchaseOrderResponse.count || globalPurchaseOrdersCache.length;
        const totalWarehouses = warehouseResponse.count || 0;
        const activeShipments = globalShipmentsCache.filter(shipment => {
            const status = String(shipment.status || '').toLowerCase();
            return status !== 'delivered' && status !== 'completed';
        }).length;

        renderStatCards({
            stats: [
                { label: 'Growth Rate', value: `${latestForecast}%`, note: 'Latest forecast growth', icon: 'growth' },
                { label: 'Total POs', value: totalPOs, note: 'Connected to purchase order management', icon: 'orders', url: '/procurement/po-management' },
                { label: 'Active Shipments', value: activeShipments, note: 'Connected to logistics', icon: 'shipment', url: '/logistics' },
                { label: 'Total Warehouses', value: totalWarehouses, note: 'Connected to warehouse locations', icon: 'warehouse', url: '/inventory/warehouse-locations' }
            ]
        });

        renderModuleSummaries({ shipments: globalShipmentsCache, purchaseOrders: globalPurchaseOrdersCache });
    } catch (error) {
        console.error('Dashboard data fetch failed:', error);
        const subtitleEl = document.getElementById('pageSubtitle');
        if (subtitleEl) subtitleEl.textContent = 'Failed to load dashboard data.';
        return;
    }

    try {
        let inStock = 0;
        let low = 0;
        let out = 0;

        globalProductsCache.forEach(product => {
            const stock = getStock(product);
            if (stock === 0) out++;
            else if (stock <= 10) low++;
            else inStock++;
        });

        waitForChart(() => renderInventoryDonut({
            segments: [
                { key: "in_stock", label: "In Stock", value: inStock },
                { key: "low_stock", label: "Low Stock", value: low },
                { key: "out_of_stock", label: "Out of Stock", value: out }
            ]
        }));
    } catch (error) {
        console.error("Inventory donut failed to render:", error);
    }

    try {
        renderStockReminders({
            items: globalProductsCache
                .filter(p => getStock(p) <= 10)
                .slice(0, 5)
                .map(p => ({
                    product: getProductName(p),
                    status: getStock(p) === 0 ? "out_of_stock" : "low_stock"
                }))
        });
    } catch (error) {
        console.error("Stock reminders failed to render:", error);
    }

    try {
        renderRecentActivities({
            items: globalSalesCache
                .slice(-5)
                .reverse()
                .map(s => ({
                    time: s.sale_date || s.created_at || s.sold_at || "recent",
                    activity: `Sold ${getSoldQty(s)} item(s) — ${getProductName(s)}`
                }))
        });
    } catch (error) {
        console.error("Recent activities failed to render:", error);
    }
}

document.addEventListener('DOMContentLoaded', initDashboard);
</script>
@endpush