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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
<script>
const API_BASE_URL = '';

const ENDPOINTS = {
    currentUser:       `${API_BASE_URL}/api/users/me`,
    dashboardSummary:  `${API_BASE_URL}/api/dashboard/summary`,
    inventoryOverview: `${API_BASE_URL}/api/dashboard/inventory-overview`,
    stockReminders:    `${API_BASE_URL}/api/dashboard/stock-reminders`,
    recentActivities:  `${API_BASE_URL}/api/dashboard/recent-activities`
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

async function initDashboard() {
    document.getElementById('pageSubtitle').textContent = 'Overview of your supply chain, live from the database.';

    fetchJSON(ENDPOINTS.currentUser).then(renderUser).catch(() => { document.getElementById('userName').textContent = 'there!'; });

    fetchJSON(ENDPOINTS.dashboardSummary).then(renderStatCards).catch(() => {
        document.getElementById('statsRow').innerHTML = `<div class="col-span-full text-xs font-semibold text-rose-600">Could not load dashboard stats.</div>`;
    });

    fetchJSON(ENDPOINTS.inventoryOverview).then(renderInventoryDonut).catch(() => {
        document.getElementById('donutLegend').innerHTML = `<div class="text-xs font-semibold text-rose-600">Could not load inventory overview.</div>`;
    });

    fetchJSON(ENDPOINTS.stockReminders).then(renderStockReminders).catch(() => {
        document.getElementById('stockReminderBody').innerHTML = `<tr><td colspan="2" class="py-6 text-center text-rose-600">Could not load stock reminders.</td></tr>`;
    });

    fetchJSON(ENDPOINTS.recentActivities).then(renderRecentActivities).catch(() => {
        document.getElementById('activityBody').innerHTML = `<tr><td colspan="2" class="py-6 text-center text-rose-600">Could not load recent activity.</td></tr>`;
    });
}

function formatNumber(n) { return typeof n === 'number' ? n.toLocaleString() : n; }
function escapeHTML(str) {
    if (str === null || str === undefined) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

document.addEventListener('DOMContentLoaded', initDashboard);
</script>
@endpush