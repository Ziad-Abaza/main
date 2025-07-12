@extends('dashboard.layouts.app')

@section('title', 'Create Product - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-12">
            <div class="card shadow-lg border-radius-lg">

                <!-- Card Header -->
                <div class="card-header bg-white pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Create New Product</h5>
                            <p class="text-sm text-muted mb-0">Fill in the details to create a new product.</p>
                        </div>
                        <a href="{{ route('console.products.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="material-symbols-rounded fs-5 me-1">arrow_back</i>
                            Back to Products
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div class="card-body p-4">
                    <form action="{{ route('console.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <h6 class="mb-3 text-dark">Basic Information</h6>

                                <!-- Product Name -->
                                <x-inputs.text name="name" label="Product Name" :value="old('name')"
                                    placeholder="Enter product name" required />

                                                                <!-- Description -->
                                <x-inputs.textarea name="description" label="Description (Optional)" :value="old('description')"
                                    rows="4" placeholder="Describe this product..." />

                                <!-- SKU -->
                                <x-inputs.text name="sku" label="SKU (Stock Keeping Unit)" :value="old('sku')"
                                    placeholder="Enter unique SKU" required />

                                <!-- Product Type -->
                                <x-inputs.text name="type" label="Product Type (Optional)" :value="old('type')"
                                    placeholder="e.g., Physical, Digital, Service" />
                            </div>

                            <!-- Pricing & Stock -->
                            <div class="col-md-4">
                                <h6 class="mb-3 text-dark">Pricing & Stock</h6>

                                <!-- Price -->
                                <x-inputs.number name="price" label="Price ($)" :value="old('price')"
                                    placeholder="0.00" step="0.01" min="0" required />

                                <!-- Compare Price -->
                                <x-inputs.number name="compare_price" label="Compare Price ($) (Optional)" :value="old('compare_price')"
                                    placeholder="0.00" step="0.01" min="0" />

                                <!-- Stock Quantity -->
                                <x-inputs.number name="stock_quantity" label="Stock Quantity" :value="old('stock_quantity')"
                                    placeholder="0" min="0" required />

                                <!-- Low Stock Threshold -->
                                <x-inputs.number name="low_stock_threshold" label="Low Stock Threshold (Optional)" :value="old('low_stock_threshold')"
                                    placeholder="0" min="0" />
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Discount Information -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-3 text-dark">Discount Information</h6>
                            </div>
                            <div class="col-md-4">
                                <x-inputs.number name="discount" label="Discount Percentage (Optional)" :value="old('discount')"
                                    placeholder="0" min="0" max="100" step="0.01" />
                            </div>
                            <div class="col-md-4">
                                <x-inputs.date name="discount_start_date" label="Discount Start Date (Optional)" :value="old('discount_start_date')" />
                            </div>
                            <div class="col-md-4">
                                <x-inputs.date name="discount_end_date" label="Discount End Date (Optional)" :value="old('discount_end_date')" />
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Media Upload -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-3 text-dark">Media & Files</h6>
                            </div>
                            <div class="col-md-8">
                                                                <!-- Product Images -->
                                <div class="mb-3">
                                    <label class="form-label">Product Images (Optional) <span class="text-muted">(Multiple images allowed)</span></label>
                                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                                    <div class="form-text">Upload multiple images. Supported formats: JPEG, PNG, JPG, GIF, WebP. Max 2MB each.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Product File -->
                                <div class="mb-3">
                                    <label class="form-label">Product File (Optional)</label>
                                    <input type="file" name="product_file" class="form-control"
                                           accept=".pdf,.zip,.xlsx,.xls,.rar">
                                    <div class="form-text">Upload product file. Supported formats: PDF, ZIP, XLSX, XLS, RAR. Max 10MB.</div>
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
                                <x-inputs.textarea name="notes" label="Notes (Optional)" :value="old('notes')"
                                    rows="3" placeholder="Additional notes about this product..." />

                                <!-- Active Status -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                               value="1" {{ old('is_active') ? 'checked' : '' }}>
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
                                Create Product
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
    // Auto-generate SKU if empty
    const nameInput = document.querySelector('input[name="name"]');
    const skuInput = document.querySelector('input[name="sku"]');

    if (nameInput && skuInput) {
        nameInput.addEventListener('blur', function() {
            if (!skuInput.value && this.value) {
                const sku = this.value
                    .toUpperCase()
                    .replace(/[^A-Z0-9]/g, '')
                    .substring(0, 8) + '-' + Date.now().toString().slice(-4);
                skuInput.value = sku;
            }
        });
    }

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
    let attributeIndex = 1;

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
