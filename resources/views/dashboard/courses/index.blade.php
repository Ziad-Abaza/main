@extends('dashboard.layouts.app')

@section('title', 'Courses - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-radius-lg overflow-hidden">

                <!-- Card Header -->
                <div
                    class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-gradient text-dark mb-2 mb-md-0">Courses Management</h5>
                    <a href="{{ route('console.courses.create') }}" class="btn btn-primary btn-sm px-4">
                        <i class="material-symbols-rounded fs-6 me-1">add</i>Create New Course
                    </a>
                </div>

                <!-- Mobile View -->
                <div class="d-block d-md-none px-4 pb-4">
                    @forelse ($courses as $course)
                    <div class="card mb-4 border rounded shadow-sm hover-lift searchable-item">
                        <div class="card-body p-3">
                            <!-- Image -->
                            <div class="position-relative rounded overflow-hidden mb-3">
                                @if($course->getImage())
                                <img src="{{ $course->getImage() }}" alt="Course Image"
                                    class="img-fluid w-100 h-auto rounded cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#imageModal" data-image="{{ $course->getImage() }}"
                                    style="height: 180px; object-fit: cover;">
                                @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 180px;">
                                    <i class="material-symbols-rounded text-muted fs-2">image</i>
                                </div>
                                @endif
                            </div>

                            <!-- Info -->
                            <h6 class="mb-2 fw-bold">{{ $course->title }}</h6>

                            <p class="text-sm text-muted mb-2 d-flex align-items-center">
                                <i class="material-symbols-rounded fs-6 me-2">category</i>
                                {{ $course->category->category_name ?? 'Uncategorized' }}
                            </p>

                            <p class="text-sm text-muted mb-2 d-flex align-items-center">
                                <span class="show-full-description" data-bs-toggle="modal"
                                    data-bs-target="#descriptionModal"
                                    data-description="{{ $course->description ?? 'No description available' }}"
                                    title="{{ $course->description ?? '' }}">
                                    {{ Str::limit($course->description ?? 'No description available', 100) }}
                                </span>
                            </p>

                            <!-- Actions -->
                            <div class="d-flex justify-content-between pt-2 border-top">
                                <a href="{{ route('console.courses.edit', $course) }}"
                                    class="btn btn-sm btn-outline-primary me-2" title="Edit">
                                    <i class="material-symbols-rounded fs-6">edit</i>
                                </a>
                                <form action="{{ route('console.courses.delete', $course) }}" method="POST"
                                    class="d-inline confirm-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="material-symbols-rounded fs-6">delete</i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="material-symbols-rounded fs-1 text-muted mb-3">school</i>
                        <h5 class="text-muted">No courses found</h5>
                        <p class="text-sm text-muted">Get started by creating a new course</p>
                    </div>
                    @endforelse
                </div>

                <!-- Desktop View -->
                <div class="d-none d-md-block table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-gradient bg-light text-dark">
                            <tr>
                                <th class="ps-4 py-3">Course Title</th>
                                <th class="py-3">Category</th>
                                <th class="py-3">Description</th>
                                <th class="py-3">Image</th>
                                <th class="text-end pe-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                            <tr class="align-middle searchable-item">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="material-symbols-rounded text-primary fs-4">school</i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $course->title }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-gradient-info d-inline-flex align-items-center">
                                        <i class="material-symbols-rounded fs-6 me-1">category</i>
                                        {{ $course->category->category_name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td>
                                    <p class="text-sm text-muted mb-2 d-flex align-items-center">
                                        <span class="show-full-description" data-bs-toggle="modal"
                                            data-bs-target="#descriptionModal"
                                            data-description="{{ $course->description ?? 'No description available' }}"
                                            title="{{ $course->description ?? '' }}">
                                            {{ Str::limit($course->description ?? 'No description available', 30) }}
                                        </span>
                                    </p>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($course->getImage())
                                        <img src="{{ $course->getImage() }}" alt="Course Image"
                                            class="rounded cursor-pointer" data-bs-toggle="modal"
                                            data-bs-target="#imageModal" data-image="{{ $course->getImage() }}"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                        <i class="material-symbols-rounded text-muted fs-3">image</i>
                                        @endif
                                    </div>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('console.courses.edit', $course) }}"
                                            class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
                                            <i class="material-symbols-rounded fs-6">edit</i>
                                        </a>

                                        <form action="{{ route('console.courses.delete', $course) }}" method="POST"
                                            class="confirm-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-outline-danger"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this course?');">
                                                <i class="material-symbols-rounded fs-6">delete</i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="material-symbols-rounded fs-1 text-muted mb-2">school</i>
                                    <h6 class="text-muted mb-0">No courses found</h6>
                                </td>
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
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient bg-light text-white border-0">
                <h5 class="modal-title" id="imageModalLabel">Course Image</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <img src="" alt="Full Size Image" class="img-fluid rounded" id="modalImage" />
            </div>
        </div>
    </div>
</div>

<!-- Description Modal -->
<div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient bg-light text-white border-0">
                <h5 class="modal-title" id="descriptionModalLabel">Course Description</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p id="fullDescription" class="text-sm mb-0 white-space-pre-line"></p>
            </div>
            <div class="modal-footer border-0 pt-0 pb-3 px-4">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
