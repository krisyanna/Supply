    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supply Chain ERP — Home</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
    <style>
    :root{
        --sidebar-bg:#0F172A;
        --accent:#4F46E5;
        --accent-light:#6366F1;
        --teal:#2DD4BF;
        --orange:#f5a623;
        --red:#ef5b5b;
        --green:#2ecc71;
        --blue:#60A5FA;
        --text-dark:#1c2033;
        --text-gray:#8a8fa3;
        --border:#eef0f6;
        --bg:#f5f6fa;
        --card:#ffffff;
    }
    *{box-sizing:border-box;}
    body{margin:0;font-family:'Segoe UI',system-ui,-apple-system,Arial,sans-serif;background:var(--bg);color:var(--text-dark);}
    .app{display:flex;min-height:100vh;}

    /* Sidebar */
    .sidebar{
        width:260px;background:var(--sidebar-bg);
        color:#fff;display:flex;flex-direction:column;padding:24px 16px;flex-shrink:0;
    }
    .brand{display:flex;align-items:center;gap:12px;padding:0 8px 28px 8px;}
    .brand-icon{
        width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,var(--accent),var(--accent-light));
        display:flex;align-items:center;justify-content:center;flex-shrink:0;
    }
    .brand-icon svg{width:22px;height:22px;stroke:#fff;}
    .brand-name{font-size:16px;font-weight:700;line-height:1.2;}
    .brand-sub{font-size:11px;letter-spacing:.06em;color:#8890b5;font-weight:600;}

    .nav{flex:1;display:flex;flex-direction:column;gap:2px;margin-top:4px;overflow-y:auto;}
    .nav-section-label{
        font-size:11px;font-weight:700;letter-spacing:.08em;color:#5b6285;text-transform:uppercase;
        padding:14px 12px 8px 12px;
    }
    .nav-item{
        display:flex;align-items:center;gap:12px;padding:11px 12px;border-radius:10px;
        color:#c3c7de;font-size:14.5px;font-weight:500;cursor:pointer;text-decoration:none;
        transition:background .15s;
    }
    .nav-item svg{width:18px;height:18px;flex-shrink:0;stroke:currentColor;}
    .nav-item:hover{background:rgba(255,255,255,.06);color:#fff;}
    .nav-item.active{background:rgba(79,70,229,0.3);color:#fff;font-weight:600;}
    .nav-item.active svg{stroke:#fff !important;}
    .nav-item.parent-active{background:#1E293B;color:#fff;font-weight:600;}
    .nav-item .chev{margin-left:auto;width:14px;height:14px;opacity:.7;}

    .sub-nav{display:flex;flex-direction:column;gap:2px;padding:2px 0 6px 0;}
    .sub-nav-item{
        display:flex;align-items:center;gap:10px;padding:9px 12px 9px 40px;border-radius:10px;
        color:#c3c7de;font-size:13.5px;font-weight:500;cursor:pointer;text-decoration:none;
    }
    .sub-nav-item svg{width:15px;height:15px;flex-shrink:0;stroke:currentColor;}
    .sub-nav-item:hover{background:rgba(255,255,255,.06);color:#fff;}
    .sub-nav-item.active{background:rgba(79,70,229,0.3);color:#fff;font-weight:600;}
    .sub-nav-item.active svg{stroke:#fff !important;}

    .nav-footer{margin-top:12px;}
    .leave-btn{
        display:flex;align-items:center;gap:10px;justify-content:center;
        padding:11px;border-radius:10px;border:1.5px solid rgba(239,68,68,.35);
        color:#F87171;font-size:14px;font-weight:600;cursor:pointer;background:rgba(239,68,68,.08);
        text-decoration:none;
    }
    .leave-btn svg{width:16px;height:16px;stroke:currentColor;}

    /* Main */
    .main{flex:1;display:flex;flex-direction:column;min-width:0;}
    .topbar{
        background:var(--card);border-bottom:1px solid var(--border);
        padding:22px 32px;display:flex;align-items:center;justify-content:space-between;
    }
    .topbar h1{font-size:22px;margin:0 0 4px 0;font-weight:800;}
    .topbar p{margin:0;color:var(--text-gray);font-size:13.5px;}
    .search{
        display:flex;align-items:center;gap:8px;background:var(--bg);border:1px solid var(--border);
        border-radius:10px;padding:9px 14px;color:var(--text-gray);font-size:13.5px;min-width:260px;
    }
    .search svg{width:16px;height:16px;stroke:var(--text-gray);flex-shrink:0;}

    .content{padding:28px 32px;}

    .greeting{font-size:26px;font-weight:800;margin:4px 0 22px 0;}
    .greeting span{color:var(--accent);}

    .stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:22px;}
    .stat-card{
        background:var(--card);border-radius:16px;padding:20px;border:1px solid var(--border);
        display:flex;flex-direction:column;gap:6px;position:relative;overflow:hidden;
    }
    .stat-top{display:flex;align-items:flex-start;justify-content:space-between;}
    .stat-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon svg{width:19px;height:19px;stroke:#fff;}
    .stat-label{font-size:11.5px;font-weight:700;letter-spacing:.03em;color:var(--text-gray);text-transform:uppercase;}
    .stat-value{font-size:30px;font-weight:800;color:var(--text-dark);}
    .stat-note{font-size:12px;color:var(--text-gray);}

    .panels-row{display:grid;grid-template-columns:1.4fr 1fr;gap:18px;margin-bottom:18px;}
    .panel{background:var(--card);border-radius:16px;border:1px solid var(--border);padding:22px;}
    .panel h3{margin:0 0 16px 0;font-size:16px;font-weight:700;}

    .donut-wrap{display:flex;align-items:center;gap:24px;}
    .legend{display:flex;flex-direction:column;gap:10px;font-size:13px;color:var(--text-dark);flex-shrink:0;}
    .legend-item{display:flex;align-items:center;gap:8px;}
    .dot{width:9px;height:9px;border-radius:50%;flex-shrink:0;}

    table{width:100%;border-collapse:collapse;font-size:13.5px;}
    th{text-align:left;color:var(--text-gray);font-weight:700;font-size:11.5px;letter-spacing:.03em;text-transform:uppercase;padding:0 0 10px 0;border-bottom:1px solid var(--border);}
    td{padding:11px 0;border-bottom:1px solid var(--border);color:var(--text-dark);}
    tr:last-child td{border-bottom:none;}
    .badge{padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700;display:inline-block;}
    .badge.out{background:#fde8e8;color:var(--red);}
    .badge.low{background:#fff4dd;color:#c8860d;}
    .badge.over{background:#e9e6ff;color:var(--accent);}
    .badge.restocked{background:#e4f9ee;color:#1fa860;}
    .badge.in-stock{background:#e4f9ee;color:#1c6e4a;}
    .badge.reserved{background:#e7e7fb;color:#3b3f8f;}

    .activity-panel{background:var(--card);border-radius:16px;border:1px solid var(--border);padding:22px;}
    .activity-panel h3{margin:0 0 16px 0;font-size:16px;font-weight:700;}
    .time-col{color:var(--text-gray);width:110px;}

    /* Loading / empty / error states */
    .state-row td{color:var(--text-gray);text-align:center;padding:22px 0;font-style:italic;}
    .skeleton{background:linear-gradient(90deg,#eef0f6 25%,#f6f7fb 37%,#eef0f6 63%);background-size:400% 100%;animation:shimmer 1.4s ease infinite;border-radius:6px;}
    @keyframes shimmer{0%{background-position:100% 50%;}100%{background-position:0 50%;}}
    .stat-value.skeleton{width:70px;height:28px;display:inline-block;}
    .stat-note.skeleton{width:110px;height:12px;display:inline-block;}
    .panel-error{color:var(--red);font-size:13px;padding:12px 0;}
    </style>
    </head>
    <body>
    <div class="app">

    <aside class="sidebar">
        <div class="brand">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
        </div>
        <div>
            <div class="brand-name">Supply Chain</div>
            <div class="brand-sub">ERP SUITE V2.5</div>
        </div>
        </div>

        <nav class="nav">
        <div class="nav-section-label">Core Modules</div>

        <a class="nav-item active" href="home.php">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Home Dashboard
        </a>

        <a class="nav-item" href="forecasting.php">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
            Demand Forecasting
            <svg class="chev" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </a>

        <a class="nav-item" href="procurement.php">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Procurement &amp; Suppliers
        </a>
    <a class="nav-item" href="{{ route('logistics.dashboard') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="16" x2="12" y2="12"/>
            <line x1="12" y1="8" x2="12.01" y2="8"/>
        </svg>

        Logistics Sub-Module

        <svg class="chev" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"/>
        </svg>
    </a>
        <!-- Sub-menu (1. Shipment Schedules / 2. Delivery Tracking / 3. Shipping
            Routes / 4. Transportation Status) only renders/expands while inside
            the Logistics section. On the Home Dashboard it stays collapsed. -->

        <a class="nav-item" href="inventory.php">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41L11 3.83V2h1.83l9.58 9.59a2 2 0 0 1 0 2.82l-7.18 7.18a2 2 0 0 1-2.82 0L2.83 12"/></svg>
            Inventory &amp; Warehouse
        </a>
        </nav>

        <div class="nav-footer">
        <a href="welcome.php" class="leave-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Leave System
        </a>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
        <div>
            <h1 id="pageTitle">Home</h1>
            <p id="pageSubtitle">Loading dashboard…</p>
        </div>
        <div class="search">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Search
        </div>
        </div>

        <div class="content">
        <div class="greeting">Welcome back, <span id="userName">…</span></div>

        <!-- Stat cards are rendered entirely from JS -> renderStatCards() -->
        <div class="stats-row" id="statsRow"></div>

        <div class="panels-row">
            <div class="panel">
            <h3>Inventory Overview</h3>
            <div class="donut-wrap">
                <canvas id="inventoryDonut" width="190" height="190"></canvas>
                <div class="legend" id="donutLegend"></div>
            </div>
            </div>

            <div class="panel">
            <h3>Stock Reminder</h3>
            <table>
                <thead><tr><th>Product</th><th>Status</th></tr></thead>
                <tbody id="stockReminderBody">
                <tr class="state-row"><td colspan="2">Loading…</td></tr>
                </tbody>
            </table>
            </div>
        </div>

        <div class="activity-panel">
            <h3>Recent Activities</h3>
            <table>
            <thead><tr><th class="time-col">Time</th><th>Activity</th></tr></thead>
            <tbody id="activityBody">
                <tr class="state-row"><td colspan="2">Loading…</td></tr>
            </tbody>
            </table>
        </div>
        </div>
    </main>
    </div>

    <script>
    /* =========================================================================
    CONFIG — point these at your real backend.
    Every endpoint is expected to return JSON in the shape documented above
    each render function below. Adjust paths/shapes to match your API.
    ========================================================================= */
    const API_BASE_URL = ''; // e.g. 'https://api.yourapp.com' — leave '' for same-origin

    const ENDPOINTS = {
    currentUser:      `${API_BASE_URL}/api/users/me`,
    dashboardSummary: `${API_BASE_URL}/api/dashboard/summary`,          // total inventory, orders, shipments, suppliers
    inventoryOverview:`${API_BASE_URL}/api/dashboard/inventory-overview`, // donut breakdown
    stockReminders:   `${API_BASE_URL}/api/dashboard/stock-reminders`,  // low/out-of-stock/overstock list
    recentActivities: `${API_BASE_URL}/api/dashboard/recent-activities`
    };

    /* Icon set used by the stat cards, keyed by an id the API can return
    in dashboardSummary.stats[i].icon, so the backend controls which
    icon+color each card gets without the frontend hardcoding content. */
    const ICONS = {
    box: {
        color: 'var(--accent)',
        svg: '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>'
    },
    orders: {
        color: 'var(--teal)',
        svg: '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>'
    },
    shipment: {
        color: 'var(--orange)',
        svg: '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>'
    },
    suppliers: {
        color: 'var(--green)',
        svg: '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
    }
    };

    /* Maps a status string coming from the API to a badge CSS class + label.
    Adjust the keys to match whatever your backend actually sends
    (e.g. 'out_of_stock', 'low_stock', 'overstocked', 'restocked'). */
    const STOCK_STATUS_MAP = {
    out_of_stock: { label: 'Out of stock', className: 'out' },
    low_stock:    { label: 'Low stock',    className: 'low' },
    overstocked:  { label: 'Overstocked',  className: 'over' },
    restocked:    { label: 'Restocked',    className: 'restocked' },
    in_stock:     { label: 'In stock',     className: 'in-stock' }
    };

    /* Fixed color per inventory-overview segment. Keys must match whatever
    category names the API returns in inventoryOverview.segments[i].key */
    const DONUT_COLORS = {
    in_stock:  '#1c6e4a',
    restocked: '#2ecc71',
    low_stock: '#f5d547',
    out_of_stock: '#ef5b5b',
    reserved:  '#3b3f8f'
    };

    let donutChart = null;

    /* =========================================================================
    FETCH HELPER
    ========================================================================= */
    async function fetchJSON(url, options = {}) {
    const res = await fetch(url, {
        headers: { 'Content-Type': 'application/json' },
        // credentials: 'include', // uncomment if your API relies on cookies/session auth
        // headers: { ...defaultHeaders, Authorization: `Bearer ${getToken()}` },
        ...options
    });
    if (!res.ok) {
        throw new Error(`Request to ${url} failed with status ${res.status}`);
    }
    return res.json();
    }

    /* =========================================================================
    RENDER FUNCTIONS — each takes API data and paints the DOM.
    No business data is hardcoded in the markup above; everything below
    is a template driven purely by whatever the API returns.
    ========================================================================= */

    function renderUser(user) {
    document.getElementById('userName').textContent = (user && user.firstName) ? `${user.firstName}!` : 'there!';
    }

    // Expected shape: { stats: [{ id, label, value, note, icon }] }
    function renderStatCards(summary) {
    const row = document.getElementById('statsRow');
    row.innerHTML = '';

    const stats = (summary && summary.stats) || [];
    if (stats.length === 0) {
        row.innerHTML = `<div class="panel-error">No dashboard stats available.</div>`;
        return;
    }

    stats.forEach(stat => {
        const icon = ICONS[stat.icon] || ICONS.box;
        const card = document.createElement('div');
        card.className = 'stat-card';
        card.innerHTML = `
        <div class="stat-top">
            <div class="stat-icon" style="background:${icon.color};">${icon.svg}</div>
        </div>
        <div class="stat-label">${escapeHTML(stat.label)}</div>
        <div class="stat-value">${escapeHTML(formatNumber(stat.value))}</div>
        <div class="stat-note">${escapeHTML(stat.note || '')}</div>
        `;
        row.appendChild(card);
    });
    }

    // Expected shape: { segments: [{ key, label, value }] }
    function renderInventoryDonut(overview) {
    const segments = (overview && overview.segments) || [];
    const legend = document.getElementById('donutLegend');
    legend.innerHTML = '';

    if (segments.length === 0) {
        legend.innerHTML = `<div class="panel-error">No inventory data available.</div>`;
        if (donutChart) { donutChart.destroy(); donutChart = null; }
        return;
    }

    segments.forEach(seg => {
        const color = DONUT_COLORS[seg.key] || '#999';
        const item = document.createElement('div');
        item.className = 'legend-item';
        item.innerHTML = `<span class="dot" style="background:${color};"></span>${escapeHTML(seg.label)}`;
        legend.appendChild(item);
    });

    const ctx = document.getElementById('inventoryDonut').getContext('2d');
    const chartData = {
        labels: segments.map(s => s.label),
        datasets: [{
        data: segments.map(s => s.value),
        backgroundColor: segments.map(s => DONUT_COLORS[s.key] || '#999'),
        borderWidth: 0,
        cutout: '68%'
        }]
    };

    if (donutChart) {
        donutChart.data = chartData;
        donutChart.update();
    } else {
        donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: chartData,
        options: { responsive: false, plugins: { legend: { display: false } } }
        });
    }
    }

    // Expected shape: { items: [{ id, product, status }] }
    function renderStockReminders(data) {
    const body = document.getElementById('stockReminderBody');
    const items = (data && data.items) || [];

    if (items.length === 0) {
        body.innerHTML = `<tr class="state-row"><td colspan="2">No stock alerts right now.</td></tr>`;
        return;
    }

    body.innerHTML = items.map(item => {
        const status = STOCK_STATUS_MAP[item.status] || { label: item.status, className: '' };
        return `
        <tr>
            <td>${escapeHTML(item.product)}</td>
            <td><span class="badge ${status.className}">${escapeHTML(status.label)}</span></td>
        </tr>
        `;
    }).join('');
    }

    // Expected shape: { items: [{ id, time, activity }] }
    function renderRecentActivities(data) {
    const body = document.getElementById('activityBody');
    const items = (data && data.items) || [];

    if (items.length === 0) {
        body.innerHTML = `<tr class="state-row"><td colspan="2">No recent activity.</td></tr>`;
        return;
    }

    body.innerHTML = items.map(item => `
        <tr>
        <td class="time-col">${escapeHTML(item.time)}</td>
        <td>${escapeHTML(item.activity)}</td>
        </tr>
    `).join('');
    }

    function renderError(sectionEl, message) {
    sectionEl.innerHTML = `<div class="panel-error">${escapeHTML(message)}</div>`;
    }

    /* =========================================================================
    INIT — fetch everything the page needs and render it.
    Each section fails independently so one broken endpoint doesn't blank
    the whole page.
    ========================================================================= */
    async function initDashboard() {
    document.getElementById('pageSubtitle').textContent = 'Overview of your supply chain, live from the database.';

    // Current user / greeting
    fetchJSON(ENDPOINTS.currentUser)
        .then(renderUser)
        .catch(() => { document.getElementById('userName').textContent = 'there!'; });

    // Top stat cards
    fetchJSON(ENDPOINTS.dashboardSummary)
        .then(renderStatCards)
        .catch(err => renderError(document.getElementById('statsRow'), 'Could not load dashboard stats.'));

    // Inventory donut
    fetchJSON(ENDPOINTS.inventoryOverview)
        .then(renderInventoryDonut)
        .catch(err => renderError(document.getElementById('donutLegend'), 'Could not load inventory overview.'));

    // Stock reminders
    fetchJSON(ENDPOINTS.stockReminders)
        .then(renderStockReminders)
        .catch(err => {
        document.getElementById('stockReminderBody').innerHTML =
            `<tr class="state-row"><td colspan="2">Could not load stock reminders.</td></tr>`;
        });

    // Recent activities
    fetchJSON(ENDPOINTS.recentActivities)
        .then(renderRecentActivities)
        .catch(err => {
        document.getElementById('activityBody').innerHTML =
            `<tr class="state-row"><td colspan="2">Could not load recent activity.</td></tr>`;
        });
    }

    /* =========================================================================
    Small utils
    ========================================================================= */
    function formatNumber(n) {
    if (typeof n !== 'number') return n;
    return n.toLocaleString();
    }
    function escapeHTML(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    document.addEventListener('DOMContentLoaded', initDashboard);
    </script>
    </body>
    </html>
