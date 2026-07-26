@extends('layouts.app')

@section('title', 'Warehouse Locations')

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

  .modal-overlay{
    position:fixed; inset:0;
    background:rgba(23,26,52,.45);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:50;
  }
  .modal-overlay.open{display:flex;}
  .modal-card{
    background:#fff;
    border-radius:18px;
    width:100%;
    max-width:480px;
    padding:28px 30px;
    box-shadow:0 24px 60px rgba(23,26,52,.25);
  }
  .modal-card h2{margin:0 0 4px 0; font-size:20px; font-weight:800;}
  .modal-card p{margin:0 0 20px 0; font-size:13px; color:var(--text-muted);}
  .form-row{margin-bottom:14px;}
  .form-row label{display:block; font-size:12.5px; font-weight:700; color:var(--text-dark); margin-bottom:6px;}
  .form-row input, .form-row select{
    width:100%;
    padding:10px 12px;
    border-radius:10px;
    border:1px solid var(--border);
    font-family:inherit;
    font-size:13.5px;
    background:#fafafe;
  }
  .form-grid{display:grid; grid-template-columns:1fr 1fr; gap:0 14px;}
  .modal-actions{display:flex; justify-content:flex-end; gap:10px; margin-top:22px;}
  .btn-cancel{
    background:#f1f2f7; color:var(--text-dark); border:none;
    padding:11px 18px; border-radius:10px; font-weight:700; font-size:13.5px; cursor:pointer;
  }
  .btn-submit{
    background:linear-gradient(135deg,var(--accent),var(--accent-2));
    color:#fff; border:none;
    padding:11px 20px; border-radius:10px; font-weight:700; font-size:13.5px; cursor:pointer;
  }
</style>
@endpush

@section('header')
  <div>
    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Warehouse Locations</h1>
    <p class="text-sm text-slate-500 mt-1">{{ count($warehouses) }} warehouse locations registered</p>
  </div>
  <button class="add-btn" onclick="document.getElementById('add-warehouse-modal').classList.add('open')">
    <svg class="icon" viewBox="0 0 24 24" style="stroke:#fff"><path d="M12 5v14M5 12h14"/></svg>
    Add New Warehouse
  </button>
@endsection

@section('content')

  <!-- Add Warehouse Modal -->
  <div class="modal-overlay" id="add-warehouse-modal">
    <div class="modal-card">
      <h2>Add New Warehouse</h2>
      <p>Register a new warehouse location.</p>
      <form method="POST" action="{{ route('inventory.warehouse-locations.store') }}">
        @csrf
        <div class="form-row">
          <label for="name">Warehouse Name</label>
          <input type="text" id="name" name="name" required maxlength="255" placeholder="e.g. Cavite Depot">
        </div>
        <div class="form-row">
          <label for="address">Address</label>
          <input type="text" id="address" name="address" required maxlength="255" placeholder="e.g. Km 32 East Service Road">
        </div>
        <div class="form-grid">
          <div class="form-row">
            <label for="city">City</label>
            <input type="text" id="city" name="city" required maxlength="255" placeholder="e.g. Cavite">
          </div>
          <div class="form-row">
            <label for="capacity">Capacity</label>
            <input type="number" id="capacity" name="capacity" required min="0" placeholder="0">
          </div>
        </div>
        <div class="form-grid">
          <div class="form-row">
            <label for="manager_name">Manager Name</label>
            <input type="text" id="manager_name" name="manager_name" required maxlength="255" placeholder="e.g. Ramon Dela Cruz">
          </div>
          <div class="form-row">
            <label for="status">Status</label>
            <select id="status" name="status" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-actions">
          <button type="button" class="btn-cancel" onclick="document.getElementById('add-warehouse-modal').classList.remove('open')">Cancel</button>
          <button type="submit" class="btn-submit">Save Warehouse</button>
        </div>
      </form>
    </div>
  </div>

  <div class="stats-row">
    <div class="stat-card">
      <div class="stat-label">Total Warehouses</div>
      <div class="stat-value">{{ $stats['total_warehouses'] }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Active</div>
      <div class="stat-value accent-blue">{{ $stats['active'] }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Inactive</div>
      <div class="stat-value accent-amber">{{ $stats['inactive'] }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Total Capacity</div>
      <div class="stat-value">{{ number_format($stats['total_capacity']) }}</div>
    </div>
  </div>

  <div class="ledger-card">
    <div class="ledger-header">Warehouse Locations List</div>
    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Address</th>
          <th>City</th>
          <th>Capacity</th>
          <th>Manager</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($warehouses as $warehouse)
          <tr>
            <td><span class="item-code">{{ $warehouse->code }}</span></td>
            <td>{{ $warehouse->name }}</td>
            <td>{{ $warehouse->address }}</td>
            <td>{{ $warehouse->city }}</td>
            <td>{{ number_format($warehouse->capacity) }}</td>
            <td>{{ $warehouse->manager_name }}</td>
            <td>
              <span class="badge {{ $warehouse->status === 'active' ? 'in-stock' : 'out-stock' }}">
                {{ ucfirst($warehouse->status) }}
              </span>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7">
              <div class="empty-state">
                <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.27 6.96L12 12.01l8.73-5.05"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 22.08V12"/></svg>
                <p>No warehouse locations yet</p>
                <span>Add your first warehouse to get started.</span>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

@endsection
