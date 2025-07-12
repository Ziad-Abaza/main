@extends('dashboard.layouts.app')

@section('title', 'Order Item Details - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <a href="{{ route('console.order_items.index') }}" class="btn btn-outline-secondary">
                    <i class="material-symbols-rounded fs-5 me-1">arrow_back</i>
                    Back to Order Items
                </a>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-radius-lg mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Order Item Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    @if($orderItem->product && $orderItem->product->images)
                                        @php
                                            $images = is_string($orderItem->product->images) ? json_decode($orderItem->product->images, true) : $orderItem->product->images;
                                            $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                                        @endphp
                                        @if($firstImage)
                                        <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $orderItem->product->name }}" class="rounded w-100" style="max-width:120px;max-height:120px;object-fit:cover;">
                                        @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:120px;height:120px;">
                                            <i class="material-symbols-rounded text-muted">image</i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:120px;height:120px;">
                                        <i class="material-symbols-rounded text-muted">image</i>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h6 class="mb-1">{{ $orderItem->product->name ?? 'Product' }}</h6>
                                    <p class="text-sm text-muted mb-0">Type: <span class="badge bg-dark">{{ ucfirst($orderItem->item_type) }}</span></p>
                                    <p class="text-sm mb-0">Product ID: {{ $orderItem->product_id }}</p>
                                    <p class="text-sm mb-0">Item ID: {{ $orderItem->item_id }}</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="text-sm mb-1"><strong>Quantity:</strong> {{ $orderItem->quantity }}</p>
                                <p class="text-sm mb-1"><strong>Unit Price:</strong> ${{ number_format($orderItem->unit_price, 2) }}</p>
                                <p class="text-sm mb-1"><strong>Total Price:</strong> ${{ number_format($orderItem->total_price, 2) }}</p>
                            </div>
                            <div class="mb-3">
                                <a href="{{ route('console.orders.show', $orderItem->order) }}" class="btn btn-outline-info btn-sm">
                                    <i class="material-symbols-rounded fs-6 me-1">receipt_long</i>
                                    View Parent Order
                                </a>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('console.order_items.edit', $orderItem) }}" class="btn btn-outline-dark">
                                    <i class="material-symbols-rounded fs-5 me-1">edit</i>
                                    Edit Item
                                </a>
                                <form action="{{ route('console.order_items.delete', $orderItem) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Delete this item?');">
                                        <i class="material-symbols-rounded fs-5 me-1">delete</i>
                                        Delete Item
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-lg border-radius-lg mb-4">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Order Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Order ID</p>
                                <p class="text-sm font-weight-bold mb-0">#{{ $orderItem->order->order_id }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Customer</p>
                                <p class="text-sm font-weight-bold mb-0">{{ $orderItem->order->user->name ?? 'N/A' }}</p>
                                <p class="text-xs text-muted mb-0">{{ $orderItem->order->user->email ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Child</p>
                                <p class="text-sm font-weight-bold mb-0">{{ $orderItem->order->child->name ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="text-sm text-muted mb-1">Order Date</p>
                                <p class="text-sm font-weight-bold mb-0">{{ $orderItem->order->created_at->format('F d, Y') }}</p>
                                <p class="text-xs text-muted mb-0">{{ $orderItem->order->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
