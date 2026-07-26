@extends('layouts.app')

@section('title', 'Demand Forecasting')

@section('header')
    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Demand Forecasting</h1>

    <div class="flex flex-wrap items-center gap-2.5">
        <div class="relative">
            <select id="dateRangeSelect" class="appearance-none pl-3.5 pr-8 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                <option value="30d">Last 30 Days</option>
                <option value="90d">Last 90 Days</option>
                <option value="6m" selected>Last 6 Months</option>
                <option value="12m">Last 12 Months</option>
            </select>
            <svg class="w-3.5 h-3.5 text-slate-400 absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>

        <div class="relative">
            <select id="categorySelect" class="appearance-none pl-3.5 pr-8 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer min-w-[140px]">
                <option value="">All Unit Types</option>
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
@endsection

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="statsRow"></div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-slate-900 text-sm">Historical Sales &amp; Future Forecast</h3>
            <div class="flex items-center gap-4 text-[11px] font-bold text-slate-500">
                <span class="flex items-center gap-1.5"><span class="w-3 h-[3px] rounded-full bg-emerald-500 inline-block"></span> Historical Sales</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-[3px] rounded-full bg-rose-400 inline-block"></span> Future Forecast</span>
            </div>
        </div>
        <div id="chartLoadingMsg" class="text-xs font-semibold text-slate-400 italic py-16 text-center">Loading chart…</div>
        <div class="h-72">
            <canvas id="salesForecastChart" class="hidden"></canvas>
        </div>
    </div>

    {{-- Product Demand Forecast table — header cells now match the body's
         alignment exactly: Product stays left, the 3 numeric columns are
         centered on both header and data, Status stays left. --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden p-5 space-y-4">
        <h3 class="font-bold text-slate-900 text-sm">Product Demand Forecast</h3>
        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-100/80 text-slate-500 font-bold">
                    <tr>
                        <th class="py-2.5 px-3 rounded-l-lg text-left">Product</th>
                        <th class="py-2.5 px-3 text-center">Current Stock</th>
                        <th class="py-2.5 px-3 text-center">Historical Sales</th>
                        <th class="py-2.5 px-3 text-center">Forecast Demand</th>
                        <th class="py-2.5 px-3 rounded-r-lg text-left">Status</th>
                    </tr>
                </thead>
                <tbody id="productForecastBody" class="divide-y divide-slate-50 font-semibold text-slate-700">
                    <tr><td colspan="5" class="py-6 text-center text-slate-400 italic font-normal">Loading…</td></tr>
                </tbody>
            </table>
        </div>
        <div id="productForecastPagination" class="flex items-center justify-center gap-1.5 pt-2"></div>
    </div>

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
        <div id="recommendationsPagination" class="flex items-center justify-center gap-1.5 pt-2"></div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
/* =============================================================================
   ONLY 2 DATA SOURCES — everything on this page (KPI cards, chart, product
   table, recommendations) is computed client-side from these two raw feeds.

   CONFIRMED SCHEMA (from your actual MySQL tables, via DESCRIBE):

   sales:    id, product_id, quantity_sold, sale_date, created_at, updated_at
   products: product_id, product_name, unit_type, unit_cost, current_stock,
             reorder_point, reorder_quantity, priority_level, created_at, updated_at

   SalesApiController joins products in, so each sales row also carries
   product_name + unit_type. Both endpoints wrap their array in a `data` key.

   There is no `category` column on either table — the "Category" filter is
   repurposed to filter by `unit_type`, the real column that exists.
   ============================================================================= */
const API_BASE_URL = '';
const SALES_ENDPOINT = `${API_BASE_URL}/api/sales`;
const INVENTORY_ENDPOINT = `${API_BASE_URL}/api/products`;

const ICONS = {
    cube: '<svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
    calendar: '<svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
    growth: '<svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>'
};

let forecastChart = null;
let salesData = [];
let productData = [];

const PAGE_SIZE = 10;
let productForecastRows = [];
let productForecastPage = 1;
let recommendationRows = [];
let recommendationPage = 1;

async function fetchJSON(url, options = {}) {
    const res = await fetch(url, { headers: { 'Content-Type': 'application/json' }, ...options });
    if (!res.ok) throw new Error(`Request to ${url} failed with status ${res.status}`);
    return res.json();
}

/* Confirmed against your actual MySQL schema (products + sales tables). */
function normalizeSalesRecord(row) {
    return {
        product: row.product_name ?? 'Unknown',
        unitType: row.unit_type ?? '',
        qty: Number(row.quantity_sold ?? 0),
        date: row.sale_date ?? null
    };
}
function normalizeInventoryItem(row) {
    return {
        product: row.product_name ?? 'Unknown',
        unitType: row.unit_type ?? '',
        currentStock: Number(row.current_stock ?? 0),
        reorderPoint: Number(row.reorder_point ?? 0),
        reorderQuantity: Number(row.reorder_quantity ?? 0),
        priorityLevel: row.priority_level ?? null // 'High' | 'Medium' | 'Low', not currently used below
    };
}

function calculateForecastData(sales, products, range) {
    const today = new Date();
    let days;
    switch (range) {
        case '30d': days = 30; break;
        case '90d': days = 90; break;
        case '6m':  days = 180; break;
        case '12m': days = 365; break;
        default:    days = 30;
    }

    // Current period
    const currentStart = new Date();
    currentStart.setDate(today.getDate() - days);
    const currentSales = sales.filter(s => new Date(s.date) >= currentStart);

    // Previous period (for growth comparison)
    const previousStart = new Date();
    previousStart.setDate(previousStart.getDate() - (days * 2));
    const previousSales = sales.filter(s => {
        const date = new Date(s.date);
        return date >= previousStart && date < currentStart;
    });

    const currentTotal = currentSales.reduce((sum, s) => sum + s.qty, 0);
    const previousTotal = previousSales.reduce((sum, s) => sum + s.qty, 0);

    // Forecast using simple monthly average (SMA)
    const monthlySales = {};
    currentSales.forEach(s => {
        const d = new Date(s.date);
        const month = `${d.getFullYear()}-${d.getMonth() + 1}`;
        monthlySales[month] = (monthlySales[month] || 0) + s.qty;
    });
    const monthlyValues = Object.values(monthlySales);
    let forecast = currentTotal;
    if (monthlyValues.length > 0) {
        const average = monthlyValues.reduce((a, b) => a + b, 0) / monthlyValues.length;
        forecast = Math.round(average);
    }

    // Demand growth — only computed when there's enough history to compare fairly
    let growth = null;
    let hasEnoughHistory = true;
    if (range === '6m' || range === '12m') {
        const requiredMonths = range === '6m' ? 6 : 12;
        const previousMonths = new Set(previousSales.map(s => {
            const d = new Date(s.date);
            return `${d.getFullYear()}-${d.getMonth()}`;
        }));
        if (previousMonths.size < requiredMonths) hasEnoughHistory = false;
    }
    if (hasEnoughHistory && previousTotal > 0) {
        growth = Math.round(((currentTotal - previousTotal) / previousTotal) * 100);
    }

    // Per-product forecast + reorder need
    const productForecast = products.map(product => {
        const productSales = currentSales.filter(s => s.product === product.product);
        const sold = productSales.reduce((sum, s) => sum + s.qty, 0);
        const productForecastQty = Math.round(sold);
        const reorder = Math.max(0, productForecastQty - product.currentStock);
        return {
            product: product.product,
            historical: sold,
            forecast: productForecastQty,
            stock: product.currentStock,
            reorder
        };
    });

    const totalReorder = productForecast.reduce((sum, p) => sum + p.reorder, 0);
    const totalStock = products.reduce((sum, p) => sum + p.currentStock, 0);
    const dailySales = currentTotal / days;
    const coverage = dailySales > 0 ? Math.round(totalStock / dailySales) : 0;

    return { range, days, currentTotal, previousTotal, forecast, growth, totalReorder, coverage, productForecast };
}

function buildChartData(sales) {
    const monthly = {};
    sales.forEach(s => {
        const date = new Date(s.date);
        const key = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
        monthly[key] = (monthly[key] || 0) + s.qty;
    });

    const labels = Object.keys(monthly).sort();
    const actual = labels.map(month => monthly[month]);

    // Moving average forecast over the last 3 known months
    let forecast = 0;
    if (actual.length > 0) {
        const lastValues = actual.slice(-3);
        forecast = Math.round(lastValues.reduce((a, b) => a + b, 0) / lastValues.length);
    }

    return {
        labels: [...labels, 'Forecast'],
        actual: [...actual, null],
        predicted: [...Array(actual.length - 1).fill(null), actual[actual.length - 1], forecast],
        forecast
    };
}

function currentFilters() {
    return {
        range: document.getElementById('dateRangeSelect').value,
        unitType: document.getElementById('categorySelect').value
    };
}

function applyForecastFilters(sales, products, filters) {
    let filteredSales = sales;
    let filteredProducts = products;
    if (filters.unitType) {
        filteredSales = sales.filter(s => s.unitType === filters.unitType);
        filteredProducts = products.filter(p => p.unitType === filters.unitType);
    }
    return { filteredSales, filteredProducts };
}

function populateCategoryOptions(sales) {
    const select = document.getElementById('categorySelect');
    const existing = new Set(Array.from(select.options).map(o => o.value));
    const unitTypes = [...new Set(sales.map(s => s.unitType).filter(Boolean))];
    unitTypes.forEach(type => {
        if (!existing.has(type)) {
            const opt = document.createElement('option');
            opt.value = type;
            opt.textContent = type;
            select.appendChild(opt);
        }
    });
}

/* ===================== Render functions ===================== */

function renderStatCards(data) {
    const row = document.getElementById('statsRow');

    const stats = [
        {
            label: 'Forecast Demand',
            value: `${data.forecast.toLocaleString()} Units`,
            note: `Next ${data.days} Days`,
            icon: 'cube'
        },
        {
            label: 'Product Reorder',
            value: data.totalReorder.toLocaleString(),
            note: 'Recommended Reorder',
            icon: 'cube'
        },
        {
            label: 'Inventory Coverage',
            value: `${data.coverage} Days`,
            note: 'Current Inventory Capacity',
            icon: 'calendar'
        },
        {
            label: 'Demand Growth',
            value: data.growth === null ? 'N/A' : `${data.growth >= 0 ? '+' : ''}${data.growth}%`,
            note: data.growth === null ? 'Insufficient historical data' : 'Compared to previous period',
            icon: 'growth',
            positive: data.growth !== null ? data.growth >= 0 : null
        }
    ];

    row.innerHTML = '';
    stats.forEach(stat => {
        const color = stat.positive === true ? 'text-emerald-600' : (stat.positive === false ? 'text-rose-600' : 'text-slate-900');
        const card = document.createElement('div');
        card.className = 'bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-start justify-between gap-3';
        card.innerHTML = `
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">${escapeHTML(stat.label)}</span>
                <div class="text-2xl font-extrabold ${color} font-mono">${escapeHTML(stat.value)}</div>
                <span class="text-[11px] font-semibold text-slate-500 block">${escapeHTML(stat.note)}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0">${ICONS[stat.icon] || ''}</div>
        `;
        row.appendChild(card);
    });
}

function renderForecastChart(chartData) {
    const canvas = document.getElementById('salesForecastChart');
    const ctx = canvas.getContext('2d');

    document.getElementById('chartLoadingMsg').classList.add('hidden');
    canvas.classList.remove('hidden');

    if (forecastChart) forecastChart.destroy();

    forecastChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [
                { label: 'Historical Sales', data: chartData.actual, borderColor: '#10b981', backgroundColor: '#10b981', tension: 0.3, spanGaps: true },
                { label: 'Forecast', data: chartData.predicted, borderColor: '#fb7185', backgroundColor: '#fb7185', borderDash: [6, 6], tension: 0.3, spanGaps: true }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
}

/* Shared pagination control — renders numbered page buttons + prev/next
   into `containerId`, and calls onPageChange(newPage) when clicked. */
function renderPagination(containerId, totalItems, currentPage, onPageChange) {
    const container = document.getElementById(containerId);
    const totalPages = Math.max(1, Math.ceil(totalItems / PAGE_SIZE));

    if (totalPages <= 1) {
        container.innerHTML = '';
        return;
    }

    const btnBase = 'w-7 h-7 flex items-center justify-center rounded-lg text-xs font-bold transition';
    const btnActive = `${btnBase} bg-indigo-600 text-white`;
    const btnInactive = `${btnBase} text-slate-500 hover:bg-slate-100`;
    const btnDisabled = `${btnBase} text-slate-300 cursor-not-allowed`;

    let html = '';
    html += `<button type="button" class="${currentPage === 1 ? btnDisabled : btnInactive}" ${currentPage === 1 ? 'disabled' : ''} data-page="${currentPage - 1}">‹</button>`;

    for (let p = 1; p <= totalPages; p++) {
        html += `<button type="button" class="${p === currentPage ? btnActive : btnInactive}" data-page="${p}">${p}</button>`;
    }

    html += `<button type="button" class="${currentPage === totalPages ? btnDisabled : btnInactive}" ${currentPage === totalPages ? 'disabled' : ''} data-page="${currentPage + 1}">›</button>`;

    container.innerHTML = html;
    container.querySelectorAll('button[data-page]:not(:disabled)').forEach(btn => {
        btn.addEventListener('click', () => onPageChange(Number(btn.dataset.page)));
    });
}

function renderProductForecast(products) {
    productForecastRows = products || [];
    if (productForecastPage > Math.ceil(productForecastRows.length / PAGE_SIZE)) {
        productForecastPage = 1;
    }
    renderProductForecastPage();
}

function renderProductForecastPage() {
    const body = document.getElementById('productForecastBody');

    if (productForecastRows.length === 0) {
        body.innerHTML = `<tr><td colspan="5" class="py-6 text-center text-slate-400 italic font-normal">No product forecast data available.</td></tr>`;
        document.getElementById('productForecastPagination').innerHTML = '';
        return;
    }

    const start = (productForecastPage - 1) * PAGE_SIZE;
    const pageItems = productForecastRows.slice(start, start + PAGE_SIZE);

    body.innerHTML = pageItems.map(product => {
        let statusText, statusColor;

        if (product.stock <= 0) {
            statusText = 'Out of Stock';
            statusColor = 'bg-rose-600';
        } else if (product.stock < product.forecast * 0.25) {
            statusText = 'Critical Stock';
            statusColor = 'bg-rose-500';
        } else if (product.stock < product.forecast) {
            statusText = 'Low Stock';
            statusColor = 'bg-amber-400';
        } else {
            statusText = 'Sufficient Stock';
            statusColor = 'bg-emerald-500';
        }

        return `
        <tr class="hover:bg-slate-50/80 transition">
            <td class="py-3 px-3 font-bold text-slate-900 text-left">${escapeHTML(product.product)}</td>
            <td class="py-3 px-3 text-center font-mono">${product.stock.toLocaleString()}</td>
            <td class="py-3 px-3 text-center font-mono">${product.historical.toLocaleString()}</td>
            <td class="py-3 px-3 text-center font-mono">${product.forecast.toLocaleString()}</td>
            <td class="py-3 px-3 text-left">
                <span class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full ${statusColor} flex-shrink-0"></span>
                    <span>${statusText}</span>
                </span>
            </td>
        </tr>
        `;
    }).join('');

    renderPagination('productForecastPagination', productForecastRows.length, productForecastPage, (newPage) => {
        productForecastPage = newPage;
        renderProductForecastPage();
    });
}

// This is the ONLY renderRecommendations now — it matches the actual shape
// of productForecast items ({product, historical, forecast, stock, reorder}),
// not the old {product, recommendation} shape that was silently overwriting
// this one before and causing every row to render blank.
function renderRecommendations(products) {
    recommendationRows = (products || []).filter(p => p.reorder > 0);
    if (recommendationPage > Math.ceil(recommendationRows.length / PAGE_SIZE)) {
        recommendationPage = 1;
    }
    renderRecommendationsPage();
}

function renderRecommendationsPage() {
    const body = document.getElementById('recommendationsBody');

    if (recommendationRows.length === 0) {
        body.innerHTML = `<tr><td colspan="2" class="py-6 text-center text-slate-400 italic font-normal">No reorder recommendations right now.</td></tr>`;
        document.getElementById('recommendationsPagination').innerHTML = '';
        return;
    }

    const start = (recommendationPage - 1) * PAGE_SIZE;
    const pageItems = recommendationRows.slice(start, start + PAGE_SIZE);

    body.innerHTML = pageItems.map(product => `
        <tr class="hover:bg-slate-50/80 transition">
            <td class="py-3 px-3 font-bold text-slate-900">${escapeHTML(product.product)}</td>
            <td class="py-3 px-3 text-slate-600">Reorder <b>${product.reorder.toLocaleString()}</b> units</td>
        </tr>
    `).join('');

    renderPagination('recommendationsPagination', recommendationRows.length, recommendationPage, (newPage) => {
        recommendationPage = newPage;
        renderRecommendationsPage();
    });
}

/* ===================== Orchestration ===================== */

async function loadForecastData() {
    const filters = currentFilters();

    const { filteredSales, filteredProducts } = applyForecastFilters(salesData, productData, filters);

    const result = calculateForecastData(filteredSales, filteredProducts, filters.range);

    productForecastPage = 1;
    recommendationPage = 1;

    renderStatCards(result);
    renderProductForecast(result.productForecast);
    renderRecommendations(result.productForecast);

    const chartData = buildChartData(filteredSales);
    renderForecastChart(chartData);
}

async function initForecasting() {
    try {
        const [salesRes, inventoryRes] = await Promise.all([
            fetchJSON(SALES_ENDPOINT),
            fetchJSON(INVENTORY_ENDPOINT)
        ]);

        salesData = (salesRes.data || []).map(normalizeSalesRecord);
        productData = (inventoryRes.data || []).map(normalizeInventoryItem);

        populateCategoryOptions(salesData);
        loadForecastData();
    } catch (e) {
        console.error('initForecasting failed:', e);
        document.getElementById('statsRow').innerHTML = `<div class="col-span-full text-xs font-semibold text-rose-600">Could not load Sales or Inventory data: ${escapeHTML(e.message)}</div>`;
        document.getElementById('chartLoadingMsg').textContent = 'Could not load chart data.';
        document.getElementById('productForecastBody').innerHTML = `<tr><td colspan="5" class="py-6 text-center text-rose-600 font-normal">Could not load product data.</td></tr>`;
        document.getElementById('recommendationsBody').innerHTML = `<tr><td colspan="2" class="py-6 text-center text-rose-600 font-normal">Could not load recommendations.</td></tr>`;
    }
}

function escapeHTML(str) {
    if (str === null || str === undefined) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

document.addEventListener('DOMContentLoaded', () => {
    initForecasting();
    document.getElementById('dateRangeSelect').addEventListener('change', loadForecastData);
    document.getElementById('categorySelect').addEventListener('change', loadForecastData);
});
</script>
@endpush