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
                <div class="grid gap-6 lg:grid-cols-[1.3fr_0.7fr]">
                    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/60 p-4">
                        <h3 class="text-base font-bold text-slate-900">Shipment Schedules</h3>
                        <p class="text-xs text-slate-500 mt-1">See scheduled shipments and route assignments below.</p>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm">
                                <thead class="bg-white text-left text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">
                                    <tr>
                                        <th class="px-3 py-2">Order ID</th>
                                        <th class="px-3 py-2">Product</th>
                                        <th class="px-3 py-2">Items</th>
                                        <th class="px-3 py-2">City</th>
                                        <th class="px-3 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white">
                                    @forelse ($shipments as $shipment)
                                        <tr>
                                            <td class="px-3 py-3 font-semibold text-slate-900">{{ $shipment->orderID }}</td>
                                            <td class="px-3 py-3 text-slate-600">{{ $shipment->product }}</td>
                                            <td class="px-3 py-3 text-slate-600">{{ $shipment->items }}</td>
                                            <td class="px-3 py-3 text-slate-600">{{ $shipment->city }}</td>
                                            <td class="px-3 py-3">
                                                <span class="inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold uppercase {{ $shipment->status === 'Delayed' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-indigo-50 text-indigo-700 border-indigo-200' }}">{{ $shipment->status }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-3 py-4 text-center text-sm text-slate-500">No shipment schedules available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($shipments->hasPages())
                            <div class="mt-4 flex items-center justify-between border-t border-slate-200/80 pt-4 text-xs text-slate-500">
                                <span>Showing {{ $shipments->firstItem() }} to {{ $shipments->lastItem() }}</span>
                                <div>{{ $shipments->links('pagination::simple-tailwind') }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="rounded-2xl border border-slate-200/80 bg-white p-4">
                        <h3 class="text-base font-bold text-slate-900">Add shipment schedule</h3>
                        <p class="text-xs text-slate-500 mt-1">Enter shipping details to create a new schedule.</p>
                        <form method="POST" action="{{ route('logistics.shipments.store') }}" class="mt-4 space-y-3">
                            @csrf
                            <input type="text" name="orderID" placeholder="Order ID" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700" />
                            <input type="text" name="Name" placeholder="Recipient Name" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700" />
                            <input type="text" name="product" placeholder="Product" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700" />
                            <input type="text" name="amount" placeholder="Amount" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700" />
                            <input type="number" name="items" placeholder="Item Count" min="1" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700" />
                            <input type="text" name="total" placeholder="Total" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700" />
                            <input type="text" name="city" placeholder="City" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700" />
                            <select name="status" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700">
                                <option value="In Transit">In Transit</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Delayed">Delayed</option>
                            </select>
                            <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-800">Save shipment</button>
                        </form>
                    </div>
                </div>
            </div>

            <div id="view-tracking" class="tab-view hidden p-4 lg:p-6">
                <div class="grid gap-4 lg:grid-cols-2">
                    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/60 p-4">
                        <h3 class="text-base font-bold text-slate-900">Delivery Tracking</h3>
                        <div class="mt-3 space-y-3 text-sm text-slate-600">
                            @if ($trackingShipments->isEmpty())
                                <div class="rounded-xl border border-slate-200 bg-white px-3 py-3 text-sm text-slate-500">
                                    No active shipment tracking data available yet.
                                </div>
                            @endif
                            @foreach ($trackingShipments as $shipment)
                                <div class="rounded-xl border border-slate-200 bg-white px-3 py-3">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <div class="font-semibold text-slate-900">{{ $shipment->orderID }}</div>
                                            <div class="text-xs text-slate-500">{{ $shipment->product }} — {{ $shipment->city }}</div>
                                        </div>
                                        <span class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[10px] font-semibold uppercase text-slate-600">{{ $shipment->status }}</span>
                                    </div>
                                    <div class="mt-2 text-xs text-slate-500">
                                        {{ $shipment->status === 'Delayed' ? 'Delayed delivery needs immediate attention.' : 'In transit and monitored for scheduled arrival.' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200/80 bg-white p-4">
                        <h3 class="text-base font-bold text-slate-900">Tracking summary</h3>
                        <div class="mt-4 grid gap-3">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <p class="text-[11px] font-semibold uppercase text-slate-400">In transit</p>
                                <p class="mt-2 text-2xl font-black text-indigo-700">{{ $stats['in_transit'] }}</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <p class="text-[11px] font-semibold uppercase text-slate-400">Delayed</p>
                                <p class="mt-2 text-2xl font-black text-amber-700">{{ $stats['delayed_shipments'] }}</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <p class="text-[11px] font-semibold uppercase text-slate-400">Total shipments</p>
                                <p class="mt-2 text-2xl font-black text-emerald-700">{{ $stats['shipment_count'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-routes" class="tab-view hidden p-4 lg:p-6">
                <div class="grid gap-4 lg:grid-cols-2">
                    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/60 p-4">
                        <h3 class="text-base font-bold text-slate-900">Shipping Routes</h3>
                        <div class="mt-3 overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm">
                                <thead class="bg-white text-left text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">
                                    <tr>
                                        <th class="px-3 py-2">Order ID</th>
                                        <th class="px-3 py-2">Route City</th>
                                        <th class="px-3 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white">
                                    @forelse ($routeShipments as $shipment)
                                        <tr>
                                            <td class="px-3 py-3 font-semibold text-slate-900">{{ $shipment->orderID }}</td>
                                            <td class="px-3 py-3 text-slate-600">{{ $shipment->city }}</td>
                                            <td class="px-3 py-3 text-slate-600">{{ $shipment->status }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-3 py-4 text-center text-sm text-slate-500">No route records available.</td>
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
                                <p class="text-[11px] font-semibold uppercase text-slate-400">Cities covered</p>
                                <p class="mt-2 text-2xl font-black text-slate-900">{{ $routeShipments->pluck('city')->unique()->count() }}</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <p class="text-[11px] font-semibold uppercase text-slate-400">Most recent route</p>
                                <p class="mt-2 text-slate-700">{{ $routeShipments->first()?->city ?? 'No routes yet' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-status" class="tab-view hidden p-4 lg:p-6">
                <div class="rounded-2xl border border-slate-200/80 bg-slate-50/60 p-4">
                    <h3 class="text-base font-bold text-slate-900">Transportation Status</h3>
                    <div class="mt-4 grid gap-3 md:grid-cols-3">
                        <div class="rounded-2xl border border-indigo-200 bg-indigo-50 p-3">
                            <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-indigo-600">Pending review</div>
                            <div class="mt-1 text-2xl font-black text-indigo-700">{{ $stats['pending_approval'] }}</div>
                        </div>
                        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-3">
                            <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-amber-600">Delayed handling</div>
                            <div class="mt-1 text-2xl font-black text-amber-700">{{ $stats['delayed_responses'] }}</div>
                        </div>
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-3">
                            <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-600">Total shipments</div>
                            <div class="mt-1 text-2xl font-black text-emerald-700">{{ $stats['shipment_count'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const availableTabs = ['approvals', 'schedules', 'tracking', 'routes', 'status'];

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

    document.addEventListener('DOMContentLoaded', () => switchTab(getInitialTab()));
</script>
@endsection