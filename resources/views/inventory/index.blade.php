@extends('layouts.app')

@section('title', 'Inventory & Warehouse Management')

@push('styles')
<style>
  :root{
    --accent:#6d5df6;
    --accent-2:#5b4bdb;
    --teal:#17c9b0;
    --text-dark:#1c1f2e;
    --text-muted:#8b8fa3;
    --border:#eceef4;
    --green:#1fae6b;
    --green-bg:#e6f8ef;
    --amber:#c9820a;
    --amber-bg:#fdf1de;
    --red:#e0483a;
    --red-bg:#fceceb;
    --blue:#4b3fd6;
    --blue-bg:#eceafe;
  }

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

  .stats-row{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
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
  .stat-card:hover{
    transform:translateY(-6px);
    box-shadow:0 16px 30px rgba(23,26,52,.08);
    border-color:#e2e0fb;
  }
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
  .stat-value.accent-teal{color:var(--teal);}
  .stat-value.currency{
    font-size:22px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }

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

  .qty-pill{font-weight:700;}
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

  .empty-state{
    padding:60px 26px;
    text-align:center;
    color:var(--text-muted);
  }
  .empty-state svg{
    width:40px;
    height:40px;
    stroke:#c7cadb;
    fill:none;
    stroke-width:1.6;
    margin-bottom:14px;
  }
  .empty-state p{margin:0; font-size:14px;}
  .empty-state span{font-size:12.5px; color:#b7bacb;}

  .filter-bar{
    display:flex;
    gap:12px;
    margin-bottom:20px;
    flex-wrap:wrap;
  }
  .filter-bar input[type="text"],
  .filter-bar select{
    padding:11px 14px;
    border-radius:10px;
    border:1px solid var(--border);
    font-family:inherit;
    font-size:13.5px;
    background:#fff;
    color:var(--text-dark);
  }
  .filter-bar input[type="text"]{
    flex:1;
    min-width:220px;
  }
  .filter-bar select{
    min-width:170px;
  }
  .filter-bar input[type="text"]:focus,
  .filter-bar select:focus{
    outline:none;
    border-color:var(--accent);
  }
</style>
@endpush

@section('header')
  <div>
    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Inventory & Warehouse Management</h1>
    <p class="text-sm text-slate-500 mt-1">{{ count($items) }} stock items across all warehouse locations</p>
  </div>
@endsection

@section('content')

  <div class="stats-row">
    <div class="stat-card">
      <div class="stat-label">Total SKUs</div>
      <div class="stat-value">{{ $stats['total_skus'] }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">In Stock</div>
      <div class="stat-value accent-blue">{{ $stats['in_stock'] }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Low / Out of Stock</div>
      <div class="stat-value accent-amber">{{ $stats['low_out_of_stock'] }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Reserved</div>
      <div class="stat-value accent-teal">{{ $stats['reserved'] }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Inventory Value Total</div>
      <div class="stat-value currency">₱{{ number_format($stats['inventory_value'], 2) }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Procurement POs</div>
      <div class="stat-value accent-blue">{{ $stats['synced_purchase_orders'] }}</div>
    </div>
  </div>

  <div class="filter-bar">
    <input type="text" id="search-input" placeholder="Search by item code or name...">
    <select id="category-filter">
      <option value="">All Categories</option>
      @foreach ($categories as $category)
        <option value="{{ $category }}">{{ $category }}</option>
      @endforeach
    </select>
    <select id="status-filter">
      <option value="">All Statuses</option>
      <option value="in-stock">In Stock</option>
      <option value="low-stock">Low Stock</option>
      <option value="out-stock">Out of Stock</option>
      <option value="reserved">Reserved</option>
    </select>
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
      <tbody id="ledger-body">
        @forelse ($items as $item)
          <tr data-code="{{ strtolower($item->code) }}" data-name="{{ strtolower($item->name) }}" data-category="{{ $item->category }}" data-status="{{ $item->status }}">
            <td><span class="item-code">{{ $item->code }}</span></td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->location }}</td>
            <td>{{ $item->category }}</td>
            <td>
              <div class="qty-pill">{{ $item->quantity }} {{ $item->unit }}</div>
              <div class="qty-bar-bg">
                <div class="qty-bar-fill" style="width: {{ min(100, ($item->quantity / max($item->max_qty, 1)) * 100) }}%"></div>
              </div>
            </td>
            <td>₱{{ number_format($item->cost, 2) }}</td>
            <td>
              <span class="badge {{ $item->status }}">
                {{ ucwords(str_replace('-', ' ', $item->status)) }}
              </span>
            </td>
          </tr>
        @empty
          <tr id="empty-row">
            <td colspan="7">
              <div class="empty-state">
                <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.27 6.96L12 12.01l8.73-5.05"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 22.08V12"/></svg>
                <p>No inventory data yet</p>
                <span>Add your first stock item to get started.</span>
              </div>
            </td>
          </tr>
        @endforelse
        <tr id="no-results-row" style="display:none;">
          <td colspan="7">
            <div class="empty-state">
              <p>No items match your search or filters</p>
              <span>Try adjusting the search text or filter selections.</span>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const statusFilter = document.getElementById('status-filter');
    const rows = Array.from(document.querySelectorAll('#ledger-body tr[data-code]'));
    const noResultsRow = document.getElementById('no-results-row');

    function applyFilters() {
      const search = searchInput.value.trim().toLowerCase();
      const category = categoryFilter.value;
      const status = statusFilter.value;
      let visibleCount = 0;

      rows.forEach(function (row) {
        const matchesSearch = !search || row.dataset.code.includes(search) || row.dataset.name.includes(search);
        const matchesCategory = !category || row.dataset.category === category;
        const matchesStatus = !status || row.dataset.status === status;
        const isVisible = matchesSearch && matchesCategory && matchesStatus;

        row.style.display = isVisible ? '' : 'none';
        if (isVisible) visibleCount++;
      });

      if (noResultsRow) {
        noResultsRow.style.display = (rows.length > 0 && visibleCount === 0) ? '' : 'none';
      }
    }

    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
    if (statusFilter) statusFilter.addEventListener('change', applyFilters);
  });
</script>
@endpush