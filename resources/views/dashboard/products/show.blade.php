@extends('dashboard.layouts.app')

@section('title', $product->name . ' - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">{{ $product->name }}</h4>
                    <p class="text-muted mb-0">Product Details</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('console.products.edit', $product) }}" class="btn btn-dark btn-sm">
                        <i class="material-symbols-rounded fs-5 me-1">edit</i>
                        Edit Product
                    </a>
                    <a href="{{ route('console.products.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="material-symbols-rounded fs-5 me-1">arrow_back</i>
                        Back to Products
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Product Images -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Product Images</h6>
                        </div>
                        <div class="card-body">
                            @if($images->count() > 0)
                            <div class="row">
                                @foreach($images as $index => $image)
                                <div class="col-md-6 col-sm-4 col-6 mb-3">
                                    <img src="{{ $image['url'] }}" alt="Product Image {{ $index + 1 }}"
                                        class="img-fluid rounded shadow-sm cursor-pointer"
                                        style="height: 200px; width: 100%; object-fit: cover;"
                                        data-bs-toggle="modal" data-bs-target="#imageModal"
                                        data-image="{{ $image['url'] }}" />
                                    <small class="text-muted d-block mt-1">{{ $image['name'] }}</small>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center text-muted py-4">
                                <i class="material-symbols-rounded fs-1 mb-3">image</i>
                                <p>No images uploaded</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Basic Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label text-muted small">Product Name</label>
                                    <p class="mb-0 fw-bold">{{ $product->name }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label text-muted small">SKU</label>
                                    <p class="mb-0">{{ $product->sku }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label text-muted small">Product Type</label>
                                    <p class="mb-0">{{ $product->type ?? 'Not specified' }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label text-muted small">Status</label>
                                    <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label text-muted small">Description</label>
                                    <p class="mb-0">{{ $product->description ?? 'No description provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Pricing Information -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Pricing Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Current Price</label>
                                <h4 class="mb-0 text-primary">${{ number_format($product->price, 2) }}</h4>
                            </div>
                            @if($product->compare_price && $product->compare_price > $product->price)
                            <div class="mb-3">
                                <label class="form-label text-muted small">Compare Price</label>
                                <p class="mb-0 text-decoration-line-through text-muted">${{ number_format($product->compare_price, 2) }}</p>
                            </div>
                            @endif
                            @if($product->discount)
                            <div class="mb-3">
                                <label class="form-label text-muted small">Discount</label>
                                <p class="mb-0 text-danger fw-bold">{{ $product->discount }}% OFF</p>
                            </div>
                            @endif
                            @if($product->discount_start_date && $product->discount_end_date)
                            <div class="mb-3">
                                <label class="form-label text-muted small">Discount Period</label>
                                <p class="mb-0 small">
                                    {{ \Carbon\Carbon::parse($product->discount_start_date)->format('M d, Y') }} -
                                    {{ \Carbon\Carbon::parse($product->discount_end_date)->format('M d, Y') }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Stock Information -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Stock Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Current Stock</label>
                                <h4 class="mb-0 {{ $product->stock_quantity <= ($product->low_stock_threshold ?? 0) ? 'text-danger' : 'text-success' }}">
                                    {{ $product->stock_quantity }}
                                </h4>
                                @if($product->low_stock_threshold && $product->stock_quantity <= $product->low_stock_threshold)
                                <small class="text-danger">Low Stock Alert!</small>
                                @endif
                            </div>
                            @if($product->low_stock_threshold)
                            <div class="mb-3">
                                <label class="form-label text-muted small">Low Stock Threshold</label>
                                <p class="mb-0">{{ $product->low_stock_threshold }}</p>
                            </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label text-muted small">Stock Status</label>
                                <p class="mb-0">
                                    @if($product->stock_quantity > 0)
                                        <span class="badge bg-success">In Stock</span>
                                    @else
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Files -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Product Files</h6>
                        </div>
                        <div class="card-body">
                            @if($product->getMedia('product_files')->count() > 0)
                            <div class="mb-3">
                                @foreach($product->getMedia('product_files') as $file)
                                <div class="d-flex align-items-center p-2 border rounded">
                                    <i class="material-symbols-rounded fs-5 me-2 text-primary">file_present</i>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 small">{{ $file->file_name }}</p>
                                        <small class="text-muted">{{ number_format($file->size / 1024, 2) }} KB</small>
                                    </div>
                                    <a href="{{ $file->getUrl() }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="material-symbols-rounded fs-6">download</i>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center text-muted py-4">
                                <i class="material-symbols-rounded fs-1 mb-3">file_present</i>
                                <p>No files uploaded</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Attributes -->
            @if(count($product->getAttributesArray()) > 0)
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Product Attributes</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($product->getAttributesArray() as $key => $value)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="d-flex justify-content-between p-3 border rounded">
                                        <div>
                                            <strong class="text-muted small">{{ $key }}</strong>
                                            <p class="mb-0">{{ $value }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Additional Information -->
            @if($product->notes)
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Additional Notes</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $product->notes }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Product Statistics -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Product Statistics</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="text-center">
                                        <h5 class="mb-1 text-primary">{{ $product->getImages()->count() }}</h5>
                                        <small class="text-muted">Images</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="text-center">
                                        <h5 class="mb-1 text-success">{{ $product->getMedia('product_files')->count() }}</h5>
                                        <small class="text-muted">Files</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="text-center">
                                        <h5 class="mb-1 text-info">{{ \Carbon\Carbon::parse($product->created_at)->format('M d, Y') }}</h5>
                                        <small class="text-muted">Created</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="text-center">
                                        <h5 class="mb-1 text-warning">{{ \Carbon\Carbon::parse($product->updated_at)->format('M d, Y') }}</h5>
                                        <small class="text-muted">Last Updated</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
