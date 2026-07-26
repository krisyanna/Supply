@extends('layouts.app')

@section('title', 'Home Dashboard')

@section('header')
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

/* ---------------------------------------------------------
   Field-mapping helpers.
   Your API returns `current_stock` on products (not `stock`)
   and `quantity_sold` on sales — centralize the lookup here
   so there's exactly one place to update if the API changes.
--------------------------------------------------------- */
function getStock(product) {
    return Number(product?.current_stock ?? product?.stock ?? product?.quantity ?? 0);
}

function getSoldQty(sale) {
    return Number(sale?.quantity_sold ?? sale?.quantity ?? sale?.qty ?? 0);
}

function getProductName(product) {
    return product?.product_name || product?.name || product?.product || 'Unknown product';
}

// Retries for up to ~2 seconds (20 x 100ms) waiting for Chart.js to finish
// loading before giving up, in case the CDN script is slow to arrive.
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
    document.getElementById('userName').textContent = (user && user.firstName) ? `${user.firstName}!` : 'there!';
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

    // Guard against Chart.js not having loaded yet (slow network, blocked CDN, etc.)
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

async function initDashboard() {
    document.getElementById('pageSubtitle').textContent =
        'Overview of your supply chain, live from database.';

    loadDashboardData();
}

async function loadDashboardData() {
    let products = [];
    let sales = [];

    // --- Fetch (if this fails, nothing below can render, so it stays in its own try/catch) ---
    try {
        const productResponse = await fetchJSON(ENDPOINTS.products);
        const salesResponse = await fetchJSON(ENDPOINTS.sales);

        products = productResponse.data || [];
        sales = salesResponse.data || [];

        console.log("PRODUCT DATA:", products);
        console.log("SALES DATA:", sales);
    } catch (error) {
        console.error("Dashboard data fetch failed:", error);
        document.getElementById('pageSubtitle').textContent = 'Failed to load dashboard data.';
        return;
    }

    /*
    =====================
    KPI CARDS
    =====================
    Each section below runs in its own try/catch so that a
    failure in one widget (e.g. the chart lib not being ready)
    doesn't stop the other widgets from rendering.
    */
    try {
        const totalProducts = products.length;
        const totalSales = sales.reduce((sum, item) => sum + getSoldQty(item), 0);
        const lowStock = products.filter(product => getStock(product) <= 10).length;

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

    /*
    =====================
    INVENTORY DONUT
    =====================
    */
    try {
        let inStock = 0;
        let low = 0;
        let out = 0;

        products.forEach(product => {
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

    /*
    =====================
    STOCK REMINDER
    =====================
    */
    try {
        renderStockReminders({
            items: products
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

    /*
    =====================
    RECENT ACTIVITIES
    =====================
    */
    try {
        renderRecentActivities({
            items: sales
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