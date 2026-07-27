@extends('layouts.app')

@section('title', 'Home Dashboard')

@section('header')
    <div>
        <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Home Dashboard</h1>
        <p id="pageSubtitle" class="text-xs text-slate-500 font-medium">Loading dashboard…</p>
    </div>
    <div class="flex flex-wrap items-center gap-2.5">
        <div class="relative w-60">
            <input type="text" id="globalSearchInput" placeholder="Search everywhere..." class="w-full pl-8 pr-4 py-1.5 bg-slate-50 border border-slate-200 rounded-full text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            <svg class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <!-- Search Results Dropdown Container -->
            <div id="globalSearchResults" class="absolute left-0 right-0 mt-2 bg-white border border-slate-200 rounded-xl shadow-lg max-h-64 overflow-y-auto hidden z-50 text-xs divide-y divide-slate-100"></div>
        </div>
        <div class="flex items-center gap-2.5 pl-3 border-l border-slate-200">
            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center text-xs shadow-xs">
                AD
            </div>
            <div class="hidden sm:block text-left leading-tight">
                <span class="block text-xs font-bold text-slate-900">Admin User</span>
                <span class="block text-[10px] font-medium text-slate-500">System Admin</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="text-2xl font-extrabold text-slate-900">
        Welcome back, <span id="userName" class="text-indigo-600">…</span>
    </div>

    {{-- KPI STAT CARDS — rendered entirely from JS via renderStatCards() --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="statsRow"></div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="font-bold text-slate-900 text-sm">Inventory Overview</h3>
            <div class="flex items-center gap-6">
                <canvas id="inventoryDonut" width="190" height="190"></canvas>
                <div class="space-y-2.5 text-xs font-semibold text-slate-700" id="donutLegend"></div>
            </div>
        </div>

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
@endsection

@push('scripts')
<script src="{{ asset('js/chart.umd.min.js') }}"></script>
<script>
const API_BASE_URL = '';

const ENDPOINTS = {
    products: `${API_BASE_URL}/api/products`,
    sales: `${API_BASE_URL}/api/sales`
};

const ICONS = {
    box: { bg: 'bg-indigo-600', svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>' },
    orders: { bg: 'bg-sky-600', svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>' },
    shipment: { bg: 'bg-amber-500', svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>' },
    suppliers: { bg: 'bg-emerald-600', svg: '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 010 7.75"></path></svg>' }
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
        card.innerHTML = `
            <div class="w-9 h-9 ${icon.bg} rounded-xl flex items-center justify-center">${icon.svg}</div>
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">${escapeHTML(stat.label)}</span>
            <div class="text-2xl font-extrabold text-slate-900 font-mono">${escapeHTML(formatNumber(stat.value))}</div>
            <span class="text-[11px] font-semibold text-slate-500 block">${escapeHTML(stat.note || '')}</span>
        `;
        row.appendChild(card);
    });
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

        // 1. Search Products
        const matchedProducts = globalProductsCache.filter(p => {
            const name = getProductName(p).toLowerCase();
            const category = String(p.category || p.type || '').toLowerCase();
            return name.includes(query) || category.includes(query);
        }).slice(0, 4);

        // 2. Search Sales / Activities
        const matchedSales = globalSalesCache.filter(s => {
            const prodName = getProductName(s).toLowerCase();
            const time = String(s.sale_date || s.created_at || s.sold_at || '').toLowerCase();
            return prodName.includes(query) || time.includes(query);
        }).slice(0, 4);

        // 3. Search System Modules / Navigation Links as structural matches
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

        // Render Matching Modules
        if (matchedModules.length > 0) {
            html += `<div class="px-3 py-1.5 font-bold bg-slate-100 text-slate-500 uppercase text-[10px]">Modules & Pages</div>`;
            matchedModules.forEach(m => {
                html += `<a href="${m.url}" class="p-2.5 hover:bg-slate-50 flex justify-between items-center block text-slate-700 font-medium">
                    <span>${escapeHTML(m.name)}</span>
                    <span class="text-indigo-600 text-[10px] font-bold">Go &rarr;</span>
                </a>`;
            });
        }

        // Render Matching Products
        if (matchedProducts.length > 0) {
            html += `<div class="px-3 py-1.5 font-bold bg-slate-100 text-slate-500 uppercase text-[10px]">Inventory Products</div>`;
            matchedProducts.forEach(p => {
                html += `<div class="p-2.5 hover:bg-slate-50 flex justify-between items-center">
                    <span class="font-semibold text-slate-800">${escapeHTML(getProductName(p))}</span>
                    <span class="text-slate-500 font-mono text-[11px]">Stock: ${escapeHTML(getStock(p))}</span>
                </div>`;
            });
        }

        // Render Matching Sales
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

    // Hide dropdown when clicking outside
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
        const productResponse = await fetchJSON(ENDPOINTS.products);
        const salesResponse = await fetchJSON(ENDPOINTS.sales);

        globalProductsCache = productResponse.data || [];
        globalSalesCache = salesResponse.data || [];

        console.log("PRODUCT DATA:", globalProductsCache);
        console.log("SALES DATA:", globalSalesCache);
    } catch (error) {
        console.error("Dashboard data fetch failed:", error);
        document.getElementById('pageSubtitle').textContent = 'Failed to load dashboard data.';
        return;
    }

    try {
        const totalProducts = globalProductsCache.length;
        const totalSales = globalSalesCache.reduce((sum, item) => sum + getSoldQty(item), 0);
        const lowStock = globalProductsCache.filter(product => getStock(product) <= 10).length;

        renderStatCards({
            stats: [
                { label: "Total Products", value: totalProducts, note: "Products in inventory", icon: "box" },
                { label: "Total Sales", value: totalSales, note: "Units sold", icon: "orders" },
                { label: "Low Stock", value: lowStock, note: "Need attention", icon: "shipment" },
                { label: "Suppliers", value: "--", note: "From supplier module", icon: "suppliers" }
            ]
        });
    } catch (error) {
        console.error("Stat cards failed to render:", error);
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