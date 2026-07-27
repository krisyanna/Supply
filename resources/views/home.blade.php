@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-weight-bold text-gray-800 mb-1">Inventory Management</h1>
            <p class="text-muted small mb-0">Manage product stock levels, categories, and warehouse allocations.</p>
        </div>
        <div>
            <a href="{{ Route::has('inventory.create') ? route('inventory.create') : '#' }}" class="btn btn-primary btn-sm shadow-sm font-weight-bold">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add Item
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ Route::has('inventory.index') ? route('inventory.index') : url('/inventory') }}" class="form-row align-items-center">
                <div class="col-md-4 my-1">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-gray-400"></i></span>
                        </div>
                        <input type="text" name="search" class="form-control border-left-0 pl-0" placeholder="Search by code, item name..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3 my-1">
                    <select name="category" class="custom-select custom-select-sm">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 my-1">
                    <select name="status" class="custom-select custom-select-sm">
                        <option value="">All Statuses</option>
                        <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                <div class="col-md-2 my-1 d-flex">
                    <button type="submit" class="btn btn-secondary btn-sm btn-block font-weight-bold">Filter</button>
                    @if(request()->hasAny(['search', 'category', 'status']))
                        <a href="{{ Route::has('inventory.index') ? route('inventory.index') : url('/inventory') }}" class="btn btn-light btn-sm ml-2" title="Reset Filters">
                            <i class="fas fa-undo"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Inventory Data Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="bg-light text-muted">
                        <tr class="small text-uppercase">
                            <th class="py-3 px-4">Item Code</th>
                            <th class="py-3 px-4">Item Name</th>
                            <th class="py-3 px-4">Warehouse Location</th>
                            <th class="py-3 px-4">Category</th>
                            <th class="py-3 px-4 text-right">Quantity</th>
                            <th class="py-3 px-4 text-right">Unit Cost</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-secondary small">
                        @forelse($items as $item)
                            <tr>
                                <td class="px-4 font-weight-bold text-dark">{{ $item->code ?? $item->sku ?? '-' }}</td>
                                <td class="px-4 font-weight-bold text-primary">{{ $item->name }}</td>
                                <td class="px-4">{{ $item->warehouse->name ?? 'N/A' }}</td>
                                <td class="px-4">{{ $item->category->name ?? 'General' }}</td>
                                <td class="px-4 text-right font-weight-bold">{{ number_format($item->quantity ?? 0) }}</td>
                                <td class="px-4 text-right">${{ number_format($item->unit_cost ?? $item->price ?? 0, 2) }}</td>
                                <td class="px-4 text-center">
                                    @if(($item->quantity ?? 0) > ($item->low_stock_threshold ?? 10))
                                        <span class="badge badge-pill badge-soft-success px-3 py-1">In Stock</span>
                                    @elseif(($item->quantity ?? 0) > 0)
                                        <span class="badge badge-pill badge-soft-warning px-3 py-1">Low Stock</span>
                                    @else
                                        <span class="badge badge-pill badge-soft-danger px-3 py-1">Out of Stock</span>
                                    @endif
                                </td>
                                <td class="px-4 text-right">
                                    @if(Route::has('inventory.edit'))
                                        <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-sm btn-link text-info p-0 mr-2" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                    @if(Route::has('inventory.destroy'))
                                        <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-boxes fa-2x mb-2 text-gray-300"></i>
                                    <p class="mb-0">No inventory records found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Safe Footer: Works for both Paginator and Collection -->
        <div class="card-footer bg-white border-0 py-3">
            @if($items instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} of {{ $items->total() ?? 0 }} entries
                    </small>
                    <div>
                        {{ $items->withQueryString()->links() }}
                    </div>
                </div>
            @else
                <small class="text-muted">Total Records: {{ $items->count() }}</small>
            @endif
        </div>
    </div>
</div>
@endsection