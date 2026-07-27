@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-100/70 p-4 lg:p-6">
    <div class="mx-auto max-w-7xl space-y-4">
        <header class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-extrabold tracking-tight text-slate-900">Logistics & Transportation Management</h2>
                    <p class="mt-1 text-sm text-slate-500">Connected procurement approvals, inventory sync, and live logistics response.</p>
                </div>
                <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                    Procurement and inventory linked live
                </div>
            </div>
        </header>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-slate-400">Total purchase orders</p>
                <div class="mt-2 text-2xl font-black text-slate-900">{{ $stats['total_orders'] }}</div>
                <p class="mt-1 text-xs text-slate-500">Synchronized from procurement</p>
            </div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-slate-400">Pending approval</p>
                <div class="mt-2 text-2xl font-black text-indigo-600">{{ $stats['pending_approval'] }}</div>
                <p class="mt-1 text-xs text-slate-500">Awaiting logistics review</p>
            </div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-slate-400">Delayed response</p>
                <div class="mt-2 text-2xl font-black text-amber-600">{{ $stats['delayed_responses'] }}</div>
                <p class="mt-1 text-xs text-slate-500">Needs active follow-up</p>
            </div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-slate-400">Inventory sync</p>
                <div class="mt-2 text-2xl font-black text-slate-900">{{ $inventoryItems }} items / {{ $warehouses }} depots</div>
                <p class="mt-1 text-xs text-slate-500">Updated when orders are approved</p>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200/80 bg-white shadow-sm">
            <div class="flex flex-wrap gap-2 border-b border-slate-200/80 p-4">
                <button type="button" data-tab="approvals" onclick="switchTab('approvals')" class="tab-button rounded-xl border border-slate-200 bg-slate-900 px-3 py-2 text-xs font-semibold text-white">Orders to Approve</button>
                <button type="button" data-tab="schedules" onclick="switchTab('schedules')" class="tab-button rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600">Shipment Schedules</button>
                <button type="button" data-tab="tracking" onclick="switchTab('tracking')" class="tab-button rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600">Delivery Tracking</button>
                <button type="button" data-tab="routes" onclick="switchTab('routes')" class="tab-button rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600">Shipping Routes</button>
                <button type="button" data-tab="status" onclick="switchTab('status')" class="tab-button rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600">Transportation Status</button>
            </div>

            <div id="view-approvals" class="tab-view p-4 lg:p-6">
                <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/60 p-4">
                        <div class="mb-4 flex items-center justify-between gap-3">
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Orders to Approve</h3>
                                <p class="text-xs text-slate-500">Purchase orders coming from procurement for logistics review.</p>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm">
                                <thead class="bg-white text-left text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">
                                    <tr>
                                        <th class="px-3 py-2">PO</th>
                                        <th class="px-3 py-2">Supplier</th>
                                        <th class="px-3 py-2">Amount</th>
                                        <th class="px-3 py-2">Status</th>
                                        <th class="px-3 py-2 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white">
                                    @forelse ($approvalOrders as $po)
                                        @php
                                            $statusColor = match ($po->status) {
                                                'Approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'Delayed' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                default => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                            };
                                        @endphp
                                                    <tr>
                                            <td class="px-3 py-3 font-semibold text-slate-900">{{ $po->po_number }}</td>
                                            <td class="px-3 py-3 text-slate-600">{{ $po->supplier->name ?? 'Supplier TBD' }}</td>
                                            <td class="px-3 py-3 text-slate-600">{{ \Carbon\Carbon::parse($po->order_date)->format('d M Y') }}</td>
                                            <td class="px-3 py-3 text-slate-600">₱{{ number_format($po->total_amount, 2) }}</td>
                                            <td class="px-3 py-3">
                                                <span class="inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold uppercase {{ $statusColor }}">{{ $po->status }}</span>
                                            </td>
                                            <td class="px-3 py-3">
                                                <div class="flex justify-end gap-2">
                                                    <form method="POST" action="{{ route('logistics.purchase-orders.review', ['purchaseOrder' => $po->id]) }}">
                                                        @csrf
                                                        <input type="hidden" name="decision" value="approved">
                                                        <button type="submit" class="rounded-lg border border-emerald-200 bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white">Approve</button>
                                                    </form>
                                                    <form method="POST" action="{{ route('logistics.purchase-orders.review', ['purchaseOrder' => $po->id]) }}">
                                                        @csrf
                                                        <input type="hidden" name="decision" value="declined">
                                                        <button type="submit" class="rounded-lg border border-amber-200 bg-amber-500 px-3 py-1.5 text-xs font-semibold text-white">Decline</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-3 py-4 text-center text-sm text-slate-500">No purchase orders found for logistics review.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($approvalOrders->hasPages())
                            <div class="mt-4 flex items-center justify-between border-t border-slate-200/80 pt-4 text-xs text-slate-500">
                                <span>Showing {{ $approvalOrders->firstItem() }} to {{ $approvalOrders->lastItem() }}</span>
                                <div>{{ $approvalOrders->links('pagination::simple-tailwind') }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-2xl border border-slate-200/80 bg-white p-4">
                            <h4 class="text-sm font-bold text-slate-900">Procurement feed</h4>
                            <div class="mt-3 space-y-2 text-sm text-slate-600">
                                <div class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2">
                                    <span>Pending approval</span>
                                    <span class="font-semibold text-indigo-600">{{ $stats['pending_approval'] }}</span>
                                </div>
                                <div class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2">
                                    <span>Approved today</span>
                                    <span class="font-semibold text-emerald-600">{{ $stats['approved_orders'] }}</span>
                                </div>
                                <div class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2">
                                    <span>Delayed response</span>
                                    <span class="font-semibold text-amber-600">{{ $stats['delayed_responses'] }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200/80 bg-white p-4">
                            <h4 class="text-sm font-bold text-slate-900">Inventory sync state</h4>
                            <p class="mt-2 text-sm text-slate-600">Every approved purchase order is reflected in the inventory view so the warehouse team can see the change immediately.</p>
                            <div class="mt-3 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-700">
                                {{ $inventoryItems }} synchronized inventory items ready for dispatch
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-schedules" class="tab-view hidden p-4 lg:p-6">
                <div class="space-y-4">
                    <div class="rounded-2xl border border-slate-200/80 bg-white p-4">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Shipment Schedules</h3>
                                <p class="text-sm text-slate-500 mt-1">Professional schedule management with fast filters and quick previews.</p>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex flex-wrap items-center gap-1 rounded-full border border-slate-200 bg-slate-50 px-2 py-1">
                                    <button type="button" class="schedule-filter-btn rounded-full border border-slate-200 bg-slate-900 px-2.5 py-1 text-[10px] font-semibold text-white hover:bg-slate-800 hover:text-white" data-status="All">All</button>
                                    <button type="button" class="schedule-filter-btn rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[10px] font-semibold text-slate-700 hover:bg-slate-900 hover:text-white" data-status="In Transit">In Transit</button>
                                    <button type="button" class="schedule-filter-btn rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[10px] font-semibold text-slate-700 hover:bg-slate-900 hover:text-white" data-status="Delayed">Delayed</button>
                                    <button type="button" class="schedule-filter-btn rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[10px] font-semibold text-slate-700 hover:bg-slate-900 hover:text-white" data-status="Delivered">Delivered</button>
                                </div>
                                <div class="flex flex-col gap-2 sm:w-[320px]">
                                    <div class="relative">
                                        <input id="scheduleSearch" type="text" placeholder="Search order, city, or product" class="w-full rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                        <button id="scheduleSearchBtn" type="button" class="absolute right-1 top-1/2 -translate-y-1/2 rounded-full bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-700">Search</button>
                                    </div>
                                    <div class="flex flex-wrap gap-2 text-xs text-slate-500">
                                        <span class="font-semibold text-slate-700">Suggested:</span>
                                        <button type="button" class="search-suggest-btn rounded-full border border-slate-200 bg-slate-100 px-3 py-1 hover:bg-slate-200">Manila</button>
                                        <button type="button" class="search-suggest-btn rounded-full border border-slate-200 bg-slate-100 px-3 py-1 hover:bg-slate-200">Davao</button>
                                        <button type="button" class="search-suggest-btn rounded-full border border-slate-200 bg-slate-100 px-3 py-1 hover:bg-slate-200">GPU</button>
                                        <button type="button" class="search-suggest-btn rounded-full border border-slate-200 bg-slate-100 px-3 py-1 hover:bg-slate-200">In Transit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/60 p-4">
                        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Order preview panel</h4>
                                <p class="text-xs text-slate-500">Use the action buttons to preview order details and open full transportation status.</p>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <span>Sort by</span>
                                <select id="scheduleSort" class="rounded-full border border-slate-200 bg-white px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="orderID">Order ID</option>
                                    <option value="product">Product</option>
                                    <option value="items">Items</option>
                                    <option value="city">City</option>
                                    <option value="status">Status</option>
                                </select>
                                <button id="scheduleSortDir" type="button" class="rounded-full border border-slate-200 bg-white px-3 py-2 text-slate-700">Asc</button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm" id="scheduleTable">
                                <thead class="bg-white text-left text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">
                                    <tr>
                                        <th class="px-3 py-2">Order ID</th>
                                        <th class="px-3 py-2">Product</th>
                                        <th class="px-3 py-2">Items</th>
                                        <th class="px-3 py-2">City</th>
                                        <th class="px-3 py-2">Status</th>
                                        <th class="px-3 py-2 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white" id="scheduleTableBody">
                                    @forelse ($shipments as $shipment)
                                        <tr class="schedule-row" data-order-id="{{ $shipment->orderID }}" data-product="{{ $shipment->product }}" data-city="{{ $shipment->city }}" data-status="{{ $shipment->status }}" data-amount="{{ $shipment->amount }}" data-total="{{ $shipment->total }}" data-contact="{{ $shipment->contact }}" data-remarks="{{ $shipment->remarks }}" data-departure="{{ $shipment->departure }}" data-transit="{{ $shipment->transit }}" data-arrival="{{ $shipment->arrival }}" data-departure-time="{{ $shipment->departureTime }}" data-expected-arrive="{{ $shipment->expectedArrive }}">
                                            <td class="px-2 py-2 font-semibold text-slate-900">{{ $shipment->orderID }}</td>
                                            <td class="px-2 py-2 text-slate-600">{{ $shipment->product }}</td>
                                            <td class="px-2 py-2 text-slate-600">{{ $shipment->items }}</td>
                                            <td class="px-2 py-2 text-slate-600">{{ $shipment->city }}</td>
                                            <td class="px-2 py-2">
                                                <span class="inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold uppercase {{ $shipment->status === 'Delayed' ? 'bg-amber-50 text-amber-700 border-amber-200' : ($shipment->status === 'Delivered' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-indigo-50 text-indigo-700 border-indigo-200') }}">{{ $shipment->status }}</span>
                                            </td>
                                            <td class="px-2 py-2 text-right space-x-1">
                                                <button type="button" class="previewShipmentBtn inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-slate-300 hover:text-slate-900" data-order-id="{{ $shipment->orderID }}" aria-label="Preview order">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </button>
                                                <button type="button" class="messageShipmentBtn inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 hover:border-slate-300 hover:text-slate-900" data-order-id="{{ $shipment->orderID }}" data-contact="{{ $shipment->contact }}" aria-label="Message order">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.81 9.81 0 01-4.255-.88L3 20l.88-4.745A9.816 9.816 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                                </button>
                                                <button type="button" class="callShipmentBtn inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 hover:border-slate-300 hover:text-slate-900" data-order-id="{{ $shipment->orderID }}" data-contact="{{ $shipment->contact }}" aria-label="Call order">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.1 3.299a1 1 0 01-.211.99l-2.2 2.2a11.042 11.042 0 005.516 5.516l2.2-2.2a1 1 0 01.99-.211l3.299 1.1a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.163 21 3 14.837 3 7V5z"></path></svg>
                                                </button>
                                                <button type="button" class="editShipmentBtn inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 hover:border-slate-300 hover:text-slate-900" data-order-id="{{ $shipment->orderID }}" aria-label="Edit order">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6L8 21l-6-6 7-7z"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-3 py-4 text-center text-sm text-slate-500">No shipment schedules available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 rounded-2xl border-t border-slate-200/80 bg-white px-4 py-3 text-xs text-slate-500">
                            Showing 1 to {{ $shipments->count() }} shipment schedules in logistics.
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-tracking" class="tab-view hidden p-4 lg:p-6">
                <div class="grid gap-4 lg:grid-cols-[1.3fr_0.95fr]">
                    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/60 p-4">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Delivery Tracking</h3>
                                <p class="mt-1 text-sm text-slate-500">Search orders and inspect live tracking summaries from the schedule data.</p>
                            </div>
                            <div class="relative w-full max-w-sm">
                                <input id="trackingSearch" type="text" placeholder="Search order, product, or city" class="w-full rounded-full border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                <button id="trackingSearchBtn" type="button" class="absolute right-1 top-1/2 -translate-y-1/2 rounded-full bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-700">Search</button>
                            </div>
                        </div>

                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm" id="trackingTable">
                                <thead class="bg-white text-left text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">
                                    <tr>
                                        <th class="px-2 py-2">Order</th>
                                        <th class="px-2 py-2">Product</th>
                                        <th class="px-2 py-2">City</th>
                                        <th class="px-2 py-2">Status</th>
                                        <th class="px-2 py-2">ETA</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white">
                                    @forelse ($trackingShipments as $shipment)
                                        <tr class="tracking-row hover:bg-slate-50 transition cursor-pointer" data-order-id="{{ $shipment->orderID }}" data-product="{{ $shipment->product }}" data-city="{{ $shipment->city }}" data-status="{{ $shipment->status }}" data-expected-arrive="{{ $shipment->expectedArrive }}" data-contact="{{ $shipment->contact }}" data-remarks="{{ $shipment->remarks }}" data-departure="{{ $shipment->departure }}" data-transit="{{ $shipment->transit }}" data-arrival="{{ $shipment->arrival }}">
                                            <td class="px-2 py-3 font-semibold text-slate-900">{{ $shipment->orderID }}</td>
                                            <td class="px-2 py-3 text-slate-600">{{ $shipment->product }}</td>
                                            <td class="px-2 py-3 text-slate-600">{{ $shipment->city }}</td>
                                            <td class="px-2 py-3 text-slate-600">{{ $shipment->status }}</td>
                                            <td class="px-2 py-3 text-slate-600">{{ $shipment->expectedArrive }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-2 py-4 text-center text-sm text-slate-500">No active shipment tracking data available yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200/80 bg-white p-4">
                        <h3 class="text-base font-bold text-slate-900">Tracking summary</h3>
                        <div class="mt-4 grid gap-3 text-sm text-slate-600">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-[11px] font-semibold uppercase text-slate-400">Order summary</p>
                                <p class="mt-3 text-xl font-black text-slate-900" id="trackingSummaryOrderId">{{ $trackingShipments->first()?->orderID ?? 'No order selected' }}</p>
                                <p class="mt-1 text-sm text-slate-500" id="trackingSummaryProduct">{{ $trackingShipments->first()?->product ?? 'Select an order to view details' }}</p>
                            </div>

                            <div class="grid gap-2 text-sm text-slate-600">
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 flex items-center justify-between">
                                    <span class="font-medium text-slate-700">City</span>
                                    <span id="trackingSummaryCity" class="font-semibold text-slate-900">{{ $trackingShipments->first()?->city ?? '—' }}</span>
                                </div>
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 flex items-center justify-between">
                                    <span class="font-medium text-slate-700">Status</span>
                                    <span id="trackingSummaryStatus" class="font-semibold text-slate-900">{{ $trackingShipments->first()?->status ?? '—' }}</span>
                                </div>
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 flex items-center justify-between">
                                    <span class="font-medium text-slate-700">ETA</span>
                                    <span id="trackingSummaryETA" class="font-semibold text-slate-900">{{ $trackingShipments->first()?->expectedArrive ?? '—' }}</span>
                                </div>
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 flex items-center justify-between">
                                    <span class="font-medium text-slate-700">Contact</span>
                                    <span id="trackingSummaryContact" class="font-semibold text-slate-900">{{ $trackingShipments->first()?->contact ?? '—' }}</span>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-[11px] font-semibold uppercase text-slate-400">Details</p>
                                <div class="mt-2 text-sm leading-6 text-slate-600" id="trackingSummaryRemarks">{{ $trackingShipments->first()?->remarks ?? 'Click a tracking row to load the order summary.' }}</div>
                            </div>

                            <div class="grid gap-2">
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 flex items-center justify-between">
                                    <span class="text-[11px] uppercase tracking-[0.2em] text-slate-400">In transit</span>
                                    <span class="font-semibold text-indigo-700">{{ $trackingStats['in_transit'] }}</span>
                                </div>
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 flex items-center justify-between">
                                    <span class="text-[11px] uppercase tracking-[0.2em] text-slate-400">Delayed</span>
                                    <span class="font-semibold text-amber-700">{{ $trackingStats['delayed_shipments'] }}</span>
                                </div>
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 flex items-center justify-between">
                                    <span class="text-[11px] uppercase tracking-[0.2em] text-slate-400">Total</span>
                                    <span class="font-semibold text-emerald-700">{{ $trackingStats['shipment_count'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-routes" class="tab-view hidden p-4 lg:p-6">
                <div class="grid gap-4 lg:grid-cols-[1.3fr_0.9fr]">
                    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/60 p-4">
                        <h3 class="text-base font-bold text-slate-900">Shipping Routes</h3>
                        <div class="mt-3 overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm">
                                <thead class="bg-white text-left text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">
                                    <tr>
                                        <th class="px-2 py-2">Order</th>
                                        <th class="px-2 py-2">City</th>
                                        <th class="px-2 py-2">Status</th>
                                        <th class="px-2 py-2"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white">
                                    @forelse ($routeShipments as $shipment)
                                        <tr class="route-row hover:bg-slate-50" data-order-id="{{ $shipment->orderID }}" data-status="{{ $shipment->status }}">
                                            <td class="px-2 py-3 font-semibold text-slate-900">{{ $shipment->orderID }}</td>
                                            <td class="px-2 py-3 text-slate-600">{{ $shipment->city }}</td>
                                            <td class="px-2 py-3">
                                                <span class="route-status-badge inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold uppercase {{ $shipment->status === 'Delayed' ? 'bg-amber-50 text-amber-700 border-amber-200' : ($shipment->status === 'Delivered' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-indigo-50 text-indigo-700 border-indigo-200') }}">{{ $shipment->status }}</span>
                                            </td>
                                            <td class="px-2 py-3 text-right">
                                                <button type="button" class="editRouteStatusBtn inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 hover:border-slate-300 hover:text-slate-900" data-order-id="{{ $shipment->orderID }}" aria-label="Edit route status">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6L8 21l-6-6 7-7z"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-2 py-4 text-center text-sm text-slate-500">No route records available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200/80 bg-white p-4">
                        <h3 class="text-base font-bold text-slate-900">Route summary</h3>
                        <div class="mt-4 space-y-3 text-sm text-slate-600">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <p class="text-[11px] font-semibold uppercase text-slate-400">Total cities covered</p>
                                <p class="mt-2 text-2xl font-black text-slate-900">{{ $routeShipments->pluck('city')->unique()->count() }}</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <p class="text-[11px] font-semibold uppercase text-slate-400">Cities in route</p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach ($routeShipments->pluck('city')->unique() as $city)
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">{{ $city }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-status" class="tab-view hidden p-4 lg:p-6">
                <div class="rounded-3xl border border-slate-200/80 bg-slate-50/60 p-5 lg:p-6">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-950">Transportation Status</h3>
                            <p class="mt-1 text-sm text-slate-500">Concise route overview with shipment progress, origin/destination, and live telemetry.</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <button id="prevShipmentBtn" type="button" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100">Previous</button>
                            <button id="nextShipmentBtn" type="button" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100">Next</button>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
                        <div class="space-y-5 rounded-[32px] border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <div class="text-[10px] font-semibold uppercase tracking-[0.24em] text-slate-400">Order status</div>
                                    <div class="mt-2 text-2xl font-black text-slate-950" id="statusOrderId">Select a shipment</div>
                                    <div class="mt-1 text-sm text-slate-500">Order ID: <span id="statusOrderReference">—</span></div>
                                </div>
                                <span id="statusOrderLabel" class="inline-flex rounded-full bg-slate-100 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-700">No selection</span>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2">
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    <label for="statusDeparture" class="text-[10px] uppercase tracking-[0.22em] text-slate-400">From</label>
                                    <input id="statusDeparture" readonly value="—" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-3 py-3 text-sm font-semibold text-slate-900 focus:outline-none" />
                                </div>
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    <label for="statusArrival" class="text-[10px] uppercase tracking-[0.22em] text-slate-400">To</label>
                                    <input id="statusArrival" readonly value="—" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-3 py-3 text-sm font-semibold text-slate-900 focus:outline-none" />
                                </div>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    <label for="statusDepartureTime" class="text-[10px] uppercase tracking-[0.22em] text-slate-400">Departure</label>
                                    <input id="statusDepartureTime" readonly value="--" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-3 py-3 text-sm font-semibold text-slate-900 focus:outline-none" />
                                </div>
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    <label for="statusExpectedArrive" class="text-[10px] uppercase tracking-[0.22em] text-slate-400">ETA</label>
                                    <input id="statusExpectedArrive" readonly value="--" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-3 py-3 text-sm font-semibold text-slate-900 focus:outline-none" />
                                </div>
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    <label for="statusTransit" class="text-[10px] uppercase tracking-[0.22em] text-slate-400">Transit hub</label>
                                    <input id="statusTransit" readonly value="—" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-3 py-3 text-sm font-semibold text-slate-900 focus:outline-none" />
                                </div>
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    <label class="text-[10px] uppercase tracking-[0.22em] text-slate-400">Sorting center</label>
                                    <p id="statusSortingCenter" class="mt-2 rounded-3xl border border-slate-200 bg-white px-3 py-3 text-sm font-semibold text-slate-900">—</p>
                                </div>
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    <label class="text-[10px] uppercase tracking-[0.22em] text-slate-400">Route hours</label>
                                    <p id="statusTotalTime" class="mt-2 rounded-3xl border border-slate-200 bg-white px-3 py-3 text-sm font-semibold text-slate-900">--</p>
                                </div>
                            </div>

                            <div class="rounded-[28px] bg-slate-100 p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-[10px] uppercase tracking-[0.22em] text-slate-400">Progress</p>
                                        <p class="mt-1 text-sm font-semibold text-slate-700" id="statusProgressLabel">0%</p>
                                    </div>
                                    <div class="h-3 w-full overflow-hidden rounded-full bg-white shadow-inner">
                                        <div id="statusProgressBar" class="h-full rounded-full bg-amber-500" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center justify-between text-xs uppercase tracking-[0.24em] text-slate-400">
                                    <span>Transport timeline</span>
                                    <span class="text-slate-500">Latest updates</span>
                                </div>
                                <div id="statusBreakdown" class="space-y-3 text-sm text-slate-600">
                                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                        <div class="flex items-center justify-between gap-3">
                                            <span class="font-semibold text-slate-900">No selection yet</span>
                                            <span class="text-[11px] text-slate-500">—</span>
                                        </div>
                                        <p class="mt-2 text-sm text-slate-500">Select an order from the shipment schedule to inspect status.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-[32px] border border-slate-200 bg-slate-950 p-5 text-white shadow-sm">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.24em] text-slate-400">Live telemetry</p>
                                    <h4 class="mt-2 text-lg font-bold">Route view</h4>
                                </div>
                                <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-[11px] font-semibold text-emerald-300">Synced</span>
                            </div>
                            <div class="mt-5 h-[360px] overflow-hidden rounded-[28px] border border-slate-800 bg-slate-900">
                                <div id="statusMap" class="h-full w-full bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.15),_transparent_30%),linear-gradient(180deg,_rgba(15,23,42,0.85),_rgba(15,23,42,0.5))]"></div>
                            </div>
                            <div class="mt-5 grid gap-3">
                                <div class="rounded-3xl bg-slate-900/80 p-4">
                                    <p class="text-[10px] uppercase tracking-[0.22em] text-slate-400">Current route</p>
                                    <p class="mt-2 text-sm font-semibold text-white">{{ $routeShipments->first()?->city ?? 'No route selected' }}</p>
                                </div>
                                <div class="rounded-3xl bg-slate-900/80 p-4">
                                    <p class="text-[10px] uppercase tracking-[0.22em] text-slate-400">Carrier</p>
                                    <p class="mt-2 text-sm font-semibold text-white">Fleet Unit 42</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="routeStatusEditModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-950/80 p-4">
    <div class="w-full max-w-md overflow-hidden rounded-[28px] border border-slate-200 bg-white p-4 shadow-2xl shadow-slate-900/10">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h3 class="text-lg font-extrabold text-slate-950">Edit Route Status</h3>
                <p class="mt-1 text-sm text-slate-500">Update the route status and sync it across logistics.</p>
            </div>
            <button type="button" id="routeStatusCloseBtn" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-slate-100 text-slate-500 transition hover:bg-slate-200">✕</button>
        </div>
        <div class="mt-5 space-y-4">
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Order ID</p>
                <p class="mt-2 text-lg font-bold text-slate-900" id="routeStatusOrderId">—</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-4">
                <label class="text-[10px] uppercase tracking-[0.2em] text-slate-400" for="routeStatusSelect">Status</label>
                <select id="routeStatusSelect" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="In Transit">In Transit</option>
                    <option value="Delayed">Delayed</option>
                    <option value="Delivered">Delivered</option>
                </select>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" id="routeStatusCancelBtn" class="rounded-3xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                <button type="button" id="routeStatusSaveBtn" class="rounded-3xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div id="shipmentPreviewModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-950/80 p-4">
    <div class="w-full max-w-lg overflow-hidden rounded-[28px] border border-slate-200 bg-white p-4 shadow-2xl shadow-slate-900/10">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h3 class="text-lg font-extrabold text-slate-950" id="previewOrderTitle">Shipment Preview</h3>
                <p class="mt-1 text-sm text-slate-500" id="previewOrderSubtitle">Compact live details for the selected schedule.</p>
            </div>
            <button type="button" id="closePreviewModal" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-slate-100 text-slate-500 transition hover:bg-slate-200">✕</button>
        </div>

        <div class="mt-4 grid gap-4 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="space-y-3">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Order ID</p>
                            <p class="mt-2 text-lg font-bold text-slate-900" id="previewOrderId">—</p>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <button type="button" id="previewPrevOrder" class="rounded-full border border-slate-200 bg-white px-3 py-2 font-semibold text-slate-700">Prev</button>
                            <button type="button" id="previewNextOrder" class="rounded-full border border-slate-200 bg-white px-3 py-2 font-semibold text-slate-700">Next</button>
                        </div>
                    </div>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="rounded-3xl border border-slate-200 bg-white p-3">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Product</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900" id="previewProduct">—</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-3">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Items</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900" id="previewItems">—</p>
                    </div>
                </div>

                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-3xl border border-slate-200 bg-white p-3">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Destination</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900" id="previewCity">—</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-3">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Status</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900" id="previewStatus">—</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-3">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">ETA</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900" id="previewExpectedArrival">—</p>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-3">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Notes</p>
                    <p class="mt-2 text-sm text-slate-600" id="previewRemarks">Shipment preview data synced from schedules and tracking.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="rounded-3xl border border-slate-200 bg-white p-3">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Departure time</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900" id="previewDepartureTime">—</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-3">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Contact</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900" id="previewContact">—</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 pt-1">
                    <button type="button" id="seeFullDetailsBtn" class="rounded-3xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">See full details</button>
                    <button type="button" id="previewCloseBtn" class="rounded-3xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Close</button>
                </div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Live route snapshot</p>
                <div class="mt-4 h-56 rounded-3xl border border-slate-200 bg-slate-100" id="previewMap">Map syncing order location…</div>
                <div class="mt-4 grid gap-3 text-sm text-slate-600">
                    <div class="rounded-2xl border border-slate-200 bg-white p-3">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Departure</p>
                        <p class="mt-2" id="previewDeparture">—</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-3">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Transit</p>
                        <p class="mt-2" id="previewTransit">—</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-3">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Arrival</p>
                        <p class="mt-2" id="previewArrival">—</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const availableTabs = ['approvals', 'schedules', 'tracking', 'routes', 'status'];
    const scheduleRows = Array.from(document.querySelectorAll('.schedule-row'));
    const trackingRows = Array.from(document.querySelectorAll('.tracking-row'));
    const routeRows = Array.from(document.querySelectorAll('.route-row'));
    let selectedShipmentIndex = 0;
    let activeTrackingIndex = 0;
    let routeStatusEditOrderId = null;
    let currentFilter = 'All';
    let currentSortDirection = 'asc';

    function setActiveTabButton(tabId) {
        document.querySelectorAll('.tab-button').forEach(button => {
            const isActive = button.dataset.tab === tabId;
            button.classList.toggle('bg-slate-900', isActive);
            button.classList.toggle('text-white', isActive);
            button.classList.toggle('bg-white', !isActive);
            button.classList.toggle('text-slate-600', !isActive);
        });
    }

    function switchTab(tabId) {
        if (!availableTabs.includes(tabId)) {
            tabId = 'approvals';
        }

        document.querySelectorAll('.tab-view').forEach(view => view.classList.add('hidden'));
        document.getElementById(`view-${tabId}`)?.classList.remove('hidden');
        setActiveTabButton(tabId);
    }

    function getInitialTab() {
        const params = new URLSearchParams(window.location.search);
        const requested = params.get('tab');
        return availableTabs.includes(requested) ? requested : 'approvals';
    }

    function applyScheduleFilters() {
        const query = document.getElementById('scheduleSearch').value.toLowerCase().trim();

        scheduleRows.forEach(row => {
            const rowText = `${row.dataset.orderId} ${row.dataset.product} ${row.dataset.city} ${row.dataset.status}`.toLowerCase();
            const matchesQuery = !query || rowText.includes(query);
            const matchesStatus = currentFilter === 'All' || row.dataset.status === currentFilter;
            row.classList.toggle('hidden', !(matchesQuery && matchesStatus));
        });
    }

    function filterScheduleRows(status) {
        currentFilter = status;
        applyScheduleFilters();
    }

    function sortScheduleRows() {
        const tbody = document.getElementById('scheduleTableBody');
        const column = document.getElementById('scheduleSort').value;
        const sortedRows = scheduleRows.slice().sort((a, b) => {
            const aKey = (a.dataset[column] || '').toString().toLowerCase();
            const bKey = (b.dataset[column] || '').toString().toLowerCase();

            if (!isNaN(Number(aKey)) && !isNaN(Number(bKey))) {
                return currentSortDirection === 'asc' ? Number(aKey) - Number(bKey) : Number(bKey) - Number(aKey);
            }

            return currentSortDirection === 'asc' ? aKey.localeCompare(bKey) : bKey.localeCompare(aKey);
        });

        tbody.innerHTML = '';
        sortedRows.forEach(row => tbody.appendChild(row));
    }

    function applyTrackingFilters() {
        const query = document.getElementById('trackingSearch').value.toLowerCase().trim();

        trackingRows.forEach(row => {
            const rowText = `${row.dataset.orderId} ${row.dataset.product} ${row.dataset.city} ${row.dataset.status}`.toLowerCase();
            const matches = !query || rowText.includes(query);
            row.classList.toggle('hidden', !matches);
        });
    }

    function updateTrackingSummary(row) {
        if (!row) return;

        document.getElementById('trackingSummaryOrderId').textContent = row.dataset.orderId;
        document.getElementById('trackingSummaryProduct').textContent = row.dataset.product;
        document.getElementById('trackingSummaryCity').textContent = row.dataset.city;
        document.getElementById('trackingSummaryStatus').textContent = row.dataset.status;
        document.getElementById('trackingSummaryETA').textContent = row.dataset.expectedArrive;
        document.getElementById('trackingSummaryContact').textContent = row.dataset.contact;
        document.getElementById('trackingSummaryRemarks').textContent = row.dataset.remarks;
    }

    function renderStatusMap(shipment) {
        const map = document.getElementById('statusMap');
        if (!map || !shipment) return;

        const accent = shipment.status === 'Delivered' ? 'emerald' : shipment.status === 'Delayed' ? 'amber' : 'sky';
        const accentBg = shipment.status === 'Delivered' ? 'bg-emerald-400/20' : shipment.status === 'Delayed' ? 'bg-amber-400/20' : 'bg-sky-400/20';
        const accentText = shipment.status === 'Delivered' ? 'text-emerald-200' : shipment.status === 'Delayed' ? 'text-amber-200' : 'text-sky-200';

        map.innerHTML = `
            <div class="relative h-full w-full overflow-hidden">
                <div class="absolute left-4 top-4 rounded-full bg-slate-950/70 px-3 py-2 text-xs font-semibold text-white">${shipment.departure}</div>
                <div class="absolute right-4 top-4 rounded-full ${accentBg} ${accentText} px-3 py-2 text-xs font-semibold">${shipment.status}</div>
                <div class="absolute inset-x-8 top-20 flex items-center gap-3">
                    <span class="h-3 w-3 rounded-full bg-white shadow-xl"></span>
                    <div class="h-px flex-1 bg-white/20"></div>
                    <span class="h-3 w-3 rounded-full bg-white shadow-xl"></span>
                </div>
                <div class="absolute bottom-4 left-4 right-4 rounded-3xl border border-white/10 bg-slate-950/80 p-4 text-xs text-slate-200">
                    <div class="mb-2 text-sm font-semibold text-white">Live telemetry</div>
                    <div class="grid gap-2 sm:grid-cols-2">
                        <div>
                            <div class="text-[10px] uppercase tracking-[0.22em] text-slate-400">Current hub</div>
                            <div class="mt-1 font-semibold text-white">${shipment.transit}</div>
                        </div>
                        <div>
                            <div class="text-[10px] uppercase tracking-[0.22em] text-slate-400">ETA</div>
                            <div class="mt-1 font-semibold text-white">${shipment.expectedArrive}</div>
                        </div>
                    </div>
                    <div class="mt-3 rounded-2xl bg-white/10 p-3 text-[11px] text-slate-200">${shipment.status === 'Delayed' ? 'Traffic or clearance delay detected. Monitoring every 5 minutes.' : 'Route telemetry syncing from the shipment schedule.'}</div>
                </div>
            </div>
        `;
    }

    function setTrackingActiveRow(index) {
        if (!trackingRows[index]) return;

        activeTrackingIndex = index;
        trackingRows.forEach((row, rowIndex) => {
            row.classList.toggle('bg-slate-50', rowIndex === index);
        });

        updateTrackingSummary(trackingRows[index]);
    }

    function getShipmentData(index) {
        const row = scheduleRows[index];
        if (!row) return null;

        return {
            orderId: row.dataset.orderId,
            product: row.dataset.product,
            items: row.dataset.items,
            city: row.dataset.city,
            status: row.dataset.status,
            amount: row.dataset.amount,
            total: row.dataset.total,
            contact: row.dataset.contact,
            remarks: row.dataset.remarks,
            departure: row.dataset.departure || 'Warehouse',
            transit: row.dataset.transit || 'Hub',
            arrival: row.dataset.arrival || 'Destination',
            departureTime: row.dataset.departureTime || 'TBD',
            expectedArrival: row.dataset.expectedArrive || 'TBD',
            expectedArrive: row.dataset.expectedArrive || 'TBD',
            progress: row.dataset.status === 'Delivered' ? 100 : row.dataset.status === 'In Transit' ? 65 : 35,
            breakdown: [
                `Order ${row.dataset.orderId} confirmed`,
                `${row.dataset.items} items picked`,
                `${row.dataset.city} route assigned`,
                `Carrier notified for final delivery`,
            ],
        };
    }

    function renderPreview(shipment) {
        if (!shipment) return;
        document.getElementById('previewOrderId').textContent = shipment.orderId;
        document.getElementById('previewProduct').textContent = shipment.product;
        document.getElementById('previewItems').textContent = shipment.items;
        document.getElementById('previewCity').textContent = shipment.city;
        document.getElementById('previewStatus').textContent = shipment.status;
        document.getElementById('previewRemarks').textContent = shipment.remarks;
        document.getElementById('previewDeparture').textContent = shipment.departure;
        document.getElementById('previewTransit').textContent = shipment.transit;
        document.getElementById('previewArrival').textContent = shipment.arrival;
        document.getElementById('previewDepartureTime').textContent = shipment.departureTime;
        document.getElementById('previewContact').textContent = shipment.contact;
        document.getElementById('previewExpectedArrival').textContent = shipment.expectedArrival;
        document.getElementById('previewOrderTitle').textContent = `Shipment ${shipment.orderId}`;
        document.getElementById('previewOrderSubtitle').textContent = `Live preview for ${shipment.product} route`;
        document.getElementById('previewOrderTitle').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function renderStatusDetails(shipment) {
        const statusLabel = document.getElementById('statusOrderLabel');
        const statusProgressBar = document.getElementById('statusProgressBar');
        const statusOrderReference = document.getElementById('statusOrderReference');

        if (!shipment) {
            document.getElementById('statusOrderId').textContent = 'Select a shipment';
            statusOrderReference.textContent = '—';
            statusLabel.textContent = 'No selection';
            statusLabel.className = 'inline-flex rounded-full bg-slate-100 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-700';
            document.getElementById('statusTotalTime').textContent = '--';
            document.getElementById('statusExpectedArrive').value = '--';
            document.getElementById('statusProgressLabel').textContent = '0%';
            statusProgressBar.style.width = '0%';
            statusProgressBar.className = 'h-full rounded-full bg-amber-500';
            document.getElementById('statusDeparture').value = '--';
            document.getElementById('statusSortingCenter').textContent = '--';
            document.getElementById('statusTransit').value = '--';
            document.getElementById('statusArrival').value = '--';
            document.getElementById('statusDepartureTime').value = '--';
            document.getElementById('statusExpectedArrive').value = '--';
            document.getElementById('statusBreakdown').innerHTML = '<div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">No selection yet.</div>';
            document.getElementById('statusMap').innerHTML = '<div class="flex h-full items-center justify-center text-sm text-slate-400">Live telemetry will show here once a shipment is selected.</div>';
            return;
        }

        document.getElementById('statusOrderId').textContent = shipment.orderId;
        statusOrderReference.textContent = shipment.orderId;
        statusLabel.textContent = shipment.status;
        statusLabel.className = `inline-flex rounded-full px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.18em] ${shipment.status === 'Delivered' ? 'bg-emerald-100 text-emerald-700' : shipment.status === 'Delayed' ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700'}`;
        document.getElementById('statusTotalTime').textContent = `${shipment.amount} hrs`;
        document.getElementById('statusProgressLabel').textContent = `${shipment.progress}%`;
        statusProgressBar.style.width = `${shipment.progress}%`;
        statusProgressBar.className = `h-full rounded-full ${shipment.status === 'Delivered' ? 'bg-emerald-500' : shipment.status === 'Delayed' ? 'bg-amber-500' : 'bg-sky-500'}`;
        document.getElementById('statusDeparture').value = shipment.departure;
        document.getElementById('statusTransit').value = shipment.transit;
        document.getElementById('statusArrival').value = shipment.arrival;
        document.getElementById('statusDepartureTime').value = shipment.departureTime;
        document.getElementById('statusExpectedArrive').value = shipment.expectedArrive;

        const timeline = [
            `Order confirmed at ${shipment.departureTime}`,
            `${shipment.status === 'Delivered' ? 'Delivered' : 'Departed'} from ${shipment.departure}`,
            `Passing through ${shipment.transit}`,
            `Expected to arrive at ${shipment.arrival} by ${shipment.expectedArrive}`,
        ];

        document.getElementById('statusBreakdown').innerHTML = timeline.map(step => `<div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">${step}</div>`).join('');
        renderStatusMap(shipment);
    }

    function setSelectedShipment(index) {
        const shipment = getShipmentData(index);
        if (!shipment) return;
        selectedShipmentIndex = index;
        renderStatusDetails(shipment);
    }

    function openPreviewForOrder(orderId) {
        const index = scheduleRows.findIndex(row => row.dataset.orderId === orderId);
        if (index < 0) return;
        const shipment = getShipmentData(index);
        renderPreview(shipment);
        selectedShipmentIndex = index;
        document.getElementById('shipmentPreviewModal').classList.remove('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        switchTab(getInitialTab());

        document.querySelectorAll('.schedule-filter-btn').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.schedule-filter-btn').forEach(btn => {
                    btn.classList.remove('bg-slate-900', 'text-white');
                    btn.classList.add('bg-white', 'text-slate-700');
                });
                button.classList.remove('bg-white', 'text-slate-700');
                button.classList.add('bg-slate-900', 'text-white');
                filterScheduleRows(button.dataset.status);
            });
        });

        document.getElementById('scheduleSearchBtn').addEventListener('click', applyScheduleFilters);
        document.getElementById('scheduleSearch').addEventListener('keydown', event => {
            if (event.key === 'Enter') {
                event.preventDefault();
                applyScheduleFilters();
            }
        });

        document.getElementById('scheduleSortDir').addEventListener('click', () => {
            currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
            document.getElementById('scheduleSortDir').textContent = currentSortDirection === 'asc' ? 'Asc' : 'Desc';
            sortScheduleRows();
        });

        document.getElementById('scheduleSort').addEventListener('change', () => {
            sortScheduleRows();
        });

        document.querySelectorAll('.previewShipmentBtn').forEach(button => {
            button.addEventListener('click', () => openPreviewForOrder(button.dataset.orderId));
        });

        document.querySelectorAll('.messageShipmentBtn').forEach(button => {
            button.addEventListener('click', () => alert(`Message ${button.dataset.contact} for order ${button.dataset.orderId}`));
        });

        document.querySelectorAll('.callShipmentBtn').forEach(button => {
            button.addEventListener('click', () => alert(`Calling ${button.dataset.contact} for order ${button.dataset.orderId}`));
        });

        document.querySelectorAll('.search-suggest-btn').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('scheduleSearch').value = button.textContent;
                document.getElementById('scheduleSearchBtn').click();
            });
        });

        document.getElementById('trackingSearchBtn').addEventListener('click', applyTrackingFilters);
        document.getElementById('trackingSearch').addEventListener('keydown', event => {
            if (event.key === 'Enter') {
                event.preventDefault();
                applyTrackingFilters();
            }
        });

        trackingRows.forEach((row, index) => {
            row.addEventListener('click', () => setTrackingActiveRow(index));
        });

        document.querySelectorAll('.editShipmentBtn').forEach(button => {
            button.addEventListener('click', () => window.location.href = `/logistics/shipments/${button.dataset.orderId}/edit`);
        });

        document.getElementById('closePreviewModal').addEventListener('click', () => document.getElementById('shipmentPreviewModal').classList.add('hidden'));
        document.getElementById('previewCloseBtn').addEventListener('click', () => document.getElementById('shipmentPreviewModal').classList.add('hidden'));
        document.getElementById('previewPrevOrder').addEventListener('click', () => {
            selectedShipmentIndex = (selectedShipmentIndex - 1 + scheduleRows.length) % scheduleRows.length;
            renderPreview(getShipmentData(selectedShipmentIndex));
        });
        document.getElementById('previewNextOrder').addEventListener('click', () => {
            selectedShipmentIndex = (selectedShipmentIndex + 1) % scheduleRows.length;
            renderPreview(getShipmentData(selectedShipmentIndex));
        });
        document.getElementById('seeFullDetailsBtn').addEventListener('click', () => {
            document.getElementById('shipmentPreviewModal').classList.add('hidden');
            switchTab('status');
            setSelectedShipment(selectedShipmentIndex);
        });

        document.querySelectorAll('.editRouteStatusBtn').forEach(button => {
            button.addEventListener('click', () => openRouteStatusModal(button.dataset.orderId));
        });

        document.getElementById('prevShipmentBtn').addEventListener('click', () => {
            selectedShipmentIndex = (selectedShipmentIndex - 1 + scheduleRows.length) % scheduleRows.length;
            setSelectedShipment(selectedShipmentIndex);
        });
        document.getElementById('nextShipmentBtn').addEventListener('click', () => {
            selectedShipmentIndex = (selectedShipmentIndex + 1) % scheduleRows.length;
            setSelectedShipment(selectedShipmentIndex);
        });

        document.getElementById('routeStatusCloseBtn').addEventListener('click', closeRouteStatusModal);
        document.getElementById('routeStatusCancelBtn').addEventListener('click', closeRouteStatusModal);
        document.getElementById('routeStatusSaveBtn').addEventListener('click', async () => {
            const select = document.getElementById('routeStatusSelect');
            if (!routeStatusEditOrderId || !select) return;
            await saveRouteStatus(routeStatusEditOrderId, select.value);
            applyRouteStatusEdit(routeStatusEditOrderId, select.value);
            closeRouteStatusModal();
        });

        setSelectedShipment(0);
    });

    async function saveRouteStatus(orderId, newStatus) {
        try {
            const response = await fetch(`/api/shipments/${encodeURIComponent(orderId)}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => null);
                console.error('Shipment update failed', errorData || response.statusText);
            }

            window.dispatchEvent(new CustomEvent('shipmentStatusUpdated', {
                detail: { orderId, newStatus }
            }));
        } catch (error) {
            console.error('Shipment update error', error);
        }
    }

    function openRouteStatusModal(orderId) {
        routeStatusEditOrderId = orderId;
        const routeRow = routeRows.find(row => row.dataset.orderId === orderId);
        const currentStatus = routeRow?.dataset.status || 'In Transit';
        const modal = document.getElementById('routeStatusEditModal');
        document.getElementById('routeStatusOrderId').textContent = orderId;
        document.getElementById('routeStatusSelect').value = currentStatus;
        modal.classList.remove('hidden');
    }

    function closeRouteStatusModal() {
        routeStatusEditOrderId = null;
        document.getElementById('routeStatusEditModal').classList.add('hidden');
    }

    function applyRouteStatusEdit(orderId, newStatus) {
        const normalizeClasses = status => status === 'Delayed'
            ? 'bg-amber-50 text-amber-700 border-amber-200'
            : status === 'Delivered'
                ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                : 'bg-indigo-50 text-indigo-700 border-indigo-200';

        const renderStatusBadge = status => `<span class="route-status-badge inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold uppercase ${normalizeClasses(status)}">${status}</span>`;

        const routeRow = routeRows.find(row => row.dataset.orderId === orderId);
        if (routeRow) {
            routeRow.dataset.status = newStatus;
            const badgeCell = routeRow.querySelector('td:nth-child(3)');
            if (badgeCell) {
                badgeCell.innerHTML = renderStatusBadge(newStatus);
            }
        }

        const scheduleRow = scheduleRows.find(row => row.dataset.orderId === orderId);
        if (scheduleRow) {
            scheduleRow.dataset.status = newStatus;
            const statusCell = scheduleRow.querySelector('td:nth-child(5)');
            if (statusCell) {
                statusCell.innerHTML = `<span class="schedule-status-badge inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold uppercase ${normalizeClasses(newStatus)}">${newStatus}</span>`;
            }
        }

        const trackingRow = trackingRows.find(row => row.dataset.orderId === orderId);
        if (trackingRow) {
            trackingRow.dataset.status = newStatus;
            const statusCell = trackingRow.querySelector('td:nth-child(4)');
            if (statusCell) {
                statusCell.textContent = newStatus;
            }
        }

        if (scheduleRow && selectedShipmentIndex >= 0 && scheduleRows[selectedShipmentIndex]?.dataset.orderId === orderId) {
            setSelectedShipment(selectedShipmentIndex);
        }

        if (trackingRow) {
            const activeTrackingRow = trackingRows[activeTrackingIndex];
            if (activeTrackingRow && activeTrackingRow.dataset.orderId === orderId) {
                updateTrackingSummary(activeTrackingRow);
            }
        }
    }
</script>
@endsection