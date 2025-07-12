@extends('dashboard.layouts.app')

@section('title', 'Order Details - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('console.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="material-symbols-rounded fs-5 me-1">arrow_back</i>
                    Back to Orders
                </a>
            </div>

            <!-- Order Header Card -->
            <div class="card shadow-lg border-radius-lg mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Order #{{ $order->order_id }}</h5>
                        <p class="text-sm text-muted mb-0">Placed on {{ $order->created_at->format('F d, Y \a\t H:i') }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('console.orders.edit', $order) }}" class="btn btn-outline-dark">
                            <i class="material-symbols-rounded fs-5 me-1">edit</i>
                            Edit Order
                        </a>
                        @if($order->status !== 'completed' && $order->payment_status !== 'paid')
                        <form action="{{ route('console.orders.delete', $order) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger"
                                onclick="return confirm('Are you sure you want to delete this order?');">
                                <i class="material-symbols-rounded fs-5 me-1">delete</i>
                                Delete Order
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Order Details -->
                <div class="col-lg-8">
                    <!-- Order Items -->
                    <div class="card shadow-lg border-radius-lg mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Order Items</h6>
                        </div>
                        <div class="card-body p-0">
                            @if($order->items->count())
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Type</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->images)
                                                        @php
                                                            $images = is_string($item->product->images) ? json_decode($item->product->images, true) : $item->product->images;
                                                            $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                                                        @endphp
                                                        @if($firstImage)
                                                        <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $item->product->name }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                        @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                            <i class="material-symbols-rounded text-muted">image</i>
                                                        </div>
                                                        @endif
                                                    @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                        <i class="material-symbols-rounded text-muted">image</i>
                                                    </div>
                                                    @endif
                                                    <span>{{ $item->product->name ?? 'Product' }}</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-dark">{{ ucfirst($item->item_type) }}</span></td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>${{ number_format($item->unit_price, 2) }}</td>
                                            <td>${{ number_format($item->total_price, 2) }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('console.order_items.show', $item) }}" class="btn btn-sm btn-outline-primary me-1" title="View" target="_blank">
                                                    <i class="material-symbols-rounded fs-6">visibility</i>
                                                </a>
                                                <a href="{{ route('console.order_items.edit', $item) }}" class="btn btn-sm btn-outline-dark me-1" title="Edit" target="_blank">
                                                    <i class="material-symbols-rounded fs-6">edit</i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center text-muted py-4">
                                <i class="material-symbols-rounded fs-1 mb-3">shopping_cart</i>
                                <p>No items found in this order.</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment History -->
                    @if($order->payments->count() > 0)
                    <div class="card shadow-lg border-radius-lg mb-4">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Payment History</h6>
                        </div>
                        <div class="card-body p-0">
                            @foreach($order->payments as $payment)
                            <div class="d-flex justify-content-between align-items-center p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div>
                                    <p class="text-sm font-weight-bold mb-0">{{ ucfirst($payment->payment_method) }}</p>
                                    <p class="text-xs text-muted mb-0">{{ $payment->created_at->format('M d, Y H:i') }}</p>
                                </div>
                                <div class="text-end">
                                    <p class="text-sm font-weight-bold mb-0">${{ number_format($payment->amount, 2) }}</p>
                                    <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <!-- Customer Information -->
                    <div class="card shadow-lg border-radius-lg mb-4">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Customer Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Customer</p>
                                <p class="text-sm font-weight-bold mb-0">{{ $order->user->name ?? 'N/A' }}</p>
                                <p class="text-xs text-muted mb-0">{{ $order->user->email ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Child</p>
                                <p class="text-sm font-weight-bold mb-0">{{ $order->child->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-muted mb-1">Order Date</p>
                                <p class="text-sm font-weight-bold mb-0">{{ $order->created_at->format('F d, Y') }}</p>
                                <p class="text-xs text-muted mb-0">{{ $order->created_at->format('H:i') }}</p>
                            </div>
                            @if($order->completed_at)
                            <div class="mt-3">
                                <p class="text-sm text-muted mb-1">Completed Date</p>
                                <p class="text-sm font-weight-bold mb-0">{{ $order->completed_at->format('F d, Y') }}</p>
                                <p class="text-xs text-muted mb-0">{{ $order->completed_at->format('H:i') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Status -->
                    <div class="card shadow-lg border-radius-lg mb-4">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Order Status</h6>
                        </div>
                        <div class="card-body">
                            <!-- Current Status -->
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Current Status</p>
                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }} fs-6">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <!-- Status Update -->
                            <form action="{{ route('console.orders.update-status', $order) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="status" class="form-label text-sm">Update Status</label>
                                    <select name="status" id="status" class="form-select form-select-sm">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100">Update Status</button>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="card shadow-lg border-radius-lg mb-4">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Payment Status</h6>
                        </div>
                        <div class="card-body">
                            <!-- Current Payment Status -->
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Current Payment Status</p>
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'partially_paid' ? 'warning' : 'danger') }} fs-6">
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                </span>
                            </div>

                            <!-- Payment Status Update -->
                            <form action="{{ route('console.orders.update-payment-status', $order) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="payment_status" class="form-label text-sm">Update Payment Status</label>
                                    <select name="payment_status" id="payment_status" class="form-select form-select-sm">
                                        <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        <option value="partially_paid" {{ $order->payment_status == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100">Update Payment Status</button>
                            </form>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Order Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-sm">Subtotal:</span>
                                <span class="text-sm">${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            @if($order->discount_amount > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-sm text-danger">Discount:</span>
                                <span class="text-sm text-danger">-${{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                            @endif
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-sm font-weight-bold">Total:</span>
                                <span class="text-sm font-weight-bold">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
