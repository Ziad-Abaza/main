@extends('dashboard.layouts.app')

@section('title', 'Categories - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-radius-lg">

                <!-- Card Header -->
                <div class="card-header bg-white d-flex justify-content-between align-items-center pb-3">
                    <h5 class="mb-0">Categories Management</h5>
                    <a href="{{ route('console.categories.create') }}" class="btn btn-dark btn-sm px-4">
                        Create New Category
                    </a>
                </div>

                <!-- Mobile View (Cards) -->
                <div class="d-block d-md-none px-4 pt-2">
                    @forelse ($categories as $category)
                    <div class="card mb-3 border rounded shadow-sm searchable-item">
                        <div class="card-body">
                            <!-- Image -->
                            <div class="text-center mb-3">
                                @if($category->getImage())
                                <img src="{{ $category->getImage() }}" alt="Category Image"
                                    class="w-100 h-auto rounded cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#imageModal" data-image="{{ $category->getImage() }}" />
                                @else
                                <span class="text-muted">No image</span>
                                @endif
                            </div>

                            <!-- Info -->
                            <h6 class="mb-1">{{ $category->category_name }}</h6>
                            <p class="text-sm text-muted mb-1">{{ $category->description ?? 'No description' }}</p>
                            <p class="text-xs text-secondary mb-2">ID: {{ $category->id }}</p>

                            <!-- Actions -->
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('console.categories.edit', $category) }}"
                                    class="btn btn-sm btn-outline-dark me-2" title="Edit">
                                    <i class="material-symbols-rounded fs-5">edit</i>
                                </a>
                                <form action="{{ route('console.categories.delete', $category) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this category?');">
                                        <i class="material-symbols-rounded fs-5">delete</i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">No categories found.</div>
                    @endforelse
                </div>

                <!-- Desktop View (Table) -->
                <div class="d-none d-md-block table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Category Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                            <tr class="searchable-item">
                                <td class="ps-4">
                                    <p class="text-sm font-weight-bold mb-0">{{ $category->category_name }}</p>
                                </td>
                                <td>
                                    <p class="text-sm text-dark mb-0">{{ $category->description ?? 'No description' }}
                                    </p>
                                </td>
                                <td>
                                    @if($category->getImage())
                                    <img src="{{ $category->getImage() }}" alt="Category Image"
                                        class="rounded-circle avatar-sm cursor-pointer" data-bs-toggle="modal"
                                        data-bs-target="#imageModal" data-image="{{ $category->getImage() }}" />
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('console.categories.edit', $category) }}"
                                        class="btn btn-sm btn-outline-dark me-2" title="Edit">
                                        <i class="material-symbols-rounded fs-5">edit</i>
                                    </a>
                                    <form action="{{ route('console.categories.delete', $category) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this category?');">
                                            <i class="material-symbols-rounded fs-5">delete</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No categories found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                <h5 class="modal-title" id="imageModalLabel">View Image</h5>
                <button type="button" class="btn btn-close m-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="material-symbols-rounded fs-4 text-dark">close</i>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="" alt="Large Image" class="img-fluid" id="modalImage" />
            </div>
        </div>
    </div>
</div>

@endsection
