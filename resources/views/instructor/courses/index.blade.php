@extends('instructor.layouts.app')
@section('title', 'My Courses - Instructor Panel')

@section('content')
<div class="container-fluid py-4" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px;">
                <div class="card-body text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">My Courses</h2>
                            <p class="mb-0 opacity-75">Manage and organize your courses efficiently</p>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-none d-md-block">
                                <i class="fas fa-graduation-cap fa-3x opacity-50"></i>
                            </div>
                            <a href="{{ route('dashboard.courses.create') }}" class="btn btn-light rounded-pill px-4 fw-semibold">
                                <i class="fas fa-plus me-2"></i>Add New Course
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success') || session('error'))
    <div class="row mb-4">
        <div class="col-12">
            @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 text-white auto-hide" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-3 text-white auto-hide" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Desktop Table View -->
    <div class="d-none d-lg-block">
        <div class="card border-0 shadow-lg" style="border-radius: 20px;">
            <div class="card-header bg-transparent border-0 pb-0 pt-4">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-gradient-primary rounded-circle p-2 me-3">
                        <i class="fas fa-list text-white"></i>
                    </div>
                    <h5 class="mb-0 fw-bold text-dark">Courses Overview</h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 fw-semibold ps-4">Course</th>
                                <th class="border-0 fw-semibold">Category</th>
                                <th class="border-0 fw-semibold">Price</th>
                                <th class="border-0 fw-semibold">Duration</th>
                                <th class="border-0 fw-semibold">Students</th>
                                <th class="border-0 fw-semibold">Status</th>
                                <th class="border-0 fw-semibold pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                            <tr class="searchable-item" style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                                <!-- Course Info -->
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if($course->getImage())
                                            <img src="{{ $course->getImage() }}" alt="Course Image"
                                                class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                            <div class="bg-gradient-primary d-flex align-items-center justify-content-center rounded-3"
                                                style="width: 60px; height: 60px;">
                                                <i class="fas fa-book text-white fs-4"></i>
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $course->title }}</h6>
                                            <small class="text-muted">Created {{ $course->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </td>

                                <!-- Category -->
                                <td>
                                    <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                        {{ $course->category->category_name ?? 'Uncategorized' }}
                                    </span>
                                </td>

                                <!-- Price -->
                                <td>
                                    <div class="fw-semibold">
                                        @if($course->pricing?->isDiscountActive())
                                        <del class="text-muted small">{{ number_format($course->pricing->price, 0) }}</del><br>
                                        <span class="text-success">{{ number_format($course->pricing->getFinalPrice(), 0) }} EGP</span>
                                        @else
                                        <span>{{ number_format($course->pricing?->price ?? 0, 0) }} EGP</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Duration -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock text-muted me-2"></i>
                                        {{ $course->details?->total_duration ?? 0 }} min
                                    </div>
                                </td>

                                <!-- Students Progress -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            @php
                                            $maxStudents = $course->enrollment?->max_students ?? 1;
                                            $currentStudents = $course->enrollment?->current_students ?? 0;
                                            $percentage = $maxStudents > 0 ? ($currentStudents / $maxStudents) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <small class="fw-semibold">{{ $currentStudents }}/{{ $maxStudents }}</small>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td>
                                    @php
                                    $statusColor = $course->details?->status == 'available' ? 'success' : ($course->details?->status == 'upcoming' ? 'info' : 'secondary');
                                    $statusText = $course->details?->status == 'available' ? 'Available' : ($course->details?->status == 'upcoming' ? 'Upcoming' : 'Suspended');
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }} rounded-pill px-3 py-2">
                                        {{ $statusText }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="pe-4">
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('dashboard.courses.videos.index', $course) }}"
                                            class="btn btn-sm rounded-pill"
                                            style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;"
                                            title="Videos">
                                            <i class="fas fa-video"></i>
                                        </a>
                                        <a href="{{ route('dashboard.courses.assignments.index', $course) }}"
                                            class="btn btn-sm rounded-pill"
                                            style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;"
                                            title="Student Management">
                                            <i class="fas fa-users"></i>
                                        </a>
                                        <a href="{{ route('dashboard.courses.edit', $course) }}"
                                            class="btn btn-sm rounded-pill"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('dashboard.courses.destroy', $course) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this course?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm rounded-pill"
                                                style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-5">
                                        <i class="fas fa-graduation-cap fa-4x text-muted mb-4"></i>
                                        <h5 class="text-muted mb-3">No courses found</h5>
                                        <p class="text-muted mb-4">Start your teaching journey by creating your first course</p>
                                        <a href="{{ route('dashboard.courses.create') }}" class="btn btn-primary rounded-pill px-4">
                                            <i class="fas fa-plus me-2"></i>Create Your First Course
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile & Tablet Card View -->
    <div class="d-block d-lg-none">
        <div class="row g-4">
            @forelse ($courses as $course)
            <div class="col-md-6 col-12">
                <div class="card border-0 shadow-lg h-100 searchable-item" style="border-radius: 20px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <!-- Course Image -->
                    <div class="position-relative overflow-hidden" style="border-radius: 20px 20px 0 0;">
                        @if($course->getImage())
                        <img src="{{ $course->getImage() }}" alt="Course Image"
                            class="img-fluid w-100" style="height: 200px; object-fit: cover;">
                        @else
                        <div class="d-flex align-items-center justify-content-center"
                            style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-book text-white fa-3x"></i>
                        </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="position-absolute top-0 end-0 m-3">
                            @php
                            $statusColor = $course->details?->status == 'available' ? 'success' : ($course->details?->status == 'upcoming' ? 'info' : 'secondary');
                            $statusText = $course->details?->status == 'available' ? 'Available' : ($course->details?->status == 'upcoming' ? 'Upcoming' : 'Suspended');
                            @endphp
                            <span class="badge bg-{{ $statusColor }} rounded-pill px-3 py-2 shadow">
                                {{ $statusText }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Title -->
                        <h5 class="fw-bold mb-3">{{ $course->title }}</h5>

                        <!-- Course Details -->
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="d-flex align-items-center p-2 rounded-3" style="background: linear-gradient(135deg, #667eea15 0%, #764ba225 100%);">
                                    <i class="fas fa-tag text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Category</small>
                                        <small class="fw-semibold">{{ $course->category->category_name ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center p-2 rounded-3" style="background: linear-gradient(135deg, #4facfe15 0%, #00f2fe25 100%);">
                                    <i class="fas fa-clock text-info me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Duration</small>
                                        <small class="fw-semibold">{{ $course->details?->total_duration ?? 0 }} min</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: linear-gradient(135deg, #fa709a15 0%, #fee14025 100%);">
                                <div>
                                    <small class="text-muted d-block">Price</small>
                                    @if($course->pricing?->isDiscountActive())
                                    <del class="text-muted small">{{ number_format($course->pricing->price, 0) }} EGP</del>
                                    <div class="fw-bold text-success">{{ number_format($course->pricing->getFinalPrice(), 0) }} EGP</div>
                                    @else
                                    <div class="fw-bold">{{ number_format($course->pricing?->price ?? 0, 0) }} EGP</div>
                                    @endif
                                </div>
                                <i class="fas fa-money-bill-wave fa-2x text-warning"></i>
                            </div>
                        </div>

                        <!-- Students Progress -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Students Enrolled</small>
                                <small class="fw-semibold">{{ $course->enrollment?->current_students ?? 0 }} / {{ $course->enrollment?->max_students ?? 0 }}</small>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 10px;">
                                @php
                                $maxStudents = $course->enrollment?->max_students ?? 1;
                                $currentStudents = $course->enrollment?->current_students ?? 0;
                                $percentage = $maxStudents > 0 ? ($currentStudents / $maxStudents) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-success" style="width: {{ $percentage }}%; border-radius: 10px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer border-0 p-4 pt-0">
                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('dashboard.courses.videos.index', $course) }}"
                                class="btn btn-sm rounded-pill flex-fill"
                                style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                                <i class="fas fa-video me-1"></i> Videos
                            </a>
                            <a href="{{ route('dashboard.courses.assignments.index', $course) }}"
                                class="btn btn-sm rounded-pill flex-fill"
                                style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                                <i class="fas fa-users me-1"></i> Students
                            </a>
                            <a href="{{ route('dashboard.courses.edit', $course) }}"
                                class="btn btn-sm rounded-pill flex-fill"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                        </div>
                        <div class="mt-2">
                            <form action="{{ route('dashboard.courses.destroy', $course) }}" method="POST" class="d-inline w-100"
                                onsubmit="return confirm('Are you sure you want to delete this course?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill w-100">
                                    <i class="fas fa-trash me-1"></i> Delete Course
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-graduation-cap fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted mb-3">No courses found</h4>
                        <p class="text-muted mb-4">Start your teaching journey by creating your first course</p>
                        <a href="{{ route('dashboard.courses.create') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-plus me-2"></i>Create Your First Course
                        </a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                <div class="pagination-wrapper">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .icon-shape {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        transition: all 0.3s ease;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .badge {
        font-weight: 500;
    }

    .progress {
        border-radius: 10px;
        background-color: #e9ecef;
    }

    .progress-bar {
        border-radius: 10px;
    }

    .btn {
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .alert {
        border: none !important;
    }

    .auto-hide {
        animation: fadeOut 5s forwards;
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }

        80% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }

    .pagination-wrapper .pagination {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .pagination-wrapper .page-link {
        border: none;
        color: #667eea;
        font-weight: 500;
        padding: 12px 16px;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .pagination-wrapper .page-link:hover {
        background-color: #f8f9fa;
        color: #667eea;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }

        .card-body {
            padding: 1.5rem !important;
        }

        .icon-shape {
            width: 35px;
            height: 35px;
        }

        .fa-2x {
            font-size: 1.5em !important;
        }

        .fa-3x {
            font-size: 2em !important;
        }

        .fa-4x {
            font-size: 2.5em !important;
        }
    }
</style>
@endsection
