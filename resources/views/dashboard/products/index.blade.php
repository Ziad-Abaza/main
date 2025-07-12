@extends('dashboard.layouts.app')

@section('title', 'Products - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-radius-lg">

                <!-- Card Header -->
                <div class="card-header bg-white d-flex justify-content-between align-items-center pb-3">
                    <div>
                        <h5 class="mb-0">Products Management</h5>
                        <p class="text-sm text-muted mb-0">Manage your product inventory</p>
                    </div>
                    <a href="{{ route('console.products.create') }}" class="btn btn-dark btn-sm px-4">
                        <i class="material-symbols-rounded fs-5 me-1">add</i>
                        Add New Product
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="card-body border-bottom">
                    <form action="{{ route('console.products.search') }}" method="GET" class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="material-symbols-rounded fs-5">search</i>
                                </span>
                                <input type="text" name="query" class="form-control border-start-0"
                                    placeholder="Search products by name, SKU, or description..."
                                    value="{{ $query ?? '' }}">
                                <button type="submit" class="btn btn-outline-secondary">Search</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('console.products.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="material-symbols-rounded fs-5 me-1">refresh</i>
                                Clear Search
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Mobile View (Cards) -->
                <div class="d-block d-md-none px-4 pt-3">
                    @forelse ($products as $product)
                    <div class="card mb-3 border rounded shadow-sm searchable-item">
                        <div class="card-body">
                            <!-- Product Image -->
                            <div class="text-center mb-3">
                                @if($product->getImages()->count() > 0)
                                <img src="{{ $product->getImages()->first()['url'] }}" alt="Product Image"
                                    class="w-100 h-auto rounded cursor-pointer" style="max-height: 200px; object-fit: cover;"
                                    data-bs-toggle="modal" data-bs-target="#imageModal"
                                    data-image="{{ $product->getImages()->first()['url'] }}" />
                                @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                     style="height: 200px;">
                                    <span class="text-muted">No image</span>
                                </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <h6 class="mb-1">{{ $product->name }}</h6>
                            <p class="text-sm text-muted mb-1">{{ Str::limit($product->description, 100) ?? 'No description' }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <span class="text-sm text-secondary">SKU: {{ $product->sku }}</span>
                            </div>
                            <div class="row text-sm mb-2">
                                <div class="col-6">
                                    <strong>Price:</strong> ${{ number_format($product->price, 2) }}
                                </div>
                                <div class="col-6">
                                    <strong>Stock:</strong> {{ $product->stock_quantity }}
                                </div>
                            </div>
                            @if($product->discount)
                            <div class="text-sm text-danger mb-2">
                                <strong>Discount:</strong> {{ $product->discount }}%
                            </div>
                            @endif

                            <!-- Actions -->
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ route('console.products.show', $product) }}"
                                        class="btn btn-sm btn-outline-primary me-1" title="View">
                                        <i class="material-symbols-rounded fs-5">visibility</i>
                                    </a>
                                    <a href="{{ route('console.products.edit', $product) }}"
                                        class="btn btn-sm btn-outline-dark me-1" title="Edit">
                                        <i class="material-symbols-rounded fs-5">edit</i>
                                    </a>
                                </div>
                                <div>
                                    <form action="{{ route('console.products.toggle-status', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $product->is_active ? 'warning' : 'success' }}"
                                                title="{{ $product->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="material-symbols-rounded fs-5">
                                                {{ $product->is_active ? 'visibility_off' : 'visibility' }}
                                            </i>
                                        </button>
                                    </form>
                                    <form action="{{ route('console.products.delete', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger ms-1"
                                            onclick="return confirm('Are you sure you want to delete this product?');" title="Delete">
                                            <i class="material-symbols-rounded fs-5">delete</i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="material-symbols-rounded fs-1 mb-3">inventory_2</i>
                        <p>No products found.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Desktop View (Table) -->
                <div class="d-none d-md-block table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Product</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr class="searchable-item">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if($product->getImages()->count() > 0)
                                            <img src="{{ $product->getImages()->first()['url'] }}" alt="Product Image"
                                                class="rounded-circle avatar-sm cursor-pointer" data-bs-toggle="modal"
                                                data-bs-target="#imageModal" data-image="{{ $product->getImages()->first()['url'] }}" />
                                            @else
                                            <div class="rounded-circle avatar-sm bg-light d-flex align-items-center justify-content-center">
                                                <i class="material-symbols-rounded fs-6 text-muted">inventory_2</i>
                                            </div>
                                            @endif
                                        </div>
                                                                                    <div>
                                                <p class="text-sm font-weight-bold mb-0">{{ $product->name }}</p>
                                                <p class="text-xs text-muted mb-0">{{ Str::limit($product->description, 50) ?? 'No description' }}</p>
                                                @if(count($product->getAttributesArray()) > 0)
                                                <div class="mt-1">
                                                    @foreach(array_slice($product->getAttributesArray(), 0, 2) as $key => $value)
                                                    <span class="badge bg-light text-dark me-1" style="font-size: 0.7rem;">
                                                        {{ $key }}: {{ $value }}
                                                    </span>
                                                    @endforeach
                                                    @if(count($product->getAttributesArray()) > 2)
                                                    <span class="badge bg-secondary" style="font-size: 0.7rem;">
                                                        +{{ count($product->getAttributesArray()) - 2 }} more
                                                    </span>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $product->sku }}</span>
                                </td>
                                <td>
                                    <div>
                                        <span class="text-sm font-weight-bold">${{ number_format($product->price, 2) }}</span>
                                        @if($product->compare_price && $product->compare_price > $product->price)
                                        <br><span class="text-xs text-muted text-decoration-line-through">${{ number_format($product->compare_price, 2) }}</span>
                                        @endif
                                        @if($product->discount)
                                        <br><span class="text-xs text-danger">-{{ $product->discount }}%</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="text-sm {{ $product->stock_quantity <= ($product->low_stock_threshold ?? 0) ? 'text-danger' : '' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                    @if($product->low_stock_threshold && $product->stock_quantity <= $product->low_stock_threshold)
                                    <br><span class="text-xs text-danger">Low Stock</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('console.products.show', $product) }}"
                                        class="btn btn-sm btn-outline-primary me-1" title="View">
                                        <i class="material-symbols-rounded fs-5">visibility</i>
                                    </a>
                                    <a href="{{ route('console.products.edit', $product) }}"
                                        class="btn btn-sm btn-outline-dark me-1" title="Edit">
                                        <i class="material-symbols-rounded fs-5">edit</i>
                                    </a>
                                    <form action="{{ route('console.products.toggle-status', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $product->is_active ? 'warning' : 'success' }}"
                                                title="{{ $product->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="material-symbols-rounded fs-5">
                                                {{ $product->is_active ? 'visibility_off' : 'visibility' }}
                                            </i>
                                        </button>
                                    </form>
                                    <form action="{{ route('console.products.delete', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger ms-1"
                                            onclick="return confirm('Are you sure you want to delete this product?');" title="Delete">
                                            <i class="material-symbols-rounded fs-5">delete</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="material-symbols-rounded fs-1 mb-3">inventory_2</i>
                                    <p>No products found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="card-footer bg-white">
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade custom-rtl" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
                <button type="button" class="btn btn-close m-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="material-symbols-rounded fs-4 text-dark">close</i>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="" alt="Product Image" class="img-fluid" id="modalImage" />
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image modal functionality
    const imageModal = document.getElementById('imageModal');
    if (imageModal) {
        imageModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const imageUrl = button.getAttribute('data-image');
            const modalImage = imageModal.querySelector('#modalImage');
            modalImage.src = imageUrl;
        });
    }
});
</script>
@endpush
