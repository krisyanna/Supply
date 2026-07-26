@php
    // Active-state flags — computed once from the current route, so this
    // partial doesn't need to be told anything by the page that includes it.
    $isHome = request()->routeIs('home');
    $isForecasting = request()->routeIs('forecasting.*');
    $isProcurement = request()->routeIs('procurement.*');
    $isLogistics = request()->routeIs('logistics.*');
    $isInventory = request()->routeIs('inventory');

    // Shared class strings so every nav item / sub-item stays visually consistent.
    $parentActive = 'bg-slate-800 text-white border border-slate-700/60 shadow-sm';
    $parentInactive = 'text-slate-300 hover:text-white hover:bg-slate-800 group';
    $leafActive = 'text-white bg-indigo-600/30 border border-indigo-500/30';
    $leafInactive = 'text-slate-400 hover:text-white hover:bg-slate-800';
@endphp

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
                <span class="text-[10px] text-indigo-400 font-extrabold uppercase tracking-wider">ERP Suite v2.5</span>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto">
        <div class="px-3 pb-2">
            <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-500">Core Modules</span>
        </div>

        {{-- HOME DASHBOARD --}}
        <a href="{{ route('home') }}"
           class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-xs transition {{ $isHome ? $parentActive : $parentInactive }}">
            <svg class="w-4 h-4 transition {{ $isHome ? 'text-indigo-400' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>Home Dashboard</span>
        </a>

        {{-- DEMAND FORECASTING --}}
        <div class="space-y-1">
            <button type="button" onclick="toggleSubmenu('forecasting-submenu', 'forecasting-chevron')"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-xs transition {{ $isForecasting ? $parentActive : $parentInactive }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-indigo-400 transition {{ !$isForecasting ? 'group-hover:text-indigo-300' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span>Demand Forecasting</span>
                </div>
                <svg id="forecasting-chevron" class="w-3.5 h-3.5 transition-transform duration-300 {{ $isForecasting ? 'text-white rotate-180' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="forecasting-submenu" class="submenu-transition {{ $isForecasting ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} pl-9 pr-2 space-y-1">
                <a href="{{ route('forecasting.demand') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('forecasting.demand') ? $leafActive : $leafInactive }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="4" y="12" width="3" height="8" rx="1"></rect>
                        <rect x="10.5" y="7" width="3" height="13" rx="1"></rect>
                        <rect x="17" y="3" width="3" height="17" rx="1"></rect>
                    </svg>
                    <span>Forecasting</span>
                </a>
            </div>
        </div>

        {{-- PROCUREMENT --}}
        <div class="space-y-1">
            <button type="button" onclick="toggleSubmenu('procurement-submenu', 'procurement-chevron')"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-xs transition {{ $isProcurement ? $parentActive : $parentInactive }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 transition {{ $isProcurement ? 'text-indigo-400' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Procurement</span>
                </div>
                <svg id="procurement-chevron" class="w-3.5 h-3.5 transition-transform duration-300 {{ $isProcurement ? 'text-white rotate-180' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            
            <div id="procurement-submenu" class="submenu-transition {{ $isProcurement ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} pl-7 pr-2 space-y-1">
                <a href="{{ route('procurement.reorder') }}"
                   class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('procurement.reorder') ? $leafActive : $leafInactive }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2 2 4-4"></path>
                    </svg>
                    <span>Reorder Recommendations</span>
                </a>
                <a href="{{ route('procurement.suppliers') }}"
                   class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('procurement.suppliers') ? $leafActive : $leafInactive }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 010 7.75"></path>
                    </svg>
                    <span>Supplier Management</span>
                </a>
                <a href="{{ route('procurement.po-management') }}"
                   class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('procurement.po-management') ? $leafActive : $leafInactive }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Purchase Order Management</span>
                </a>
                <a href="{{ route('procurement.goods-receipt') }}"
                   class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('procurement.goods-receipt') ? $leafActive : $leafInactive }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"></path>
                    </svg>
                    <span>Goods Receipt &amp; Invoices</span>
                </a>
            </div>
        </div>

        {{-- LOGISTICS SUB-MODULE --}}
        <div class="space-y-1">
            <button type="button" onclick="toggleSubmenu('logistics-submenu', 'logistics-chevron')"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-xs transition {{ $isLogistics ? $parentActive : $parentInactive }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-emerald-400 transition {{ !$isLogistics ? 'group-hover:text-emerald-300' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Logistics Sub-Module</span>
                </div>
                <svg id="logistics-chevron" class="w-3.5 h-3.5 transition-transform duration-300 {{ $isLogistics ? 'text-white rotate-180' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div id="logistics-submenu" class="submenu-transition {{ $isLogistics ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} pl-7 pr-2 space-y-1">
                {{-- These 4 all point at the same route since Logistics is a
                     single page with JS tabs (switchTab), not separate routes.
                     If you later add ?tab= deep-linking, swap these hrefs for
                     route('logistics.dashboard', ['tab' => 'schedules']) etc. --}}
                <a href="{{ route('logistics.dashboard') }}" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ $leafInactive }}">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Shipment Schedules</span>
                </a>
                <a href="{{ route('logistics.dashboard') }}" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ $leafInactive }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    </svg>
                    <span>Delivery Tracking</span>
                </a>
                <a href="{{ route('logistics.dashboard') }}" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ $leafInactive }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <span>Shipping Routes</span>
                </a>
                <a href="{{ route('logistics.dashboard') }}" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition {{ $leafInactive }}">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span>Transportation Status</span>
                </a>
            </div>
        </div>

        {{-- INVENTORY & WAREHOUSE — left as a plain link for now, per your note --}}
        <a href="{{ route('inventory') }}"
           class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-xs transition {{ $isInventory ? $parentActive : $parentInactive }}">
            <svg class="w-4 h-4 transition {{ $isInventory ? 'text-indigo-400' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0l3-4m0 0l3 4"></path>
            </svg>
            <span>Inventory &amp; Warehouse</span>
        </a>
    </nav>

    <div class="p-4 border-t border-slate-800 bg-slate-950/40">
        <a href="{{ route('welcome') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-rose-300 hover:text-white hover:bg-rose-600/20 font-bold text-xs bg-rose-950/20 border border-rose-500/20 transition">
            {{-- TODO: point this at a real logout route once you add one
                 (e.g. Route::post('/logout', ...)->name('logout')) --}}
            <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Leave System</span>
        </a>
    </div>
</aside>