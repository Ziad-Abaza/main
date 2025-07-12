@extends('dashboard.layouts.app')

@section('title', 'Edit Order Item - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <a href="{{ route('console.order_items.show', $orderItem) }}" class="btn btn-outline-secondary">
                    <i class="material-symbols-rounded fs-5 me-1">arrow_back</i>
                    Back to Item Details
                </a>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Edit Order Item</h5>
                            <p class="text-sm text-muted mb-0">Update order item information</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('console.order_items.update', $orderItem) }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="mb-4">
                                    <label for="item_type" class="form-label">Item Type <span class="text-danger">*</span></label>
                                    <input type="text" name="item_type" id="item_type" class="form-control @error('item_type') is-invalid @enderror" value="{{ old('item_type', $orderItem->item_type) }}" required>
                                    @error('item_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $orderItem->quantity) }}" min="1" required>
                                    @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="unit_price" class="form-label">Unit Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control @error('unit_price') is-invalid @enderror" value="{{ old('unit_price', $orderItem->unit_price) }}" min="0" required>
                                    @error('unit_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="total_price" class="form-label">Total Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="total_price" id="total_price" class="form-control @error('total_price') is-invalid @enderror" value="{{ old('total_price', $orderItem->total_price) }}" min="0" required>
                                    @error('total_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="material-symbols-rounded fs-5 me-1">save</i>
                                        Update Item
                                    </button>
                                    <a href="{{ route('console.order_items.show', $orderItem) }}" class="btn btn-outline-secondary">
                                        <i class="material-symbols-rounded fs-5 me-1">cancel</i>
                                        Cancel
                                    </a>
                                </div>
                            </form>
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
