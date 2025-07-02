@extends('dashboard.layouts.app')

@section('title', 'Create Category - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-radius-lg">

                <!-- Card Header -->
                <div class="card-header bg-white pb-0">
                    <h5 class="mb-0">Create New Category</h5>
                    <p class="text-sm text-muted mb-0">Fill in the details to create a new category.</p>
                </div>

                <!-- Form -->
                <div class="card-body p-4">
                    <form action="{{ route('console.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Category Name -->
                        <x-inputs.text name="category_name" label="Category Name" :value="old('category_name')"
                            placeholder="Enter category name" required />

                        <!-- Description -->
                        <x-inputs.textarea name="description" label="Description" :value="old('description')" rows="5"
                            placeholder="Describe this category..." />

                        <!-- Image Upload -->
                        <x-inputs.file name="image" label="Image" accept="image/*" />

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('console.categories.index') }}"
                                class="btn btn-outline-secondary btn-sm px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark btn-sm px-4">
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
