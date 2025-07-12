@extends('dashboard.layouts.app')

@section('title', 'Order Items - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-radius-lg">
                <div class="card-header bg-white d-flex justify-content-between align-items-center pb-3">
                    <div>
                        <h5 class="mb-0">Order Items</h5>
                        <p class="text-sm text-muted mb-0">View and manage all order items</p>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="text-sm text-muted">Total Items: {{ $orderItems->total() }}</span>
                    </div>
                </div>
                                <div class="card-body border-bottom">
                    <form action="{{ route('console.order_items.index') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="material-symbols-rounded fs-5">search</i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0"
                                    placeholder="Search by product or type..."
                                    value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="order_id" class="form-control" placeholder="Order ID" value="{{ request('order_id') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('console.order_items.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="material-symbols-rounded fs-5 me-1">refresh</i>
                                Clear
                            </a>
                        </div>
                    </form>

                    <!-- Export Filters -->
                    <form action="{{ route('console.order_items.export') }}" method="GET" class="row g-3 mt-3 pt-3 border-top">
                        <div class="col-md-2">
                            <label class="form-label text-sm">Date From</label>
                            <input type="date" name="date_from" class="form-control form-control-sm"
                                value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-sm">Date To</label>
                            <input type="date" name="date_to" class="form-control form-control-sm"
                                value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-sm">Order ID</label>
                            <input type="text" name="order_id" class="form-control form-control-sm"
                                placeholder="Order ID" value="{{ request('order_id') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-sm">Item Type</label>
                            <input type="text" name="item_type" class="form-control form-control-sm"
                                placeholder="Item Type" value="{{ request('item_type') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-sm">Search</label>
                            <input type="text" name="search" class="form-control form-control-sm"
                                placeholder="Search..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-success btn-sm w-100">
                                <i class="material-symbols-rounded fs-5 me-1">download</i>
                                Export CSV
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Mobile View (Cards) -->
                <div class="d-block d-md-none px-4 pt-3">
                    @forelse ($orderItems as $item)
                    <div class="card mb-3 border rounded shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">{{ $item->product->name ?? 'Product' }}</h6>
                                    <p class="text-sm text-muted mb-0">Order #{{ substr($item->order_id, 0, 8) }}</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-dark">{{ ucfirst($item->item_type) }}</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <p class="text-sm mb-1"><strong>Quantity:</strong> {{ $item->quantity }}</p>
                                <p class="text-sm mb-1"><strong>Unit Price:</strong> ${{ number_format($item->unit_price, 2) }}</p>
                                <p class="text-sm mb-1"><strong>Total:</strong> ${{ number_format($item->total_price, 2) }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('console.order_items.show', $item) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="material-symbols-rounded fs-6">visibility</i> View
                                </a>
                                <a href="{{ route('console.order_items.edit', $item) }}" class="btn btn-sm btn-outline-dark">
                                    <i class="material-symbols-rounded fs-6">edit</i> Edit
                                </a>
                                <form action="{{ route('console.order_items.delete', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this item?');">
                                        <i class="material-symbols-rounded fs-6">delete</i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="material-symbols-rounded fs-1 mb-3">shopping_cart</i>
                        <p>No order items found.</p>
                    </div>
                    @endforelse
                </div>
                <!-- Desktop View (Table) -->
                <div class="d-none d-md-block table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Order ID</th>
                                <th>Product</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orderItems as $item)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-sm font-weight-bold mb-0">#{{ substr($item->order_id, 0, 8) }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">{{ $item->product->name ?? 'Product' }}</p>
                                </td>
                                <td>
                                    <span class="badge bg-dark">{{ ucfirst($item->item_type) }}</span>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">{{ $item->quantity }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">${{ number_format($item->unit_price, 2) }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">${{ number_format($item->total_price, 2) }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">{{ $item->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-muted mb-0">{{ $item->created_at->format('H:i') }}</p>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('console.order_items.show', $item) }}" class="btn btn-sm btn-outline-primary me-1" title="View">
                                        <i class="material-symbols-rounded fs-5">visibility</i>
                                    </a>
                                    <a href="{{ route('console.order_items.edit', $item) }}" class="btn btn-sm btn-outline-dark me-1" title="Edit">
                                        <i class="material-symbols-rounded fs-5">edit</i>
                                    </a>
                                    <form action="{{ route('console.order_items.delete', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this item?');" title="Delete">
                                            <i class="material-symbols-rounded fs-5">delete</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="material-symbols-rounded fs-1 mb-3">shopping_cart</i>
                                    <p>No order items found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($orderItems->hasPages())
                <div class="card-footer bg-white">
                    {{ $orderItems->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
