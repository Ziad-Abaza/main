@extends('dashboard.layouts.app')

@section('title', 'Edit Order - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('console.orders.show', $order) }}" class="btn btn-outline-secondary">
                    <i class="material-symbols-rounded fs-5 me-1">arrow_back</i>
                    Back to Order Details
                </a>
            </div>

            <div class="row">
                <!-- Edit Form -->
                <div class="col-lg-8">
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Edit Order #{{ $order->order_id }}</h5>
                            <p class="text-sm text-muted mb-0">Update order information and status</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('console.orders.update', $order) }}" method="POST">
                                @csrf
                                @method('POST')

                                <!-- Order Status -->
                                <div class="mb-4">
                                    <label for="status" class="form-label">Order Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Select the current status of this order</div>
                                </div>

                                <!-- Payment Status -->
                                <div class="mb-4">
                                    <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                                    <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                                        <option value="unpaid" {{ old('payment_status', $order->payment_status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        <option value="partially_paid" {{ old('payment_status', $order->payment_status) == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                                        <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                    </select>
                                    @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Select the current payment status of this order</div>
                                </div>

                                <!-- Notes -->
                                <div class="mb-4">
                                    <label for="notes" class="form-label">Notes (Optional)</label>
                                    <textarea name="notes" id="notes" rows="4"
                                        class="form-control @error('notes') is-invalid @enderror"
                                        placeholder="Add any additional notes about this order...">{{ old('notes', $order->notes ?? '') }}</textarea>
                                    @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional notes for internal reference</div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="material-symbols-rounded fs-5 me-1">save</i>
                                        Update Order
                                    </button>
                                    <a href="{{ route('console.orders.show', $order) }}" class="btn btn-outline-secondary">
                                        <i class="material-symbols-rounded fs-5 me-1">cancel</i>
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <!-- Order Information -->
                    <div class="card shadow-lg border-radius-lg mb-4">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Order Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Order ID</p>
                                <p class="text-sm font-weight-bold mb-0">#{{ $order->order_id }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Customer</p>
                                <p class="text-sm font-weight-bold mb-0">{{ $order->user->name ?? 'N/A' }}</p>
                                <p class="text-xs text-muted mb-0">{{ $order->user->email ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Child</p>
                                <p class="text-sm font-weight-bold mb-0">{{ $order->child->name ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Order Date</p>
                                <p class="text-sm font-weight-bold mb-0">{{ $order->created_at->format('F d, Y') }}</p>
                                <p class="text-xs text-muted mb-0">{{ $order->created_at->format('H:i') }}</p>
                            </div>
                            @if($order->completed_at)
                            <div>
                                <p class="text-sm text-muted mb-1">Completed Date</p>
                                <p class="text-sm font-weight-bold mb-0">{{ $order->completed_at->format('F d, Y') }}</p>
                                <p class="text-xs text-muted mb-0">{{ $order->completed_at->format('H:i') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Current Status -->
                    <div class="card shadow-lg border-radius-lg mb-4">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Current Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Order Status</p>
                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }} fs-6">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-muted mb-1">Payment Status</p>
                                <span class="badge bg-{{ $order->status == 'paid' ? 'success' : ($order->payment_status == 'partially_paid' ? 'warning' : 'danger') }} fs-6">
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Order Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <p class="text-sm text-muted mb-1">Items</p>
                                <p class="text-sm font-weight-bold mb-0">{{ $order->items->count() }} items</p>
                            </div>
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
