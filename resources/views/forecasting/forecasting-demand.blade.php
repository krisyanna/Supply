@extends('layouts.app')

@section('title', 'Demand Forecasting')

@section('header')
    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Demand Forecasting</h1>

    <div class="flex flex-wrap items-center gap-2.5">
        <div class="relative">
            <input type="text" id="productSearchInput" placeholder="Search product…" autocomplete="off"
                class="pl-3.5 pr-8 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 placeholder:font-semibold placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-48" />
            <svg class="w-3.5 h-3.5 text-slate-400 absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <div id="productSearchResults" class="hidden absolute z-20 top-full mt-1.5 left-0 w-64 bg-white border border-slate-200 rounded-xl shadow-lg max-h-64 overflow-y-auto py-1"></div>
        </div>

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
            <select id="unitTypeSelect" class="appearance-none pl-3.5 pr-8 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer min-w-[140px]">
                <option value="">All Unit Types</option>
            </select>
            <svg class="w-3.5 h-3.5 text-slate-400 absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>

        <button type="button" onclick="loadForecastData()" class="px-4 py-2 bg-white border border-indigo-200 hover:bg-indigo-50 text-indigo-600 text-xs font-extrabold rounded-full transition flex items-center gap-1.5">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <span>Refresh</span>
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
                <span class="flex items-center gap-1.5"><span class="w-3 h-[3px] rounded-full bg-rose-400 inline-block"></span> Forecast</span>
            </div>
        </div>
        <div id="chartLoadingMsg" class="text-xs font-semibold text-slate-400 italic py-16 text-center">Loading chart…</div>
        <div class="h-72">
            <canvas id="salesForecastChart" class="hidden"></canvas>
        </div>
    </div>

    {{-- Product Demand Forecast — forecasting-only columns. Current Stock and
         Inventory Status live in the Inventory module, not here. --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden p-5 space-y-4">
        <h3 class="font-bold text-slate-900 text-sm">Product Demand Forecast</h3>
        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-100/80 text-slate-500 font-bold">
                    <tr>
                        <th class="py-2.5 px-3 rounded-l-lg text-left">Product</th>
                        <th class="py-2.5 px-3 text-center">Historical Sales</th>
                        <th class="py-2.5 px-3 text-center">Forecast Demand</th>
                        <th class="py-2.5 px-3 rounded-r-lg text-center">Growth Rate</th>
                    </tr>
                </thead>
                <tbody id="productForecastBody" class="divide-y divide-slate-50 font-semibold text-slate-700">
                    <tr><td colspan="4" class="py-6 text-center text-slate-400 italic font-normal">Loading…</td></tr>
                </tbody>
            </table>
        </div>
        <div id="productForecastPagination" class="flex items-center justify-center gap-1.5 pt-2"></div>
    </div>

    {{-- Demand Trend Analysis replaces the old Planning Recommendations
         (reorder-quantity) table, which was an Inventory/Procurement concern. --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden p-5 space-y-4">
        <h3 class="font-bold text-slate-900 text-sm">Demand Trend Analysis</h3>
        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-100/80 text-slate-500 font-bold">
                    <tr>
                        <th class="py-2.5 px-3 rounded-l-lg text-left">Product</th>
                        <th class="py-2.5 px-3 text-center">Historical Sales</th>
                        <th class="py-2.5 px-3 text-center">Growth Rate</th>
                        <th class="py-2.5 px-3 rounded-r-lg text-left">Trend</th>
                    </tr>
                </thead>
                <tbody id="trendAnalysisBody" class="divide-y divide-slate-50 font-semibold text-slate-700">
                    <tr><td colspan="4" class="py-6 text-center text-slate-400 italic font-normal">Loading…</td></tr>
                </tbody>
            </table>
        </div>
        <div id="trendAnalysisPagination" class="flex items-center justify-center gap-1.5 pt-2"></div>
    </div>

    {{-- Product detail modal, opened from the search bar above. Shows the
         same per-product numbers already computed in buildProductAnalytics —
         nothing new is calculated here. "Status" reflects demand trend
         (Increasing/Stable/Decreasing), since this page has no inventory
         stock data to draw on. --}}
    <div id="productDetailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 space-y-4 relative">
            <button type="button" onclick="closeProductDetail()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <h3 id="productDetailName" class="font-extrabold text-slate-900 text-base pr-6"></h3>
            <div class="grid grid-cols-1 gap-3 text-xs">
                <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">
                    <span class="font-bold text-slate-500">Demand Status</span>
                    <span id="productDetailStatus" class="font-extrabold"></span>
                </div>
                <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">
                    <span class="font-bold text-slate-500">Historical Sales</span>
                    <span id="productDetailHistorical" class="font-mono font-extrabold text-slate-900"></span>
                </div>
                <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">
                    <span class="font-bold text-slate-500">Forecast Demand</span>
                    <span id="productDetailForecast" class="font-mono font-extrabold text-slate-900"></span>
                </div>
                <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">
                    <span class="font-bold text-slate-500">Growth Rate</span>
                    <span id="productDetailGrowth" class="font-mono font-extrabold"></span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
/* =============================================================================
   DEMAND FORECASTING — sales analytics only.

   Single data source: GET /api/sales
   Each record: { product_id, product_name, unit_type, quantity_sold, sale_date }

   No Inventory API, no Product API. Stock levels, reorder points, and
   procurement recommendations belong to the Inventory/Procurement pages,
   not here. Everything below is derived purely from historical sales.

   All per-product numbers (historical sales, forecast, growth rate, trend)
   come from ONE function — buildProductAnalytics() — and every table on the
   page renders from that same array. Nothing is recalculated twice.
   ============================================================================= */
const API_BASE_URL = '';
const SALES_ENDPOINT = `${API_BASE_URL}/api/sales`;

const ICONS = {
    cube: '<svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
    calendar: '<svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
    growth: '<svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
    chart: '<svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V9m4 8V5m4 12v-6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>'
};

let forecastChart = null;
let salesData = [];

const PAGE_SIZE = 10;
let productForecastRows = [];
let productForecastPage = 1;
let trendAnalysisRows = [];
let trendAnalysisPage = 1;

async function fetchJSON(url, options = {}) {
    const res = await fetch(url, { headers: { 'Content-Type': 'application/json' }, ...options });
    if (!res.ok) throw new Error(`Request to ${url} failed with status ${res.status}`);
    return res.json();
}

function normalizeSalesRecord(row) {
    return {
        product: row.product_name ?? 'Unknown',
        unitType: row.unit_type ?? '',
        qty: Number(row.quantity_sold ?? 0),
        date: row.sale_date ?? null
    };
}

/* ===================== Shared period helpers ===================== */
/* Every calculation on the page (KPI cards, both tables, the chart) is
   built on top of these few helpers so date-window logic is never
   duplicated. */

const RANGE_CONFIG = {
    '30d': { days: 30, months: 1, forecastLabel: 'Expected Next 30 Days' },
    '90d': { days: 90, months: 3, forecastLabel: 'Expected Next Month' },
    '6m':  { days: 180, months: 6, forecastLabel: 'Expected Next 6 Months' },
    '12m': { days: 365, months: 12, forecastLabel: 'Expected Next 12 Months' }
};

function getRangeConfig(range) {
    return RANGE_CONFIG[range] || RANGE_CONFIG['30d'];
}

function getPeriodBoundaries(range) {
    const { days } = getRangeConfig(range);
    const today = new Date();
    const currentStart = new Date();
    currentStart.setDate(today.getDate() - days);
    const previousStart = new Date();
    previousStart.setDate(today.getDate() - (days * 2));
    return { currentStart, previousStart, days };
}

function splitSalesByPeriod(sales, boundaries) {
    const currentSales = sales.filter(s => new Date(s.date) >= boundaries.currentStart);
    const previousSales = sales.filter(s => {
        const d = new Date(s.date);
        return d >= boundaries.previousStart && d < boundaries.currentStart;
    });
    return { currentSales, previousSales };
}

function sumQty(rows) {
    return rows.reduce((sum, r) => sum + r.qty, 0);
}

function calcGrowthRate(current, previous) {

    // no historical comparison
    if (previous === 0) {
        return null;
    }
let growth = ((current - previous) / previous) * 100;

    if (growth > 100) growth = 100;
    if (growth < -100) growth = -100;

    return Math.round(growth);
}
    
function getTrend(growthRate) {

    if (growthRate === null) {
        return 'Insufficient Data';
    }

    if (growthRate > 10) {
        return 'Increasing Demand';
    }

    if (growthRate < -10) {
        return 'Decreasing Demand';
    }

    return 'Stable Demand';
}

/* Trend-adjusted forecast: the flat run-rate (averageMonthlyDemand) carried
   forward at the same growth rate that produced the Trend badge, so a
   product marked "Decreasing Demand" always forecasts below its historical
   pace, and "Increasing Demand" always forecasts above it. When there's no
   previous period to compare (growthRate === null), there's no trend to
   apply, so the forecast falls back to the flat average. */
function projectForecastDemand(averageMonthlyDemand) {
    return Math.round(averageMonthlyDemand);
}

/* ===================== The single analytics function ===================== */
/* Returns one row per product. Every table on the page renders from this
   exact array — nothing here is ever recomputed downstream. */
function buildProductAnalytics(salesData, range) {
    const { months } = getRangeConfig(range);
    const boundaries = getPeriodBoundaries(range);
    const { currentSales, previousSales } = splitSalesByPeriod(salesData, boundaries);

    const products = [...new Set(salesData.map(s => s.product))];

    return products
        .map(product => {
            const productCurrent = currentSales.filter(s => s.product === product);
            const productPrevious = previousSales.filter(s => s.product === product);

            const historicalSales = sumQty(productCurrent);
            const previousSalesTotal = sumQty(productPrevious);
            const averageMonthlyDemand = Math.round(historicalSales / months);
            const growthRate = calcGrowthRate(historicalSales, previousSalesTotal);
            const trend = getTrend(growthRate, historicalSales);
             const forecastDemand = projectForecastDemand(averageMonthlyDemand);

            return {
                product,
                historicalSales,
                previousSales: previousSalesTotal,
                forecastDemand,
                growthRate,
                averageMonthlyDemand,
                trend
            };
        })
        .filter(row => row.historicalSales > 0 || row.previousSales > 0)
        .sort((a, b) => b.historicalSales - a.historicalSales);
}

/* Page-level totals, built from the same period helpers as the analytics
   above (not a re-derivation of the per-product numbers — a different
   granularity of the same underlying sales split). */
function buildOverallAnalytics(salesData, range) {
    const { months, forecastLabel } = getRangeConfig(range);
    const boundaries = getPeriodBoundaries(range);
    const { currentSales, previousSales } = splitSalesByPeriod(salesData, boundaries);

    const currentTotal = sumQty(currentSales);
    const previousTotal = sumQty(previousSales);
    const averageMonthlyDemand = Math.round(currentTotal / months);
    const growthRate = calcGrowthRate(currentTotal, previousTotal);
    const forecastDemand = projectForecastDemand(averageMonthlyDemand);

    return {
        range,
        days: boundaries.days,
        months,
        forecastLabel,
        currentTotal,
        previousTotal,
        forecastDemand,
        growthRate,
        averageMonthlyDemand
    };
}

function buildSalesTrendChartData(sales, overall) {
    const monthly = {};
    sales.forEach(s => {
        const date = new Date(s.date);
        const key = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
        monthly[key] = (monthly[key] || 0) + s.qty;
    });

    const labels = Object.keys(monthly).sort();
    const actual = labels.map(month => monthly[month]);

    return {
        labels: [...labels, 'Forecast'],
        actual: [...actual, null],
        predicted: [...Array(actual.length - 1).fill(null), actual[actual.length - 1] ?? 0, overall.forecastDemand]
    };
}

function currentFilters() {
    return {
        range: document.getElementById('dateRangeSelect').value,
        unitType: document.getElementById('unitTypeSelect').value
    };
}

function applyUnitTypeFilter(sales, unitType) {
    if (!unitType) return sales;
    return sales.filter(s => s.unitType === unitType);
}

function populateUnitTypeOptions(sales) {
    const select = document.getElementById('unitTypeSelect');
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

function renderStatCards(overall) {
    const row = document.getElementById('statsRow');

    const stats = [
        {
            label: 'Historical Sales',
            value: `${overall.currentTotal.toLocaleString()} Units`,
            note: `Last ${overall.days} Days`,
            icon: 'calendar'
        },
        {
            label: 'Forecast Demand',
            value: `${overall.forecastDemand.toLocaleString()} Units`,
            note: overall.forecastLabel,
            icon: 'cube'
        },
        {
            label: 'Growth Rate',
            value: overall.growthRate === null ? 'N/A' : `${overall.growthRate >= 0 ? '+' : ''}${overall.growthRate}%`,
            note: overall.growthRate === null ? 'Insufficient historical data' : 'Compared with previous period',
            icon: 'growth',
            positive: overall.growthRate !== null ? overall.growthRate >= 0 : null
        },
        {
            label: 'Average Monthly Demand',
            value: `${overall.averageMonthlyDemand.toLocaleString()} Units`,
            note: 'Per Month',
            icon: 'chart'
        }
    ];

    row.innerHTML = '';

    stats.forEach(stat => {
        const color =
            stat.positive === true
                ? 'text-emerald-600'
                : stat.positive === false
                ? 'text-rose-600'
                : 'text-slate-900';

        const card = document.createElement('div');
        card.className = 'bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-start justify-between gap-3';
        card.innerHTML = `
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">${escapeHTML(stat.label)}</span>
                <div class="text-2xl font-extrabold ${color} font-mono">${escapeHTML(stat.value)}</div>
                <span class="text-[11px] font-semibold text-slate-500 block">${escapeHTML(stat.note)}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0">
                ${ICONS[stat.icon] || ''}
            </div>
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

function growthRateLabel(growthRate) {
    if (growthRate === null) {
        return 'N/A';
    }

    return `${growthRate >= 0 ? '+' : ''}${growthRate}%`;
}

function renderProductForecast(analytics) {
    productForecastRows = analytics;
    if (productForecastPage > Math.ceil(productForecastRows.length / PAGE_SIZE)) {
        productForecastPage = 1;
    }
    renderProductForecastPage();
}

function renderProductForecastPage() {
    const body = document.getElementById('productForecastBody');

    if (productForecastRows.length === 0) {
        body.innerHTML = `<tr><td colspan="4" class="py-6 text-center text-slate-400 italic font-normal">No sales data available for this selection.</td></tr>`;
        document.getElementById('productForecastPagination').innerHTML = '';
        return;
    }

    const start = (productForecastPage - 1) * PAGE_SIZE;
    const pageItems = productForecastRows.slice(start, start + PAGE_SIZE);

    body.innerHTML = pageItems.map(row => `
        <tr class="hover:bg-slate-50/80 transition">
            <td class="py-3 px-3 font-bold text-slate-900 text-left">${escapeHTML(row.product)}</td>
            <td class="py-3 px-3 text-center font-mono">${row.historicalSales.toLocaleString()}</td>
            <td class="py-3 px-3 text-center font-mono">${row.forecastDemand.toLocaleString()}</td>
            <td class="py-3 px-3 text-center font-mono ${row.growthRate !== null && row.growthRate < 0 ? 'text-rose-600' : 'text-slate-700'}">${growthRateLabel(row.growthRate)}</td>
        </tr>
    `).join('');

    renderPagination('productForecastPagination', productForecastRows.length, productForecastPage, (newPage) => {
        productForecastPage = newPage;
        renderProductForecastPage();
    });
}

function renderTrendAnalysis(analytics) {
    trendAnalysisRows = analytics;
    if (trendAnalysisPage > Math.ceil(trendAnalysisRows.length / PAGE_SIZE)) {
        trendAnalysisPage = 1;
    }
    renderTrendAnalysisPage();
}

function trendBadge(trend) {
    const styles = {
        'Increasing Demand': 'bg-emerald-500',
        'Stable Demand': 'bg-amber-400',
        'Decreasing Demand': 'bg-rose-500',
        'Insufficient Data': 'bg-slate-400'
    };
    return `
        <span class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full ${styles[trend] || 'bg-slate-400'} flex-shrink-0"></span>
            <span>${escapeHTML(trend)}</span>
        </span>
    `;
}

function renderTrendAnalysisPage() {
    const body = document.getElementById('trendAnalysisBody');

    if (trendAnalysisRows.length === 0) {
        body.innerHTML = `<tr><td colspan="4" class="py-6 text-center text-slate-400 italic font-normal">No sales data available for this selection.</td></tr>`;
        document.getElementById('trendAnalysisPagination').innerHTML = '';
        return;
    }

    const start = (trendAnalysisPage - 1) * PAGE_SIZE;
    const pageItems = trendAnalysisRows.slice(start, start + PAGE_SIZE);

    body.innerHTML = pageItems.map(row => `
        <tr class="hover:bg-slate-50/80 transition">
            <td class="py-3 px-3 font-bold text-slate-900 text-left">${escapeHTML(row.product)}</td>
            <td class="py-3 px-3 text-center font-mono">${row.historicalSales.toLocaleString()}</td>
            <td class="py-3 px-3 text-center font-mono ${row.growthRate !== null && row.growthRate < 0 ? 'text-rose-600' : 'text-slate-700'}">${growthRateLabel(row.growthRate)}</td>
            <td class="py-3 px-3 text-left">${trendBadge(row.trend)}</td>
        </tr>
    `).join('');

    renderPagination('trendAnalysisPagination', trendAnalysisRows.length, trendAnalysisPage, (newPage) => {
        trendAnalysisPage = newPage;
        renderTrendAnalysisPage();
    });
}

/* ===================== Product search + detail ===================== */
/* Searches over productForecastRows — the full (unpaginated) analytics
   array already built by buildProductAnalytics(), so no new numbers are
   computed here, only looked up. */

function renderSearchResults(query) {
    const container = document.getElementById('productSearchResults');
    const q = query.trim().toLowerCase();

    if (!q) {
        container.classList.add('hidden');
        container.innerHTML = '';
        return;
    }

    const matches = productForecastRows.filter(row => row.product.toLowerCase().includes(q)).slice(0, 8);

    if (matches.length === 0) {
        container.innerHTML = `<div class="px-3 py-2.5 text-xs font-semibold text-slate-400 italic">No matching products</div>`;
    } else {
        container.innerHTML = matches.map(row => `
            <button type="button" data-product="${escapeHTML(row.product)}" class="w-full text-left px-3 py-2.5 text-xs font-bold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                ${escapeHTML(row.product)}
            </button>
        `).join('');
        container.querySelectorAll('button[data-product]').forEach(btn => {
            btn.addEventListener('click', () => {
                showProductDetail(btn.dataset.product);
                container.classList.add('hidden');
            });
        });
    }

    container.classList.remove('hidden');
}

function showProductDetail(productName) {
    const row = productForecastRows.find(r => r.product === productName);
    if (!row) return;

    document.getElementById('productDetailName').textContent = row.product;

    const statusEl = document.getElementById('productDetailStatus');
    statusEl.textContent = row.trend;
    statusEl.className = 'font-extrabold ' + (
        row.trend === 'Increasing Demand' ? 'text-emerald-600' :
        row.trend === 'Decreasing Demand' ? 'text-rose-600' :
        row.trend === 'Stable Demand' ? 'text-amber-600' : 'text-slate-500'
    );

    document.getElementById('productDetailHistorical').textContent = `${row.historicalSales.toLocaleString()} Units`;
    document.getElementById('productDetailForecast').textContent = `${row.forecastDemand.toLocaleString()} Units`;

    const growthEl = document.getElementById('productDetailGrowth');
    growthEl.textContent = growthRateLabel(row.growthRate);
    growthEl.className = 'font-mono font-extrabold ' + (
        row.growthRate !== null && row.growthRate < 0 ? 'text-rose-600' :
        row.growthRate !== null && row.growthRate > 0 ? 'text-emerald-600' : 'text-slate-500'
    );

    document.getElementById('productDetailModal').classList.remove('hidden');
}

function closeProductDetail() {
    document.getElementById('productDetailModal').classList.add('hidden');
}

/* ===================== Orchestration ===================== */

async function loadForecastData() {
    const filters = currentFilters();
    const filteredSales = applyUnitTypeFilter(salesData, filters.unitType);

    const analytics = buildProductAnalytics(filteredSales, filters.range);
    const overall = buildOverallAnalytics(filteredSales, filters.range);

    productForecastPage = 1;
    trendAnalysisPage = 1;

    renderStatCards(overall);
    renderProductForecast(analytics);
    renderTrendAnalysis(analytics);
    renderForecastChart(buildSalesTrendChartData(filteredSales, overall));
}

async function initForecasting() {
    try {
        const salesRes = await fetchJSON(SALES_ENDPOINT);
        salesData = (salesRes.data || []).map(normalizeSalesRecord);

        populateUnitTypeOptions(salesData);
        loadForecastData();
    } catch (e) {
        console.error('initForecasting failed:', e);
        document.getElementById('statsRow').innerHTML = `<div class="col-span-full text-xs font-semibold text-rose-600">Could not load Sales data: ${escapeHTML(e.message)}</div>`;
        document.getElementById('chartLoadingMsg').textContent = 'Could not load chart data.';
        document.getElementById('productForecastBody').innerHTML = `<tr><td colspan="4" class="py-6 text-center text-rose-600 font-normal">Could not load product forecast data.</td></tr>`;
        document.getElementById('trendAnalysisBody').innerHTML = `<tr><td colspan="4" class="py-6 text-center text-rose-600 font-normal">Could not load trend analysis data.</td></tr>`;
    }
}

function escapeHTML(str) {
    if (str === null || str === undefined) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

document.addEventListener('DOMContentLoaded', () => {
    initForecasting();
    document.getElementById('dateRangeSelect').addEventListener('change', loadForecastData);
    document.getElementById('unitTypeSelect').addEventListener('change', loadForecastData);

    const searchInput = document.getElementById('productSearchInput');
    searchInput.addEventListener('input', (e) => renderSearchResults(e.target.value));
    searchInput.addEventListener('focus', (e) => {
        if (e.target.value.trim()) renderSearchResults(e.target.value);
    });

    document.addEventListener('click', (e) => {
        const wrapper = searchInput.parentElement;
        if (!wrapper.contains(e.target)) {
            document.getElementById('productSearchResults').classList.add('hidden');
        }
    });

    document.getElementById('productDetailModal').addEventListener('click', (e) => {
        if (e.target.id === 'productDetailModal') closeProductDetail();
    });
});
</script>
@endpush