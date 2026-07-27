<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Supply Chain Sidebar</title>

<!-- Tailwind via CDN (works offline once cached by the browser after first load) -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          sidebarBg: '#0f172a'
        }
      }
    }
  }
</script>

<style>
  body { margin: 0; background: #1e293b; }

  .submenu-transition {
    overflow: hidden;
    transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
  }

  /* Smooth, gentle hover + press feedback */
  .nav-parent, .nav-leaf {
    transition: background-color 0.35s ease, color 0.35s ease, border-color 0.35s ease,
                box-shadow 0.35s ease, transform 0.2s ease;
  }
  .nav-parent:active, .nav-leaf:active {
    transform: scale(0.985);
    transition-duration: 0.1s;
  }

  /* Smooth chevron rotation */
  #forecasting-chevron, #procurement-chevron, #logistics-chevron, #inventory-chevron {
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s ease;
  }

  /* Little pulse when an item becomes active */
  @keyframes activePulse {
    0%   { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.3); }
    100% { box-shadow: 0 0 0 5px rgba(99, 102, 241, 0); }
  }
  .just-activated {
    animation: activePulse 0.6s ease-out;
  }

  .logout-link { transition: background-color 0.35s ease, color 0.35s ease, transform 0.2s ease; }
  .logout-link:active { transform: scale(0.985); transition-duration: 0.1s; }
</style>
</head>
<body>

<aside class="w-72 h-screen bg-sidebarBg text-slate-300 flex flex-col flex-shrink-0 border-r border-slate-800 relative z-20">
    <div class="p-6 border-b border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-extrabold shadow-md border border-indigo-400/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div>
                <span class="text-sm font-bold text-white block leading-tight">Supply Chain</span>
                <span class="text-[10px] text-indigo-400 font-extrabold uppercase tracking-wider">ERP Suite v2.5</span>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto">
        <div class="px-3 pb-2">
            <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-500">Core Modules</span>
        </div>

        <!-- HOME DASHBOARD -->
        <a href="{{ route('dashboard') }}" 
           class="nav-parent w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-xs transition {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-white border border-slate-700/60 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>Home Dashboard</span>
        </a>

        <!-- DEMAND FORECASTING -->
        @php
            $isForecastingActive = request()->routeIs('forecasting.*');
        @endphp
        <div class="space-y-1">
            <button type="button" data-nav-group="forecasting" onclick="toggleSubmenu('forecasting-submenu', 'forecasting-chevron', 'forecasting')"
                    class="nav-parent w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-xs transition {{ $isForecastingActive ? 'bg-slate-800 text-white border border-slate-700/60 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span>Demand Forecasting</span>
                </div>
                <svg id="forecasting-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-300 {{ $isForecastingActive ? 'rotate-180 text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="forecasting-submenu" class="submenu-transition overflow-hidden transition-all duration-300 pl-9 pr-2 space-y-1 {{ $isForecastingActive ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('forecasting.demand') }}" 
                   class="nav-leaf w-full flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('forecasting.demand') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="4" y="12" width="3" height="8" rx="1"></rect>
                        <rect x="10.5" y="7" width="3" height="13" rx="1"></rect>
                        <rect x="17" y="3" width="3" height="17" rx="1"></rect>
                    </svg>
                    <span>Forecasting</span>
                </a>
            </div>
        </div>

        <!-- PROCUREMENT -->
        @php
            $isProcurementActive = request()->routeIs('procurement.*');
        @endphp
        <div class="space-y-1">
            <button type="button" data-nav-group="procurement" onclick="toggleSubmenu('procurement-submenu', 'procurement-chevron', 'procurement')"
                    class="nav-parent w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-xs transition {{ $isProcurementActive ? 'bg-slate-800 text-white border border-slate-700/60 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Procurement</span>
                </div>
                <svg id="procurement-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-300 {{ $isProcurementActive ? 'rotate-180 text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div id="procurement-submenu" class="submenu-transition overflow-hidden transition-all duration-300 pl-7 pr-2 space-y-1 {{ $isProcurementActive ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('procurement.suppliers') }}" 
                   class="nav-leaf w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('procurement.suppliers') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 010 7.75"></path>
                    </svg>
                    <span>Supplier Management</span>
                </a>
                <a href="{{ route('procurement.po-management') }}" 
                   class="nav-leaf w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('procurement.po-management') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Purchase Order Management</span>
                </a>
            </div>
        </div>

        <!-- LOGISTICS SUB-MODULE -->
        @php
            $isLogisticsActive = request()->routeIs('logistics.*');
        @endphp
        <div class="space-y-1">
            <button type="button" data-nav-group="logistics" onclick="toggleSubmenu('logistics-submenu', 'logistics-chevron', 'logistics')"
                    class="nav-parent w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-xs transition {{ $isLogisticsActive ? 'bg-slate-800 text-white border border-slate-700/60 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Logistics Sub-Module</span>
                </div>
                <svg id="logistics-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-300 {{ $isLogisticsActive ? 'rotate-180 text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div id="logistics-submenu" class="submenu-transition overflow-hidden transition-all duration-300 pl-7 pr-2 space-y-1 {{ $isLogisticsActive ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('logistics.dashboard', ['tab' => 'schedules']) }}" class="nav-leaf w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('logistics.*') && request('tab') == 'schedules' ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Shipment Schedules</span>
                </a>
                <a href="{{ route('logistics.dashboard', ['tab' => 'tracking']) }}" class="nav-leaf w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('logistics.*') && request('tab') == 'tracking' ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    </svg>
                    <span>Delivery Tracking</span>
                </a>
                <a href="{{ route('logistics.dashboard', ['tab' => 'routes']) }}" class="nav-leaf w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('logistics.*') && request('tab') == 'routes' ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <span>Shipping Routes</span>
                </a>
                <a href="{{ route('logistics.dashboard', ['tab' => 'status']) }}" class="nav-leaf w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('logistics.*') && request('tab') == 'status' ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span>Transportation Status</span>
                </a>
            </div>
        </div>

        <!-- INVENTORY & WAREHOUSE -->
        @php
            $isInventoryActive = request()->routeIs('inventory.*');
        @endphp
        <div class="space-y-1">
            <button type="button" data-nav-group="inventory" onclick="toggleSubmenu('inventory-submenu', 'inventory-chevron', 'inventory')"
                    class="nav-parent w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-xs transition {{ $isInventoryActive ? 'bg-slate-800 text-white border border-slate-700/60 shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0l3-4m0 0l3 4"></path>
                    </svg>
                    <span>Inventory & Warehouse</span>
                </div>
                <svg id="inventory-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-300 {{ $isInventoryActive ? 'rotate-180 text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div id="inventory-submenu" class="submenu-transition overflow-hidden transition-all duration-300 pl-7 pr-2 space-y-1 {{ $isInventoryActive ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('inventory.index') }}" 
                   class="nav-leaf w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('inventory.index') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Stock Ledger</span>
                </a>
                <a href="{{ route('inventory.warehouse-locations') }}" 
                   class="nav-leaf w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('inventory.warehouse-locations') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <circle cx="12" cy="11" r="2.5"></circle>
                    </svg>
                    <span>Warehouse Locations</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar Footer / Logout Button (Properly Aligned) -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/40">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" onclick="return confirm('Are you sure you want to leave the system?');" class="logout-link w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-rose-300 hover:text-white hover:bg-rose-600/20 font-bold text-xs bg-rose-950/20 border border-rose-500/20">
                <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Leave System</span>
            </button>
        </form>
    </div>
</aside>

<script>
  function toggleSubmenu(submenuId, chevronId, group) {
    const submenu = document.getElementById(submenuId);
    const chevron = document.getElementById(chevronId);
    const isOpen = submenu.classList.contains('max-h-96');

    document.querySelectorAll('.submenu-transition').forEach(el => {
      el.classList.remove('max-h-96', 'opacity-100');
      el.classList.add('max-h-0', 'opacity-0');
    });
    document.querySelectorAll('[id$="-chevron"]').forEach(el => {
      el.classList.remove('rotate-180', 'text-white');
      el.classList.add('text-slate-400');
    });

    if (!isOpen) {
      submenu.classList.remove('max-h-0', 'opacity-0');
      submenu.classList.add('max-h-96', 'opacity-100');
      chevron.classList.remove('text-slate-400');
      chevron.classList.add('rotate-180', 'text-white');
    }
  }
</script>