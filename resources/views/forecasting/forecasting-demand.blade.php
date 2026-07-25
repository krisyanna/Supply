@extends('layouts.app')

@section('title', 'Demand Forecasting')

@section('header')
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between w-full gap-4">

    <h1 class="text-2xl font-extrabold text-slate-900">
        Demand Forecasting
    </h1>

    <div class="flex flex-wrap items-center gap-3">

        <!-- Date Range -->
        <div class="relative">

            <select
                id="dateRangeSelect"
                class="appearance-none pl-4 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                <option value="30d">Last 30 Days</option>
                <option value="90d">Last 90 Days</option>
                <option value="6m">Last 6 Months</option>
                <option value="12m">Last 12 Months</option>

            </select>

            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"/>

            </svg>

        </div>

        <!-- Category -->
        <div class="relative">

            <select
                id="categorySelect"
                class="appearance-none pl-4 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 min-w-[180px]">

                <option value="">All Categories</option>

            </select>

            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"/>

            </svg>

        </div>

        <!-- Search Button -->
        <button
            type="button"
            onclick="loadForecastData()"
            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition">

            Search

        </button>

    </div>

</div>
@endsection


@section('content')

<!-- KPI Cards -->
<div
    id="statsRow"
    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
</div>


<!-- Sales Chart -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">

    <div class="flex items-center justify-between">

        <h2 class="text-lg font-bold text-slate-800">
            Historical Sales vs Forecast
        </h2>

        <div class="flex gap-5 text-xs font-semibold text-slate-500">

            <div class="flex items-center gap-2">
                <span class="w-4 h-1 rounded-full bg-emerald-500"></span>
                Actual Sales
            </div>

            <div class="flex items-center gap-2">
                <span class="w-4 h-1 rounded-full bg-rose-500"></span>
                Forecast
            </div>

        </div>

    </div>

    <div
        id="chartLoadingMsg"
        class="py-16 text-center text-slate-400 italic">

        Loading chart...

    </div>

    <canvas
        id="salesForecastChart"
        height="90"
        class="hidden">
    </canvas>

</div>


<!-- Product Forecast -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

    <h2 class="text-lg font-bold mb-5">
        Product Demand Forecast
    </h2>

    <div class="overflow-x-auto">

        <table class="min-w-full text-sm">

            <thead class="bg-slate-100">

                <tr>

                    <th class="text-left p-3">Product</th>
                    <th class="text-left p-3">Current Stock</th>
                    <th class="text-left p-3">Last Month Sale</th>
                    <th class="text-left p-3">Forecast</th>
                    <th class="text-left p-3">Status</th>

                </tr>

            </thead>

            <tbody
                id="productForecastBody"
                class="divide-y divide-slate-100">

                <tr>

                    <td colspan="5"
                        class="text-center py-6 text-slate-400">

                        Loading...

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>


<!-- Recommendations -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

    <h2 class="text-lg font-bold mb-5">
        Planning Recommendations
    </h2>

    <div class="overflow-x-auto">

        <table class="min-w-full text-sm">

            <thead class="bg-slate-100">

                <tr>

                    <th class="text-left p-3">
                        Product
                    </th>

                    <th class="text-left p-3">
                        Recommendation
                    </th>

                </tr>

            </thead>

            <tbody
                id="recommendationsBody"
                class="divide-y divide-slate-100">

                <tr>

                    <td colspan="2"
                        class="text-center py-6 text-slate-400">

                        Loading...

                    </td>

                </tr>

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
    categories: `${API_BASE_URL}/api/sales/categories`,
    forecastSummary: `${API_BASE_URL}/api/forecasting/summary`,
    historicalVsForecast: `${API_BASE_URL}/api/forecasting/historical-vs-forecast`,
    productForecast: `${API_BASE_URL}/api/forecasting/product-demand`,
    recommendations: `${API_BASE_URL}/api/forecasting/recommendations`
};

const ICONS = {

    cube:
`<svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
</path>
</svg>`,

    calendar:
`<svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
</path>
</svg>`,

    growth:
`<svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6">
</path>
</svg>`,

    none: ''

};

const DEMAND_STATUS_MAP = {

    high_demand: {
        label: 'High Demand',
        dot: 'bg-emerald-500'
    },

    moderate_demand: {
        label: 'Moderate Demand',
        dot: 'bg-amber-400'
    },

    low_demand: {
        label: 'Low Demand',
        dot: 'bg-rose-500'
    }

};

let forecastChart = null;

async function fetchJSON(url, options = {}) {

    const response = await fetch(url, {
        headers: {
            'Content-Type': 'application/json'
        },
        ...options
    });

    if (!response.ok) {
        throw new Error(response.status);
    }

    return response.json();

}

function currentFilters() {

    return {

        range: document.getElementById('dateRangeSelect').value,

        category: document.getElementById('categorySelect').value

    };

}

function buildQuery(params) {

    const query = new URLSearchParams();

    Object.entries(params).forEach(([key, value]) => {

        if (value) {
            query.set(key, value);
        }

    });

    return query.toString()
        ? '?' + query.toString()
        : '';

}

async function loadCategories() {

    try {

        const data = await fetchJSON(ENDPOINTS.categories);

        const select = document.getElementById('categorySelect');

        (data.categories || []).forEach(category => {

            const option = document.createElement('option');

            option.value = category.value;

            option.textContent = category.label;

            select.appendChild(option);

        });

    }

    catch(error) {

        console.log(error);

    }

}

function formatNumber(number) {

    if(typeof number !== 'number') {

        return number;

    }

    return number.toLocaleString();

}

function escapeHTML(string) {

    if(string === null || string === undefined) {

        return '';

    }

    return String(string)
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;');

}

function renderStatCards(summary) {

    const row = document.getElementById('statsRow');

    row.innerHTML = '';

    const stats = (summary && summary.stats) || [];

    if (stats.length === 0) {

        row.innerHTML =
            `<div class="col-span-full text-center text-red-500">
                No forecast statistics available.
            </div>`;

        return;

    }

    stats.forEach(stat => {

        const icon = ICONS[stat.icon] || '';

        const valueColor =
            stat.positive === true
                ? 'text-emerald-600'
                : stat.positive === false
                ? 'text-rose-600'
                : 'text-slate-900';

        row.innerHTML += `

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex justify-between items-start">

                <div>

                    <div class="text-xs uppercase font-bold text-slate-400">
                        ${escapeHTML(stat.label)}
                    </div>

                    <div class="text-3xl font-extrabold ${valueColor}">
                        ${escapeHTML(stat.value)}
                    </div>

                    <div class="text-xs text-slate-500">
                        ${escapeHTML(stat.note || '')}
                    </div>

                </div>

                ${icon}

            </div>

        `;

    });

}

function renderForecastChart(data) {

    document.getElementById('chartLoadingMsg').classList.add('hidden');

    const labels = data.labels || [];

    const actual = data.actual || [];

    const forecast = data.forecast || [];

    if (labels.length === 0) {

        document.getElementById('chartLoadingMsg').innerHTML =
            'No chart data available.';

        document.getElementById('chartLoadingMsg').classList.remove('hidden');

        return;

    }

    document.getElementById('salesForecastChart').classList.remove('hidden');

    const ctx =
        document
            .getElementById('salesForecastChart')
            .getContext('2d');

    const chartData = {

        labels,

        datasets: [

            {

                label: 'Actual Sales',

                data: actual,

                borderColor: '#10b981',

                backgroundColor: '#10b981',

                borderWidth: 2,

                tension: .3

            },

            {

                label: 'Forecast',

                data: forecast,

                borderColor: '#fb7185',

                backgroundColor: '#fb7185',

                borderDash: [5,5],

                borderWidth: 2,

                tension: .3

            }

        ]

    };

    if (forecastChart) {

        forecastChart.data = chartData;

        forecastChart.update();

        return;

    }

    forecastChart = new Chart(ctx, {

        type: 'line',

        data: chartData,

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    display: false

                }

            }

        }

    });

}

function renderProductForecast(data) {

    const body =
        document.getElementById('productForecastBody');

    const items = data.items || [];

    if (!items.length) {

        body.innerHTML =
        `<tr>
            <td colspan="5" class="text-center py-6 text-slate-400">
                No product forecast available.
            </td>
        </tr>`;

        return;

    }

    body.innerHTML = items.map(item => {

        const status =
            DEMAND_STATUS_MAP[item.status] ||
            {
                label: item.status,
                dot: 'bg-slate-300'
            };

        return `

        <tr>

            <td class="p-3 font-bold">
                ${escapeHTML(item.product)}
            </td>

            <td class="p-3">
                ${formatNumber(item.currentStock)}
            </td>

            <td class="p-3">
                ${formatNumber(item.lastMonthSale)}
            </td>

            <td class="p-3">
                ${formatNumber(item.forecast)}
            </td>

            <td class="p-3">

                <div class="flex items-center gap-2">

                    <span class="w-2 h-2 rounded-full ${status.dot}"></span>

                    ${status.label}

                </div>

            </td>

        </tr>

        `;

    }).join('');

}

function renderRecommendations(data) {

    const body =
        document.getElementById('recommendationsBody');

    const items = data.items || [];

    if (!items.length) {

        body.innerHTML =
        `<tr>
            <td colspan="2" class="text-center py-6 text-slate-400">
                No recommendations available.
            </td>
        </tr>`;

        return;

    }

    body.innerHTML = items.map(item => `

        <tr>

            <td class="p-3 font-bold">
                ${escapeHTML(item.product)}
            </td>

            <td class="p-3">
                ${escapeHTML(item.recommendation)}
            </td>

        </tr>

    `).join('');

}
async function loadForecastData() {

    const filters = currentFilters();

    const query = buildQuery(filters);

    // ==========================
    // KPI Cards
    // ==========================
    fetchJSON(ENDPOINTS.forecastSummary + query)
        .then(renderStatCards)
        .catch(() => {

            document.getElementById('statsRow').innerHTML = `
                <div class="col-span-full bg-red-50 border border-red-200 rounded-xl p-4 text-red-600 text-sm font-semibold">
                    Could not load forecast statistics.
                </div>
            `;

        });

    // ==========================
    // Chart
    // ==========================
    fetchJSON(ENDPOINTS.historicalVsForecast + query)
        .then(renderForecastChart)
        .catch(() => {

            document.getElementById('chartLoadingMsg').textContent =
                'Could not load chart data.';

            document.getElementById('chartLoadingMsg')
                .classList.remove('hidden');

            document.getElementById('salesForecastChart')
                .classList.add('hidden');

        });

    // ==========================
    // Product Forecast
    // ==========================
    fetchJSON(ENDPOINTS.productForecast + query)
        .then(renderProductForecast)
        .catch(() => {

            document.getElementById('productForecastBody').innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-6 text-red-500">
                        Could not load product forecast.
                    </td>
                </tr>
            `;

        });

    // ==========================
    // Recommendations
    // ==========================
    fetchJSON(ENDPOINTS.recommendations + query)
        .then(renderRecommendations)
        .catch(() => {

            document.getElementById('recommendationsBody').innerHTML = `
                <tr>
                    <td colspan="2" class="text-center py-6 text-red-500">
                        Could not load recommendations.
                    </td>
                </tr>
            `;

        });

}


// ==========================
// Load page
// ==========================
document.addEventListener('DOMContentLoaded', () => {

    loadCategories();

    loadForecastData();

});

</script>

@endpush