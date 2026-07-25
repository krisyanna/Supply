@extends('layouts.app')

@section('title', 'Demand Forecasting')

@section('header')
    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Demand Forecasting</h1>

    <div class="flex flex-wrap items-center gap-2.5">
        <div class="relative">
            <select id="dateRangeSelect" class="appearance-none pl-3.5 pr-8 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                <option value="30d">Last 30 Days</option>
                <option value="90d">Last 90 Days</option>
                <option value="6m">Last 6 Months</option>
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
    {{-- KPI STAT CARDS — rendered entirely from JS via renderStatCards() --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="statsRow"></div>

    {{-- HISTORICAL SALES VS FORECAST CHART --}}
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

    {{-- PRODUCT DEMAND FORECAST TABLE --}}
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

    {{-- PLANNING RECOMMENDATIONS TABLE --}}
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
const API_BASE_URL = '';

const ENDPOINTS = {
    categories:           `${API_BASE_URL}/api/sales/categories`,
    forecastSummary:      `${API_BASE_URL}/api/forecasting/summary`,
    historicalVsForecast: `${API_BASE_URL}/api/forecasting/historical-vs-forecast`,
    productForecast:      `${API_BASE_URL}/api/forecasting/product-demand`,
    recommendations:      `${API_BASE_URL}/api/forecasting/recommendations`
};

const ICONS = {
    cube: '<svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
    calendar: '<svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
    growth: '<svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
    none: ''
};

const DEMAND_STATUS_MAP = {
    high_demand:     { label: 'High Demand',     dot: 'bg-emerald-500' },
    moderate_demand: { label: 'Moderate Demand', dot: 'bg-amber-400' },
    low_demand:      { label: 'Low Demand',      dot: 'bg-rose-500' }
};

let forecastChart = null;

async function fetchJSON(url, options = {}) {
    const res = await fetch(url, { headers: { 'Content-Type': 'application/json' }, ...options });
    if (!res.ok) throw new Error(`Request to ${url} failed with status ${res.status}`);
    return res.json();
}

function currentFilters() {
    return {
        range: document.getElementById('dateRangeSelect').value,
        category: document.getElementById('categorySelect').value
    };
}

function buildQuery(params) {
    const query = new URLSearchParams();
    Object.entries(params).forEach(([k, v]) => { if (v) query.set(k, v); });
    const qs = query.toString();
    return qs ? `?${qs}` : '';
}

async function loadCategories() {
    try {
        const data = await fetchJSON(ENDPOINTS.categories);
        const select = document.getElementById('categorySelect');
        (data.categories || []).forEach(cat => {
            const opt = document.createElement('option');
            opt.value = cat.value;
            opt.textContent = cat.label;
            select.appendChild(opt);
        });
    } catch (e) {
        // Non-fatal — filter just stays at "All Categories"
    }
}

function renderStatCards(summary) {
    const row = document.getElementById('statsRow');
    row.innerHTML = '';
    const stats = (summary && summary.stats) || [];
    if (stats.length === 0) {
        row.innerHTML = `<div class="col-span-full text-xs font-semibold text-rose-600">No forecast stats available.</div>`;
        return;
    }
    stats.forEach(stat => {
        const iconSvg = ICONS[stat.icon] || '';
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

function renderForecastChart(data) {
    const labels = (data && data.labels) || [];
    const actual = (data && data.actual) || [];
    const forecast = (data && data.forecast) || [];

    document.getElementById('chartLoadingMsg').classList.add('hidden');

    if (labels.length === 0) {
        document.getElementById('chartLoadingMsg').textContent = 'No historical/forecast data available.';
        document.getElementById('chartLoadingMsg').classList.remove('hidden');
        return;
    }

    document.getElementById('salesForecastChart').classList.remove('hidden');
    const ctx = document.getElementById('salesForecastChart').getContext('2d');

    const chartData = {
        labels,
        datasets: [
            { label: 'Actual Sales', data: actual, borderColor: '#10b981', backgroundColor: '#10b981', borderWidth: 2.5, pointRadius: 3, pointBackgroundColor: '#0f172a', tension: 0.3, spanGaps: true },
            { label: 'Forecast', data: forecast, borderColor: '#fb7185', backgroundColor: '#fb7185', borderWidth: 2.5, borderDash: [4, 4], pointRadius: 2, tension: 0.3, spanGaps: true }
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

function renderProductForecast(data) {
    const body = document.getElementById('productForecastBody');
    const items = (data && data.items) || [];
    if (items.length === 0) {
        body.innerHTML = `<tr><td colspan="5" class="py-6 text-center text-slate-400 italic font-normal">No product forecast data available.</td></tr>`;
        return;
    }
    body.innerHTML = items.map(item => {
        const status = DEMAND_STATUS_MAP[item.status] || { label: item.status || '—', dot: 'bg-slate-300' };
        return `<tr class="hover:bg-slate-50/80 transition">
            <td class="py-3 px-3 font-bold text-slate-900">${escapeHTML(item.product)}</td>
            <td class="py-3 px-3 font-mono">${escapeHTML(formatNumber(item.currentStock))}</td>
            <td class="py-3 px-3 font-mono">${escapeHTML(formatNumber(item.lastMonthSale))}</td>
            <td class="py-3 px-3 font-mono">${escapeHTML(formatNumber(item.forecast))}</td>
            <td class="py-3 px-3">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full ${status.dot} flex-shrink-0"></span>
                    ${escapeHTML(status.label)}
                </span>
            </td>
        </tr>`;
    }).join('');
}

function renderRecommendations(data) {
    const body = document.getElementById('recommendationsBody');
    const items = (data && data.items) || [];
    if (items.length === 0) {
        body.innerHTML = `<tr><td colspan="2" class="py-6 text-center text-slate-400 italic font-normal">No planning recommendations available.</td></tr>`;
        return;
    }
    body.innerHTML = items.map(item => `<tr class="hover:bg-slate-50/80 transition">
        <td class="py-3 px-3 font-bold text-slate-900">${escapeHTML(item.product)}</td>
        <td class="py-3 px-3 font-medium text-slate-600">${escapeHTML(item.recommendation)}</td>
    </tr>`).join('');
}

async function loadForecastData() {
    const filters = currentFilters();
    const qs = buildQuery(filters);

    fetchJSON(ENDPOINTS.forecastSummary + qs).then(renderStatCards).catch(() => {
        document.getElementById('statsRow').innerHTML = `<div class="col-span-full text-xs font-semibold text-rose-600">Could not load forecast stats.</div>`;
    });

    fetchJSON(ENDPOINTS.historicalVsForecast + qs).then(renderForecastChart).catch(() => {
        document.getElementById('chartLoadingMsg').textContent = 'Could not load chart data.';
        document.getElementById('chartLoadingMsg').classList.remove('hidden');
        document.getElementById('salesForecastChart').classList.add('hidden');
    });

    fetchJSON(ENDPOINTS.productForecast + qs).then(renderProductForecast).catch(() => {
        document.getElementById('productForecastBody').innerHTML = `<tr><td colspan="5" class="py-6 text-center text-rose-600 font-normal">Could not load product forecast.</td></tr>`;
    });

    fetchJSON(ENDPOINTS.recommendations + qs).then(renderRecommendations).catch(() => {
        document.getElementById('recommendationsBody').innerHTML = `<tr><td colspan="2" class="py-6 text-center text-rose-600 font-normal">Could not load recommendations.</td></tr>`;
    });
}

function formatNumber(n) { return typeof n === 'number' ? n.toLocaleString() : n; }
function escapeHTML(str) {
    if (str === null || str === undefined) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

document.addEventListener('DOMContentLoaded', () => {
    loadCategories();
    loadForecastData();
});
</script>
@endpush