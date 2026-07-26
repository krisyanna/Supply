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
@endsection

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="statsRow"></div>

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
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
<script>
/* =============================================================================
   ONLY 2 DATA SOURCES — everything on this page (KPI cards, chart, product
   table, recommendations) is computed client-side from these two raw feeds.
   No separate "forecasting" endpoints exist anymore.

   ASSUMED SHAPES (matching the envelope pattern from your existing Inventory
   bridge API: {status, source_module, target_module, data_count, payload}).
   Adjust SALES_ENDPOINT / INVENTORY_ENDPOINT and the field names inside
   normalizeSalesRecord() / normalizeInventoryItem() to match whatever you
   actually build — those two functions are the ONLY place field names live,
   so fixing a mismatch is a one-line change, not a rewrite.

   Sales payload item assumed shape:
     { product_name, category, quantity_sold, sale_date }   (one row per sale)

   Inventory payload item assumed shape:
     { item_name, category, quantity }                       (current stock)
   ============================================================================= */
const API_BASE_URL = '';
const SALES_ENDPOINT = `${API_BASE_URL}/api/sales`;
const INVENTORY_ENDPOINT = `${API_BASE_URL}/api/inventory`;

const ICONS = {
    cube: '<svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
    calendar: '<svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
    growth: '<svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>'
};

const DEMAND_STATUS = {
    high:     { label: 'High Demand',     dot: 'bg-emerald-500' },
    moderate: { label: 'Moderate Demand', dot: 'bg-amber-400' },
    low:      { label: 'Low Demand',      dot: 'bg-rose-500' }
};

let forecastChart = null;
let rawSales = [];
let rawInventory = [];

async function fetchJSON(url, options = {}) {
    const res = await fetch(url, { headers: { 'Content-Type': 'application/json' }, ...options });
    if (!res.ok) throw new Error(`Request to ${url} failed with status ${res.status}`);
    return res.json();
}

/* Adjust these two functions if your actual API field names differ —
   nothing else in this file needs to change. */
function normalizeSalesRecord(row) {
    return {
        product: row.product_name ?? row.item_name ?? 'Unknown',
        category: row.category ?? '',
        qty: Number(row.quantity_sold ?? row.qty ?? 0),
        date: row.sale_date ?? row.created_at ?? null
    };
}
function normalizeInventoryItem(row) {
    return {
        product: row.item_name ?? row.product_name ?? 'Unknown',
        category: row.category ?? '',
        currentStock: Number(row.quantity ?? row.stock ?? 0)
    };
}

function currentFilters() {
    return {
        range: document.getElementById('dateRangeSelect').value,
        category: document.getElementById('categorySelect').value
    };
}

function monthsBack(n) {
    const months = [];
    const now = new Date();
    for (let i = n - 1; i >= 0; i--) {
        const d = new Date(now.getFullYear(), now.getMonth() - i, 1);
        months.push({ key: `${d.getFullYear()}-${d.getMonth()}`, label: d.toLocaleString('default', { month: 'short' }) });
    }
    return months;
}

function populateCategoryOptions(sales) {
    const select = document.getElementById('categorySelect');
    const existing = new Set(Array.from(select.options).map(o => o.value));
    const categories = [...new Set(sales.map(s => s.category).filter(Boolean))];
    categories.forEach(cat => {
        if (!existing.has(cat)) {
            const opt = document.createElement('option');
            opt.value = cat;
            opt.textContent = cat;
            select.appendChild(opt);
        }
    });
}

function applyFilters(sales, inventory, filters) {
    let filteredSales = sales;
    let filteredInventory = inventory;
    if (filters.category) {
        filteredSales = filteredSales.filter(s => s.category === filters.category);
        filteredInventory = filteredInventory.filter(i => i.category === filters.category);
    }
    return { filteredSales, filteredInventory };
}

/* ===================== Derived computations ===================== */

// 6-month Actual vs simple-projection Forecast series, for both the chart
// and the "Forecast Demand" / "Demand Growth" KPI cards.
function buildMonthlySeries(sales) {
    const months = monthsBack(6);
    const totals = months.map(m => {
        const sum = sales
            .filter(s => {
                if (!s.date) return false;
                const d = new Date(s.date);
                return `${d.getFullYear()}-${d.getMonth()}` === m.key;
            })
            .reduce((acc, s) => acc + s.qty, 0);
        return sum;
    });

    // Simple linear trend over the last 3 available months → 1-month forecast.
    const known = totals.filter(v => v > 0);
    let nextMonthForecast = null;
    if (known.length >= 2) {
        const last = known[known.length - 1];
        const prev = known[known.length - 2];
        nextMonthForecast = Math.max(0, Math.round(last + (last - prev)));
    } else if (known.length === 1) {
        nextMonthForecast = known[0];
    }

    const forecastSeries = totals.map((v, i) => (i === totals.length - 1 ? v : v)); // mirrors actual up to now
    if (nextMonthForecast !== null) {
        months.push({ key: 'forecast', label: monthsBack(1)[0] ? nextMonthLabel() : 'Next' });
        totals.push(null);
        forecastSeries.push(nextMonthForecast);
        // connect the dashed forecast line to the last actual point
        forecastSeries[forecastSeries.length - 2] = totals[totals.length - 2];
    }

    return {
        labels: months.map(m => m.label),
        actual: totals,
        forecast: forecastSeries,
        currentMonthTotal: known[known.length - 1] ?? 0,
        previousMonthTotal: known[known.length - 2] ?? 0,
        nextMonthForecast: nextMonthForecast ?? 0
    };
}

function nextMonthLabel() {
    const d = new Date();
    d.setMonth(d.getMonth() + 1);
    return d.toLocaleString('default', { month: 'short' });
}

function classifyDemand(forecastQty, currentStock) {
    if (currentStock <= 0) return 'high';
    const ratio = forecastQty / currentStock;
    if (ratio >= 1) return 'high';
    if (ratio >= 0.5) return 'moderate';
    return 'low';
}

// Per-product table: merges last-30-days sales with current inventory stock.
function buildProductTable(sales, inventory) {
    const cutoff = new Date();
    cutoff.setDate(cutoff.getDate() - 30);

    const lastMonthByProduct = {};
    sales.forEach(s => {
        if (!s.date || new Date(s.date) < cutoff) return;
        lastMonthByProduct[s.product] = (lastMonthByProduct[s.product] || 0) + s.qty;
    });

    return inventory.map(item => {
        const lastMonthSale = lastMonthByProduct[item.product] || 0;
        // Naive forecast: assume next month repeats last month's pace.
        const forecast = lastMonthSale;
        return {
            product: item.product,
            currentStock: item.currentStock,
            lastMonthSale,
            forecast,
            status: classifyDemand(forecast, item.currentStock)
        };
    });
}

function buildRecommendations(productRows) {
    return productRows
        .filter(r => r.status !== 'moderate' || r.currentStock < r.forecast)
        .map(r => {
            let recommendation;
            if (r.status === 'high') {
                const deficit = Math.max(r.forecast - r.currentStock, Math.round(r.forecast * 0.2));
                recommendation = `Increase production by ${deficit} units`;
            } else if (r.status === 'low') {
                recommendation = 'Maintain current inventory';
            } else {
                recommendation = 'Monitor closely — approaching reorder point';
            }
            return { product: r.product, recommendation };
        });
}

function buildKpiStats(series, productRows) {
    const growth = series.previousMonthTotal > 0
        ? Math.round(((series.currentMonthTotal - series.previousMonthTotal) / series.previousMonthTotal) * 100)
        : 0;

    const totalStock = productRows.reduce((a, r) => a + r.currentStock, 0);
    const avgDaily = series.currentMonthTotal > 0 ? series.currentMonthTotal / 30 : 0;
    const coverageDays = avgDaily > 0 ? Math.round(totalStock / avgDaily) : 0;

    const reorderLow = Math.round(series.nextMonthForecast * 0.95);
    const reorderHigh = Math.round(series.nextMonthForecast * 1.05);

    return [
        { id: 1, label: 'Forecast Demand', value: formatNumber(series.nextMonthForecast), note: 'Predicted Units', icon: 'cube' },
        { id: 2, label: 'Product Reorder', value: `${formatNumber(reorderLow)} - ${formatNumber(reorderHigh)}`, note: 'Forecast-Based Reorders' },
        { id: 3, label: 'Inventory Coverage', value: `${coverageDays} Days`, note: 'Current Inventory Capacity', icon: 'calendar' },
        { id: 4, label: 'Demand Growth', value: `${growth >= 0 ? '+' : ''}${growth}%`, note: 'Compared to Last Month', icon: 'growth', positive: growth >= 0 }
    ];
}

/* ===================== Render functions ===================== */

function renderStatCards(stats) {
    const row = document.getElementById('statsRow');
    row.innerHTML = '';
    stats.forEach(stat => {
        const iconSvg = stat.icon ? ICONS[stat.icon] : '';
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

function renderForecastChart(series) {
    document.getElementById('chartLoadingMsg').classList.add('hidden');
    document.getElementById('salesForecastChart').classList.remove('hidden');

    const ctx = document.getElementById('salesForecastChart').getContext('2d');
    const chartData = {
        labels: series.labels,
        datasets: [
            { label: 'Actual Sales', data: series.actual, borderColor: '#10b981', backgroundColor: '#10b981', borderWidth: 2.5, pointRadius: 3, pointBackgroundColor: '#0f172a', tension: 0.3, spanGaps: true },
            { label: 'Forecast', data: series.forecast, borderColor: '#fb7185', backgroundColor: '#fb7185', borderWidth: 2.5, borderDash: [4, 4], pointRadius: 2, tension: 0.3, spanGaps: true }
        ]
    };

    if (forecastChart) { forecastChart.data = chartData; forecastChart.update(); }
    else {
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

function renderProductForecast(rows) {
    const body = document.getElementById('productForecastBody');
    if (rows.length === 0) {
        body.innerHTML = `<tr><td colspan="5" class="py-6 text-center text-slate-400 italic font-normal">No product data available.</td></tr>`;
        return;
    }
    body.innerHTML = rows.map(r => {
        const status = DEMAND_STATUS[r.status];
        return `<tr class="hover:bg-slate-50/80 transition">
            <td class="py-3 px-3 font-bold text-slate-900">${escapeHTML(r.product)}</td>
            <td class="py-3 px-3 font-mono">${escapeHTML(formatNumber(r.currentStock))}</td>
            <td class="py-3 px-3 font-mono">${escapeHTML(formatNumber(r.lastMonthSale))}</td>
            <td class="py-3 px-3 font-mono">${escapeHTML(formatNumber(r.forecast))}</td>
            <td class="py-3 px-3">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full ${status.dot} flex-shrink-0"></span>
                    ${escapeHTML(status.label)}
                </span>
            </td>
        </tr>`;
    }).join('');
}

function renderRecommendations(items) {
    const body = document.getElementById('recommendationsBody');
    if (items.length === 0) {
        body.innerHTML = `<tr><td colspan="2" class="py-6 text-center text-slate-400 italic font-normal">No recommendations right now.</td></tr>`;
        return;
    }
    body.innerHTML = items.map(item => `<tr class="hover:bg-slate-50/80 transition">
        <td class="py-3 px-3 font-bold text-slate-900">${escapeHTML(item.product)}</td>
        <td class="py-3 px-3 font-medium text-slate-600">${escapeHTML(item.recommendation)}</td>
    </tr>`).join('');
}

/* ===================== Orchestration ===================== */

async function loadForecastData() {
    const filters = currentFilters();

    try {
        const { filteredSales, filteredInventory } = applyFilters(rawSales, rawInventory, filters);

        const series = buildMonthlySeries(filteredSales);
        const productRows = buildProductTable(filteredSales, filteredInventory);
        const recommendations = buildRecommendations(productRows);
        const stats = buildKpiStats(series, productRows);

        renderStatCards(stats);
        renderForecastChart(series);
        renderProductForecast(productRows);
        renderRecommendations(recommendations);
    } catch (e) {
        document.getElementById('statsRow').innerHTML = `<div class="col-span-full text-xs font-semibold text-rose-600">Could not compute forecast data.</div>`;
    }
}

async function initForecasting() {
    try {
        const [salesRes, inventoryRes] = await Promise.all([
            fetchJSON(SALES_ENDPOINT),
            fetchJSON(INVENTORY_ENDPOINT)
        ]);

        // Both endpoints assumed to return { payload: [...] } per your existing
        // Inventory bridge API's envelope — adjust here if the key differs.
        rawSales = (salesRes.payload || salesRes.items || salesRes.data || []).map(normalizeSalesRecord);
        rawInventory = (inventoryRes.payload || inventoryRes.items || inventoryRes.data || []).map(normalizeInventoryItem);

        populateCategoryOptions(rawSales);
        loadForecastData();
    } catch (e) {
        document.getElementById('statsRow').innerHTML = `<div class="col-span-full text-xs font-semibold text-rose-600">Could not load Sales or Inventory data.</div>`;
        document.getElementById('chartLoadingMsg').textContent = 'Could not load chart data.';
        document.getElementById('productForecastBody').innerHTML = `<tr><td colspan="5" class="py-6 text-center text-rose-600 font-normal">Could not load product data.</td></tr>`;
        document.getElementById('recommendationsBody').innerHTML = `<tr><td colspan="2" class="py-6 text-center text-rose-600 font-normal">Could not load recommendations.</td></tr>`;
    }
}

function formatNumber(n) { return typeof n === 'number' ? n.toLocaleString() : n; }
function escapeHTML(str) {
    if (str === null || str === undefined) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

document.addEventListener('DOMContentLoaded', initForecasting);
</script>
@endpush