@extends('dashboard.layouts.app')

@section('title', 'Edit Product - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-12">
            <div class="card shadow-lg border-radius-lg">

                <!-- Card Header -->
                <div class="card-header bg-white pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Edit Product</h5>
                            <p class="text-sm text-muted mb-0">Update the details of the product.</p>
                        </div>
                        <a href="{{ route('console.products.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="material-symbols-rounded fs-5 me-1">arrow_back</i>
                            Back to Products
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div class="card-body p-4">
                    <form action="{{ route('console.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <h6 class="mb-3 text-dark">Basic Information</h6>

                                <!-- Product Name -->
                                <x-inputs.text name="name" label="Product Name"
                                    :value="old('name', $product->name)" placeholder="Enter product name" required />

                                                                <!-- Description -->
                                <x-inputs.textarea name="description" label="Description (Optional)"
                                    :value="old('description', $product->description)" rows="4"
                                    placeholder="Describe this product..." />

                                <!-- SKU -->
                                <x-inputs.text name="sku" label="SKU (Stock Keeping Unit)"
                                    :value="old('sku', $product->sku)" placeholder="Enter unique SKU" required />

                                <!-- Product Type -->
                                <x-inputs.text name="type" label="Product Type (Optional)"
                                    :value="old('type', $product->type)" placeholder="e.g., Physical, Digital, Service" />
                            </div>

                            <!-- Pricing & Stock -->
                            <div class="col-md-4">
                                <h6 class="mb-3 text-dark">Pricing & Stock</h6>

                                <!-- Price -->
                                <x-inputs.number name="price" label="Price ($)"
                                    :value="old('price', $product->price)" placeholder="0.00" step="0.01" min="0" required />

                                                                <!-- Compare Price -->
                                <x-inputs.number name="compare_price" label="Compare Price ($) (Optional)"
                                    :value="old('compare_price', $product->compare_price)" placeholder="0.00" step="0.01" min="0" />

                                <!-- Stock Quantity -->
                                <x-inputs.number name="stock_quantity" label="Stock Quantity"
                                    :value="old('stock_quantity', $product->stock_quantity)" placeholder="0" min="0" required />

                                <!-- Low Stock Threshold -->
                                <x-inputs.number name="low_stock_threshold" label="Low Stock Threshold (Optional)"
                                    :value="old('low_stock_threshold', $product->low_stock_threshold)" placeholder="0" min="0" />
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Discount Information -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-3 text-dark">Discount Information</h6>
                            </div>
                                                        <div class="col-md-4">
                                <x-inputs.number name="discount" label="Discount Percentage (Optional)"
                                    :value="old('discount', $product->discount)" placeholder="0" min="0" max="100" step="0.01" />
                            </div>
                            <div class="col-md-4">
                                <x-inputs.date name="discount_start_date" label="Discount Start Date (Optional)"
                                    :value="old('discount_start_date', $product->discount_start_date)" />
                            </div>
                            <div class="col-md-4">
                                <x-inputs.date name="discount_end_date" label="Discount End Date (Optional)"
                                    :value="old('discount_end_date', $product->discount_end_date)" />
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Current Images -->
                        @if($images->count() > 0)
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-3 text-dark">Current Product Images</h6>
                                <div class="row" id="current-images">
                                    @foreach($images as $image)
                                    <div class="col-md-3 col-sm-4 col-6 mb-3" data-image-id="{{ $image['id'] }}">
                                        <div class="position-relative">
                                            <img src="{{ $image['url'] }}" alt="Product Image"
                                                class="img-fluid rounded shadow-sm" style="height: 150px; width: 100%; object-fit: cover;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-image"
                                                data-image-id="{{ $image['id'] }}" data-product-id="{{ $product->product_id }}">
                                                <i class="material-symbols-rounded fs-6">close</i>
                                            </button>
                                        </div>
                                        <small class="text-muted d-block mt-1">{{ $image['name'] }}</small>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        @endif

                        <!-- Media Upload -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-3 text-dark">Add New Media & Files</h6>
                            </div>
                            <div class="col-md-8">
                                <!-- Product Images -->
                                <div class="mb-3">
                                    <label class="form-label">Add Product Images (Optional) <span class="text-muted">(Multiple images allowed)</span></label>
                                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                                    <div class="form-text">Upload additional images. Supported formats: JPEG, PNG, JPG, GIF, WebP. Max 2MB each.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Product File -->
                                <div class="mb-3">
                                    <label class="form-label">Product File (Optional)</label>
                                    @if($product->getMedia('product_files')->count() > 0)
                                    <div class="mb-2">
                                        <small class="text-muted">Current file:</small><br>
                                        <a href="{{ $product->getMedia('product_files')->first()->getUrl() }}" target="_blank" class="text-decoration-none">
                                            <i class="material-symbols-rounded fs-6 me-1">file_present</i>
                                            {{ $product->getMedia('product_files')->first()->file_name }}
                                        </a>
                                    </div>
                                    @endif
                                    <input type="file" name="product_file" class="form-control"
                                           accept=".pdf,.zip,.xlsx,.xls,.rar">
                                    <div class="form-text">Upload new product file. Supported formats: PDF, ZIP, XLSX, XLS, RAR. Max 10MB.</div>
                                </div>
                            </div>
                        </div>

                                                <hr class="my-4">

                        <!-- Product Attributes -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-3 text-dark">Product Attributes (Optional)</h6>
                                <p class="text-sm text-muted mb-3">Add custom attributes like color, size, material, etc.</p>

                                <div id="attributes-container">
                                    @php
                                        $attributes = $product->getAttributesArray();
                                        $attributeIndex = 0;
                                    @endphp

                                    @if(count($attributes) > 0)
                                        @foreach($attributes as $key => $value)
                                            <div class="attribute-row row mb-2">
                                                <div class="col-md-5">
                                                    <input type="text" name="attributes[{{ $attributeIndex }}][key]" class="form-control"
                                                           value="{{ old("attributes.{$attributeIndex}.key", $key) }}" placeholder="Attribute name (e.g., Color)">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" name="attributes[{{ $attributeIndex }}][value]" class="form-control"
                                                           value="{{ old("attributes.{$attributeIndex}.value", $value) }}" placeholder="Attribute value (e.g., Red)">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-attribute">
                                                        <i class="material-symbols-rounded fs-6">delete</i>
                                                    </button>
                                                </div>
                                            </div>
                                            @php $attributeIndex++; @endphp
                                        @endforeach
                                    @else
                                        <div class="attribute-row row mb-2">
                                            <div class="col-md-5">
                                                <input type="text" name="attributes[0][key]" class="form-control" placeholder="Attribute name (e.g., Color)">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" name="attributes[0][value]" class="form-control" placeholder="Attribute value (e.g., Red)">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-attribute" style="display: none;">
                                                    <i class="material-symbols-rounded fs-6">delete</i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-attribute">
                                    <i class="material-symbols-rounded fs-6 me-1">add</i>
                                    Add Attribute
                                </button>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Additional Information -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-3 text-dark">Additional Information</h6>

                                <!-- Notes -->
                                <x-inputs.textarea name="notes" label="Notes (Optional)"
                                    :value="old('notes', $product->notes)" rows="3"
                                    placeholder="Additional notes about this product..." />

                                <!-- Active Status -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                               value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Product
                                        </label>
                                        <div class="form-text">Check this to make the product visible to customers.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('console.products.index') }}"
                                class="btn btn-outline-secondary btn-sm px-4">
                                <i class="material-symbols-rounded fs-5 me-1">cancel</i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark btn-sm px-4">
                                <i class="material-symbols-rounded fs-5 me-1">save</i>
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove image functionality
    document.querySelectorAll('.remove-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.getAttribute('data-image-id');
            const productId = this.getAttribute('data-product-id');
            const imageContainer = this.closest('.col-md-3');

            if (confirm('Are you sure you want to remove this image?')) {
                fetch(`/console/products/${productId}/remove-image`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        media_id: imageId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        imageContainer.remove();
                        // Show success message
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-success alert-dismissible fade show';
                        alert.innerHTML = `
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        document.querySelector('.card-body').insertBefore(alert, document.querySelector('.card-body').firstChild);
                    } else {
                        alert('Failed to remove image: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while removing the image.');
                });
            }
        });
    });

    // Validate discount end date is after start date
    const discountStartDate = document.querySelector('input[name="discount_start_date"]');
    const discountEndDate = document.querySelector('input[name="discount_end_date"]');

    if (discountStartDate && discountEndDate) {
        discountStartDate.addEventListener('change', function() {
            if (this.value && discountEndDate.value && this.value >= discountEndDate.value) {
                discountEndDate.value = '';
                alert('Discount end date must be after start date.');
            }
        });
    }

    // Dynamic attributes functionality
    const attributesContainer = document.getElementById('attributes-container');
    const addAttributeBtn = document.getElementById('add-attribute');
    let attributeIndex = {{ count($product->getAttributesArray()) }};

    if (addAttributeBtn && attributesContainer) {
        addAttributeBtn.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.className = 'attribute-row row mb-2';
            newRow.innerHTML = `
                <div class="col-md-5">
                    <input type="text" name="attributes[${attributeIndex}][key]" class="form-control" placeholder="Attribute name (e.g., Color)">
                </div>
                <div class="col-md-5">
                    <input type="text" name="attributes[${attributeIndex}][value]" class="form-control" placeholder="Attribute value (e.g., Red)">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-attribute">
                        <i class="material-symbols-rounded fs-6">delete</i>
                    </button>
                </div>
            `;

            attributesContainer.appendChild(newRow);
            attributeIndex++;

            // Show remove button for the first row if we have more than one row
            const firstRemoveBtn = attributesContainer.querySelector('.remove-attribute');
            if (firstRemoveBtn) {
                firstRemoveBtn.style.display = 'block';
            }
        });

        // Handle remove attribute buttons
        attributesContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-attribute')) {
                const row = e.target.closest('.attribute-row');
                row.remove();

                // Hide remove button for the first row if only one row remains
                const remainingRows = attributesContainer.querySelectorAll('.attribute-row');
                if (remainingRows.length === 1) {
                    const firstRemoveBtn = remainingRows[0].querySelector('.remove-attribute');
                    if (firstRemoveBtn) {
                        firstRemoveBtn.style.display = 'none';
                    }
                }
            }
        });
    }
});
</script>
@endpush
