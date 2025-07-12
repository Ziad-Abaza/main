@extends('dashboard.layouts.app')

@section('title', 'Orders - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-radius-lg">

                <!-- Card Header -->
                <div class="card-header bg-white d-flex justify-content-between align-items-center pb-3">
                    <div>
                        <h5 class="mb-0">Orders Management</h5>
                        <p class="text-sm text-muted mb-0">Manage customer orders and track their status</p>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="text-sm text-muted">Total Orders: {{ $orders->total() }}</span>
                    </div>
                </div>

                                <!-- Filters and Search -->
                <div class="card-body border-bottom">
                    <form action="{{ route('console.orders.index') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="material-symbols-rounded fs-5">search</i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0"
                                    placeholder="Search by order ID, customer, or child..."
                                    value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="payment_status" class="form-select">
                                <option value="">All Payment Status</option>
                                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="partially_paid" {{ request('payment_status') == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('console.orders.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="material-symbols-rounded fs-5 me-1">refresh</i>
                                Clear
                            </a>
                        </div>
                    </form>

                    <!-- Date Filters for Export -->
                    <form action="{{ route('console.orders.export') }}" method="GET" class="row g-3 mt-3 pt-3 border-top">
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
                            <label class="form-label text-sm">Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-sm">Payment Status</label>
                            <select name="payment_status" class="form-select form-select-sm">
                                <option value="">All Payment Status</option>
                                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="partially_paid" {{ request('payment_status') == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
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
                    @forelse ($orders as $order)
                    <div class="card mb-3 border rounded shadow-sm">
                        <div class="card-body">
                            <!-- Order Header -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">Order #{{ substr($order->order_id, 0, 8) }}</h6>
                                    <p class="text-sm text-muted mb-0">{{ $order->created_at->format('M d, Y H:i') }}</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <br>
                                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'partially_paid' ? 'warning' : 'danger') }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Customer Info -->
                            <div class="mb-2">
                                <p class="text-sm mb-1">
                                    <strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }}
                                </p>
                                <p class="text-sm mb-1">
                                    <strong>Child:</strong> {{ $order->child->name ?? 'N/A' }}
                                </p>
                            </div>

                            <!-- Order Items -->
                            <div class="mb-2">
                                <p class="text-sm mb-1"><strong>Items:</strong></p>
                                @foreach($order->items->take(2) as $item)
                                <p class="text-xs text-muted mb-0">
                                    {{ $item->product->name ?? 'Product' }} x{{ $item->quantity }}
                                </p>
                                @endforeach
                                @if($order->items->count() > 2)
                                <p class="text-xs text-muted mb-0">+{{ $order->items->count() - 2 }} more items</p>
                                @endif
                            </div>

                            <!-- Pricing -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-sm">Subtotal:</span>
                                    <span class="text-sm">${{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                @if($order->discount_amount > 0)
                                <div class="d-flex justify-content-between">
                                    <span class="text-sm text-danger">Discount:</span>
                                    <span class="text-sm text-danger">-${{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                                @endif
                                <div class="d-flex justify-content-between">
                                    <span class="text-sm fw-bold">Total:</span>
                                    <span class="text-sm fw-bold">${{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('console.orders.show', $order) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="material-symbols-rounded fs-6">visibility</i>
                                    View
                                </a>
                                <a href="{{ route('console.orders.edit', $order) }}"
                                    class="btn btn-sm btn-outline-dark">
                                    <i class="material-symbols-rounded fs-6">edit</i>
                                    Edit
                                </a>
                                @if($order->status !== 'completed' && $order->payment_status !== 'paid')
                                <form action="{{ route('console.orders.delete', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this order?');">
                                        <i class="material-symbols-rounded fs-6">delete</i>
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="material-symbols-rounded fs-1 mb-3">shopping_cart</i>
                        <p>No orders found.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Desktop View (Table) -->
                <div class="d-none d-md-block table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Order ID</th>
                                <th>Customer</th>
                                <th>Child</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Date</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-sm font-weight-bold mb-0">#{{ substr($order->order_id, 0, 8) }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">{{ $order->user->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-muted mb-0">{{ $order->user->email ?? 'N/A' }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">{{ $order->child->name ?? 'N/A' }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">{{ $order->items->count() }} items</p>
                                    <p class="text-xs text-muted mb-0">
                                        @foreach($order->items->take(2) as $item)
                                            {{ $item->product->name ?? 'Product' }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                        @if($order->items->count() > 2)
                                            +{{ $order->items->count() - 2 }} more
                                        @endif
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">${{ number_format($order->total_amount, 2) }}</p>
                                    @if($order->discount_amount > 0)
                                    <p class="text-xs text-danger mb-0">-${{ number_format($order->discount_amount, 2) }} off</p>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'partially_paid' ? 'warning' : 'danger') }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                    </span>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">{{ $order->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-muted mb-0">{{ $order->created_at->format('H:i') }}</p>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('console.orders.show', $order) }}"
                                        class="btn btn-sm btn-outline-primary me-1" title="View">
                                        <i class="material-symbols-rounded fs-5">visibility</i>
                                    </a>
                                    <a href="{{ route('console.orders.edit', $order) }}"
                                        class="btn btn-sm btn-outline-dark me-1" title="Edit">
                                        <i class="material-symbols-rounded fs-5">edit</i>
                                    </a>
                                    @if($order->status !== 'completed' && $order->payment_status !== 'paid')
                                    <form action="{{ route('console.orders.delete', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this order?');" title="Delete">
                                            <i class="material-symbols-rounded fs-5">delete</i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="material-symbols-rounded fs-1 mb-3">shopping_cart</i>
                                    <p>No orders found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="card-footer bg-white">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
