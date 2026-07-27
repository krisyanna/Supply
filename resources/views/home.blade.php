@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-weight-bold text-gray-800 mb-1">Inventory Management</h1>
            <p class="text-muted small mb-0">Manage product stock levels, categories, and warehouse allocations.</p>
        </div>
        <div>
            <a href="{{ Route::has('inventory.create') ? route('inventory.create') : '#' }}" class="btn btn-primary btn-sm shadow-sm font-weight-bold">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add Item
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ Route::has('inventory.index') ? route('inventory.index') : url('/inventory') }}" class="form-row align-items-center">
                <div class="col-md-4 my-1">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-gray-400"></i></span>
                        </div>
                        <input type="text" name="search" class="form-control border-left-0 pl-0" placeholder="Search by code, item name..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3 my-1">
                    <select name="category" class="custom-select custom-select-sm">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 my-1">
                    <select name="status" class="custom-select custom-select-sm">
                        <option value="">All Statuses</option>
                        <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                <div class="col-md-2 my-1 d-flex">
                    <button type="submit" class="btn btn-secondary btn-sm btn-block font-weight-bold">Filter</button>
                    @if(request()->hasAny(['search', 'category', 'status']))
                        <a href="{{ Route::has('inventory.index') ? route('inventory.index') : url('/inventory') }}" class="btn btn-light btn-sm ml-2" title="Reset Filters">
                            <i class="fas fa-undo"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
    {{-- KPI STAT CARDS — rendered entirely from JS via renderStatCards() --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="statsRow"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mt-4" id="moduleSummaryRow">
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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="font-bold text-slate-900 text-sm">Inventory Overview</h3>
            <div class="flex items-center gap-6">
                <canvas id="inventoryDonut" width="190" height="190"></canvas>
                <div class="space-y-2.5 text-xs font-semibold text-slate-700" id="donutLegend"></div>
            </div>
        </div>
    </div>

    <!-- Inventory Data Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="bg-light text-muted">
                        <tr class="small text-uppercase">
                            <th class="py-3 px-4">Item Code</th>
                            <th class="py-3 px-4">Item Name</th>
                            <th class="py-3 px-4">Warehouse Location</th>
                            <th class="py-3 px-4">Category</th>
                            <th class="py-3 px-4 text-right">Quantity</th>
                            <th class="py-3 px-4 text-right">Unit Cost</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-secondary small">
                        @forelse($items as $item)
                            <tr>
                                <td class="px-4 font-weight-bold text-dark">{{ $item->code ?? $item->sku ?? '-' }}</td>
                                <td class="px-4 font-weight-bold text-primary">{{ $item->name }}</td>
                                <td class="px-4">{{ $item->warehouse->name ?? 'N/A' }}</td>
                                <td class="px-4">{{ $item->category->name ?? 'General' }}</td>
                                <td class="px-4 text-right font-weight-bold">{{ number_format($item->quantity ?? 0) }}</td>
                                <td class="px-4 text-right">${{ number_format($item->unit_cost ?? $item->price ?? 0, 2) }}</td>
                                <td class="px-4 text-center">
                                    @if(($item->quantity ?? 0) > ($item->low_stock_threshold ?? 10))
                                        <span class="badge badge-pill badge-soft-success px-3 py-1">In Stock</span>
                                    @elseif(($item->quantity ?? 0) > 0)
                                        <span class="badge badge-pill badge-soft-warning px-3 py-1">Low Stock</span>
                                    @else
                                        <span class="badge badge-pill badge-soft-danger px-3 py-1">Out of Stock</span>
                                    @endif
                                </td>
                                <td class="px-4 text-right">
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
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-boxes fa-2x mb-2 text-gray-300"></i>
                                    <p class="mb-0">No inventory records found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Safe Footer: Works for both Paginator and Collection -->
        <div class="card-footer bg-white border-0 py-3">
            @if($items instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} of {{ $items->total() ?? 0 }} entries
                    </small>
                    <div>
                        {{ $items->withQueryString()->links() }}
                    </div>
                </div>
            @else
                <small class="text-muted">Total Records: {{ $items->count() }}</small>
            @endif
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
    document.getElementById('userName').textContent = (user && user.firstName) ? `${user.firstName}!` : 'Admin User!';
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

    if (!searchInput || !resultsContainer) return;

    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim().toLowerCase();

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

        if (matchedProducts.length === 0 && matchedSales.length === 0) {
            // handled
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

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
            resultsContainer.classList.add('hidden');
        }
    });
}

async function initDashboard() {
    document.getElementById('pageSubtitle').textContent =
        'Overview of your supply chain, live from database.';

    setupGlobalSearch();
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
        document.getElementById('pageSubtitle').textContent = 'Failed to load dashboard data.';
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
