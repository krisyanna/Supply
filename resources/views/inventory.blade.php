<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventory & Warehouse Management</title>

<!-- Tailwind CSS CDN (for sidebar) -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                colors: {
                    sidebarBg: '#0f172a',
                    sidebarActive: '#1e293b',
                    brandIndigo: '#4f46e5',
                }
            }
        }
    }
</script>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
  .submenu-transition{ transition:max-height .3s cubic-bezier(.4,0,.2,1), opacity .2s ease-in-out; overflow:hidden; }
</style>
<style>
  :root{
    --navy:#171a34;
    --navy-2:#1f2347;
    --accent:#6d5df6;
    --accent-2:#5b4bdb;
    --teal:#17c9b0;
    --text-dark:#1c1f2e;
    --text-muted:#8b8fa3;
    --border:#eceef4;
    --bg:#f4f5f9;
    --green:#1fae6b;
    --green-bg:#e6f8ef;
    --amber:#c9820a;
    --amber-bg:#fdf1de;
    --red:#e0483a;
    --red-bg:#fceceb;
    --blue:#4b3fd6;
    --blue-bg:#eceafe;
  }
  *{box-sizing:border-box;}
  body{
    margin:0;
    font-family:'Plus Jakarta Sans', "Segoe UI", sans-serif;
    background:var(--bg);
    color:var(--text-dark);
  }

  /* ===== App shell ===== */
  .app{
    display:flex;
    height:100vh;
    overflow:hidden;
  }

  /* ===== Main content ===== */
  .main{
    flex:1;
    padding:36px 44px;
    animation:fadeIn .5s ease;
    overflow-y:auto;
    height:100vh;
  }
  @keyframes fadeIn{
    from{opacity:0; transform:translateY(8px);}
    to{opacity:1; transform:translateY(0);}
  }
  .page-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:28px;
  }
  .page-header h1{margin:0 0 6px 0; font-size:28px; font-weight:800;}
  .page-header p{margin:0; color:var(--text-muted); font-size:14px;}
  .add-btn{
    background:linear-gradient(135deg,var(--accent),var(--accent-2));
    color:#fff;
    border:none;
    padding:14px 22px;
    border-radius:12px;
    font-weight:700;
    font-size:14.5px;
    display:flex;
    align-items:center;
    gap:8px;
    cursor:pointer;
    box-shadow:0 8px 18px rgba(109,93,246,.35);
    transition:transform .18s ease, box-shadow .18s ease, filter .18s ease;
  }
  .add-btn:hover{
    transform:translateY(-3px) scale(1.02);
    box-shadow:0 14px 26px rgba(109,93,246,.45);
    filter:brightness(1.06);
  }
  .add-btn:active{transform:translateY(-1px) scale(.98);}

  /* Stat cards */
  .stats-row{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:28px;
  }
  .stat-card{
    background:#fff;
    border-radius:16px;
    padding:22px 24px;
    border:1px solid var(--border);
    transition:transform .22s ease, box-shadow .22s ease, border-color .22s ease;
    position:relative;
    overflow:hidden;
  }
  .stat-card::after{
    content:"";
    position:absolute;
    inset:0;
    background:radial-gradient(120px circle at var(--mx,50%) var(--my,50%), rgba(109,93,246,.08), transparent 60%);
    opacity:0;
    transition:opacity .25s ease;
    pointer-events:none;
  }
  .stat-card:hover{
    transform:translateY(-6px);
    box-shadow:0 16px 30px rgba(23,26,52,.08);
    border-color:#e2e0fb;
  }
  .stat-card:hover::after{opacity:1;}
  .stat-label{
    font-size:12px;
    font-weight:700;
    letter-spacing:.06em;
    color:var(--text-muted);
    margin-bottom:10px;
    text-transform:uppercase;
  }
  .stat-value{font-size:30px; font-weight:800; color:var(--text-dark);}
  .stat-value.accent-blue{color:var(--blue);}
  .stat-value.accent-amber{color:var(--amber);}
  .stat-value.accent-red{color:var(--red);}

  /* Ledger card */
  .ledger-card{
    background:#fff;
    border-radius:18px;
    border:1px solid var(--border);
    overflow:hidden;
  }
  .ledger-header{
    padding:22px 26px;
    font-size:17px;
    font-weight:700;
    border-bottom:1px solid var(--border);
  }
  table{width:100%; border-collapse:collapse;}
  thead th{
    background:#f6f7fb;
    text-align:left;
    font-size:11.5px;
    font-weight:700;
    letter-spacing:.05em;
    color:var(--text-muted);
    text-transform:uppercase;
    padding:16px 26px;
  }
  tbody tr{
    border-top:1px solid var(--border);
    transition:background .16s ease, transform .16s ease;
  }
  tbody tr:hover{
    background:#f8f8ff;
    transform:scale(1.003);
  }
  tbody td{
    padding:18px 26px;
    font-size:14px;
    vertical-align:top;
  }
  .item-code{
    color:var(--accent-2);
    font-weight:700;
    cursor:pointer;
    transition:color .15s ease;
  }
  .item-code:hover{color:var(--accent);text-decoration:underline;}

  .badge{
    display:inline-block;
    padding:6px 14px;
    border-radius:20px;
    font-size:12.5px;
    font-weight:700;
    transition:transform .15s ease, box-shadow .15s ease;
  }
  tr:hover .badge{transform:translateY(-1px); box-shadow:0 4px 10px rgba(0,0,0,.08);}
  .badge.in-stock{background:var(--green-bg); color:var(--green);}
  .badge.low-stock{background:var(--amber-bg); color:var(--amber);}
  .badge.out-stock{background:var(--red-bg); color:var(--red);}
  .badge.reserved{background:var(--blue-bg); color:var(--blue);}

  .qty-pill{
    font-weight:700;
  }
  .qty-bar-bg{
    width:80px;
    height:6px;
    background:#eceef4;
    border-radius:4px;
    margin-top:6px;
    overflow:hidden;
  }
  .qty-bar-fill{
    height:100%;
    border-radius:4px;
    background:linear-gradient(90deg,var(--teal),var(--accent));
    transition:width .6s ease;
  }

  ::-webkit-scrollbar{height:8px; width:8px;}
  ::-webkit-scrollbar-thumb{background:#d7d9e6;border-radius:4px;}

  /* Uniform line-icon system (main content) */
  .icon{
    width:19px;
    height:19px;
    flex:none;
    stroke:#9497b8;
    fill:none;
    stroke-width:1.9;
    stroke-linecap:round;
    stroke-linejoin:round;
    vertical-align:middle;
  }
  .add-btn{
    display:flex;
    align-items:center;
    gap:8px;
  }
</style>
</head>
<body>

  <div class="app">
    <!-- SIDEBAR NAVIGATION -->
    <aside class="w-72 bg-sidebarBg text-slate-300 flex flex-col flex-shrink-0 border-r border-slate-800 relative z-20">
        <div class="p-6 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-extrabold shadow-md border border-indigo-400/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-sm font-bold text-white block leading-tight">Supply Chain</span>
                    <span class="text-[10px] text-indigo-400 font-extrabold uppercase tracking-wider">ERP SYSTEM</span>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto">
            <div class="px-3 pb-2">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-500">Core Modules</span>
            </div>

            <!-- HOME DASHBOARD -->
            <a href="#" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Home Dashboard</span>
            </a>

            <!-- FORECASTING -->
            <div class="space-y-1">
                <button type="button" onclick="toggleSubmenu('forecasting-submenu','forecasting-chevron')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-indigo-400 group-hover:text-indigo-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span>Forecasting</span>
                    </div>
                    <svg id="forecasting-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="forecasting-submenu" class="submenu-transition max-h-0 opacity-0 pl-9 pr-2 space-y-1">
                    <a href="#" class="block px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-300 hover:text-white hover:bg-indigo-600/30 transition">Demand Planning</a>
                    <a href="#" class="block px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-300 hover:text-white hover:bg-indigo-600/30 transition">Historical Sales Analytics</a>
                </div>
            </div>

            <!-- PROCUREMENT -->
            <a href="#" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Procurement</span>
            </a>

            <!-- LOGISTICS -->
            <div class="space-y-1">
                <button type="button" onclick="toggleSubmenu('logistics-submenu','logistics-chevron')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition font-semibold text-xs group">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-emerald-400 group-hover:text-emerald-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Logistics</span>
                    </div>
                    <svg id="logistics-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="logistics-submenu" class="submenu-transition max-h-0 opacity-0 pl-7 pr-2 space-y-1">
                    <a href="#" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Shipment Schedules</span>
                    </a>
                    <a href="#" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                        <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        <span>Delivery Tracking</span>
                    </a>
                    <a href="#" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                        <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        <span>Shipping Routes</span>
                    </a>
                    <a href="#" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                        <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span>Transportation Status</span>
                    </a>
                </div>
            </div>

            <!-- INVENTORY & WAREHOUSE — ACTIVE (this is the current page) -->
            <div class="space-y-1">
                <button type="button" onclick="toggleSubmenu('inventory-submenu','inventory-chevron')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-800 text-white font-semibold text-xs border border-slate-700/60 shadow-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0l3-4m0 0l3 4"/>
                        </svg>
                        <span>Inventory & Warehouse</span>
                    </div>
                    <svg id="inventory-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-300 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="inventory-submenu" class="submenu-transition pl-7 pr-2 space-y-1" style="max-height:260px; opacity:1;">
                    <a href="#" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-md shadow-indigo-900/30">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.27 6.96L12 12.01l8.73-5.05"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22.08V12"/>
                        </svg>
                        <span>1. Stock Ledger</span>
                    </a>
                    <a href="#" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                        <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <circle cx="12" cy="11" r="2.5"/>
                        </svg>
                        <span>2. Warehouse Locations</span>
                    </a>
                    <a href="#" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                        <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5m11 6v5h-5M4.5 15a8 8 0 0014.9 2.5M19.5 9A8 8 0 004.6 6.5"/>
                        </svg>
                        <span>3. Stock Movements</span>
                    </a>
                    <a href="#" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                        <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.7 21a2 2 0 01-3.4 0"/>
                        </svg>
                        <span>4. Reorder Alerts</span>
                    </a>
                </div>
            </div>
        </nav>

        <div class="p-4 border-t border-slate-800 bg-slate-950/40">
            <a href="#" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-rose-300 hover:text-white hover:bg-rose-600/20 font-bold text-xs bg-rose-950/20 border border-rose-500/20 transition">
                <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Leave System</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main">
      <div class="page-header">
        <div>
          <h1>Inventory & Warehouse Management</h1>
          <p>Standalone UI Mode (No Database Dependency Required)</p>
        </div>
        <button class="add-btn">
          <svg class="icon" viewBox="0 0 24 24" style="stroke:#fff"><path d="M12 5v14M5 12h14"/></svg>
          Add New Stock Item
        </button>
      </div>

      <div class="stats-row">
        <div class="stat-card">
          <div class="stat-label">Total SKUs</div>
          <div class="stat-value">128</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">In Stock</div>
          <div class="stat-value accent-blue">104</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Low / Out of Stock</div>
          <div class="stat-value accent-amber">9</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Inventory Value Total</div>
          <div class="stat-value">₱1,842,300.00</div>
        </div>
      </div>

      <div class="ledger-card">
        <div class="ledger-header">Warehouse Stock Ledger</div>
        <table>
          <thead>
            <tr>
              <th>Item Code</th>
              <th>Item Name</th>
              <th>Warehouse Location</th>
              <th>Category</th>
              <th>Quantity On Hand</th>
              <th>Unit Cost</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="item-code">#INV-3301</td>
              <td>Copper Wiring Spool</td>
              <td>Cavite Depot – Rack A2</td>
              <td>Electronics & Components</td>
              <td>
                <span class="qty-pill">420 pcs</span>
                <div class="qty-bar-bg"><div class="qty-bar-fill" style="width:82%"></div></div>
              </td>
              <td>₱310.00</td>
              <td><span class="badge in-stock">In Stock</span></td>
            </tr>
            <tr>
              <td class="item-code">#INV-3302</td>
              <td>Hydraulic Pump Unit</td>
              <td>Manila Port – Bay 5</td>
              <td>Heavy Machinery</td>
              <td>
                <span class="qty-pill">6 pcs</span>
                <div class="qty-bar-bg"><div class="qty-bar-fill" style="width:8%"></div></div>
              </td>
              <td>₱24,500.00</td>
              <td><span class="badge low-stock">Low Stock</span></td>
            </tr>
            <tr>
              <td class="item-code">#INV-3303</td>
              <td>Galvanized Steel Sheets</td>
              <td>Bulacan Hub – Rack C1</td>
              <td>Raw Materials</td>
              <td>
                <span class="qty-pill">0 pcs</span>
                <div class="qty-bar-bg"><div class="qty-bar-fill" style="width:0%"></div></div>
              </td>
              <td>₱1,150.00</td>
              <td><span class="badge out-stock">Out of Stock</span></td>
            </tr>
            <tr>
              <td class="item-code">#INV-3304</td>
              <td>Industrial Ball Bearings</td>
              <td>Laguna Hub – Rack B4</td>
              <td>Spare Parts</td>
              <td>
                <span class="qty-pill">980 pcs</span>
                <div class="qty-bar-bg"><div class="qty-bar-fill" style="width:95%"></div></div>
              </td>
              <td>₱85.00</td>
              <td><span class="badge in-stock">In Stock</span></td>
            </tr>
            <tr>
              <td class="item-code">#INV-3305</td>
              <td>Safety Helmets (Box of 10)</td>
              <td>Batangas Depot – Rack D3</td>
              <td>PPE & Safety Gear</td>
              <td>
                <span class="qty-pill">45 boxes</span>
                <div class="qty-bar-bg"><div class="qty-bar-fill" style="width:40%"></div></div>
              </td>
              <td>₱1,800.00</td>
              <td><span class="badge reserved">Reserved</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    // Sidebar collapsible submenu toggle
    function toggleSubmenu(submenuId, chevronId){
      const submenu = document.getElementById(submenuId);
      const chevron = document.getElementById(chevronId);
      const isOpen = submenu.style.maxHeight && submenu.style.maxHeight !== '0px';
      if(isOpen){
        submenu.style.maxHeight = '0px';
        submenu.style.opacity = '0';
        chevron.classList.remove('rotate-180');
      } else {
        submenu.style.maxHeight = submenu.scrollHeight + 'px';
        submenu.style.opacity = '1';
        chevron.classList.add('rotate-180');
      }
    }

    // Subtle cursor-follow glow on stat cards
    document.querySelectorAll('.stat-card').forEach(card=>{
      card.addEventListener('mousemove', e=>{
        const rect = card.getBoundingClientRect();
        card.style.setProperty('--mx', (e.clientX - rect.left) + 'px');
        card.style.setProperty('--my', (e.clientY - rect.top) + 'px');
      });
    });

    // Animate quantity bars on load
    window.addEventListener('load', ()=>{
      document.querySelectorAll('.qty-bar-fill').forEach(bar=>{
        const w = bar.style.width;
        bar.style.width = '0%';
        requestAnimationFrame(()=>{
          setTimeout(()=>{ bar.style.width = w; }, 100);
        });
      });
    });

    // ==========================================================
    // API INTEGRATION PLACEHOLDER — left empty on purpose.
    // Other groups' modules will connect here later.
    // ==========================================================

  </script>
</body>
</html>
