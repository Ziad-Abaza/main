@extends('instructor.layouts.app')
@section('title', 'Instructor Dashboard')

@section('content')
<div class="container-fluid py-4" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px;">
                <div class="card-body text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">Welcome to Your Dashboard</h2>
                            <p class="mb-0 opacity-75">Manage your courses and students easily and efficiently</p>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-chalkboard-teacher fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="row mb-5">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-75 mb-2">Total Courses</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalCourses }}</h2>
                        </div>
                        <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-3">
                            <i class="fas fa-book fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-75 mb-2">Total Students</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalStudents }}</h2>
                        </div>
                        <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-3">
                            <i class="fas fa-user-graduate fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-75 mb-2">Available Seats</h6>
                            <h2 class="mb-0 fw-bold">{{ $availableSeats }}</h2>
                        </div>
                        <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-3">
                            <i class="fas fa-chair fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-75 mb-2">Total Earnings</h6>
                            <h2 class="mb-0 fw-bold">{{ number_format($totalEarnings, 0) }}</h2>
                            <small class="opacity-75">EGP</small>
                        </div>
                        <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-3">
                            <i class="fas fa-coins fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-gradient-primary rounded-circle p-2 me-3">
                            <i class="fas fa-bolt text-white"></i>
                        </div>
                        <h5 class="mb-0 fw-bold text-dark">Quick Actions</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('dashboard.courses.create') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 border-2" style="border-radius: 15px; min-height: 120px; transition: all 0.3s ease; border-color: #667eea;" onmouseover="this.style.backgroundColor='#667eea'; this.style.color='white'; this.style.transform='translateY(-3px)'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#667eea'; this.style.transform='translateY(0)'">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                <span class="fw-semibold">Create Course</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('dashboard.courses.index') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 border-2" style="border-radius: 15px; min-height: 120px; transition: all 0.3s ease; border-color: #4facfe;" onmouseover="this.style.backgroundColor='#4facfe'; this.style.color='white'; this.style.transform='translateY(-3px)'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#4facfe'; this.style.transform='translateY(0)'">
                                <i class="fas fa-book fa-2x mb-2"></i>
                                <span class="fw-semibold">Manage Courses</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('dashboard.enrollments.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 border-2" style="border-radius: 15px; min-height: 120px; transition: all 0.3s ease; border-color: #f093fb;" onmouseover="this.style.backgroundColor='#f093fb'; this.style.color='white'; this.style.transform='translateY(-3px)'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#f093fb'; this.style.transform='translateY(0)'">
                                <i class="fas fa-user-graduate fa-2x mb-2"></i>
                                <span class="fw-semibold">Manage Enrollments</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('dashboard.absences.scan') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 border-2" style="border-radius: 15px; min-height: 120px; transition: all 0.3s ease; border-color: #fa709a;" onmouseover="this.style.backgroundColor='#fa709a'; this.style.color='white'; this.style.transform='translateY(-3px)'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#fa709a'; this.style.transform='translateY(0)'">
                                <i class="fas fa-qrcode fa-2x mb-2"></i>
                                <span class="fw-semibold">Scan Attendance</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('dashboard.absences.generate') }}" class="btn btn-outline-danger w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 border-2" style="border-radius: 15px; min-height: 120px; transition: all 0.3s ease; border-color: #667eea;" onmouseover="this.style.backgroundColor='#667eea'; this.style.color='white'; this.style.transform='translateY(-3px)'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#667eea'; this.style.transform='translateY(0)'">
                                <i class="fas fa-id-card fa-2x mb-2"></i>
                                <span class="fw-semibold">Generate QR</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('dashboard.absences.index') }}" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 border-2" style="border-radius: 15px; min-height: 120px; transition: all 0.3s ease; border-color: #6c757d;" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='white'; this.style.transform='translateY(-3px)'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6c757d'; this.style.transform='translateY(0)'">
                                <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                                <span class="fw-semibold">View Absences</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <!-- Course Status Distribution -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 20px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-gradient-primary rounded-circle p-2 me-3">
                                <i class="fas fa-chart-pie text-white"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-dark">Course Status Distribution</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if(count($statusStats))
                    <div class="row g-3">
                        @php
                        $statusConfig = [
                        'available' => ['color' => '#4facfe', 'icon' => 'fas fa-play-circle', 'label' => 'Available'],
                        'upcoming' => ['color' => '#fa709a', 'icon' => 'fas fa-clock', 'label' => 'Upcoming'],
                        'suspended' => ['color' => '#6c757d', 'icon' => 'fas fa-pause-circle', 'label' => 'Suspended']
                        ];
                        @endphp
                        @foreach(['available', 'upcoming', 'suspended'] as $status)
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 rounded-3" style="background: linear-gradient(135deg, {{ $statusConfig[$status]['color'] }}15 0%, {{ $statusConfig[$status]['color'] }}25 100%); border: 1px solid {{ $statusConfig[$status]['color'] }}30;">
                                <div class="icon-shape rounded-circle p-2 me-3" style="background-color: {{ $statusConfig[$status]['color'] }};">
                                    <i class="{{ $statusConfig[$status]['icon'] }} text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $statusConfig[$status]['label'] }}</h6>
                                    <h4 class="mb-0 fw-bold" style="color: {{ $statusConfig[$status]['color'] }};">{{ $statusStats[$status] ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No courses yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Latest Subscribers -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 20px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-gradient-success rounded-circle p-2 me-3">
                            <i class="fas fa-user-plus text-white"></i>
                        </div>
                        <h5 class="mb-0 fw-bold text-dark">Latest Subscribers</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentSubscriptions->isNotEmpty())
                    <div class="list-group list-group-flush">
                        @foreach($recentSubscriptions as $sub)
                        <div class="list-group-item border-0 px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-container me-3" style="position: relative;">
                                    <img src="{{ $sub->user->getAvatar() }}" alt="User" class="rounded-circle border border-2 border-white shadow-sm" width="45" height="45" style="object-fit: cover;">
                                    <div class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white" style="width: 12px; height: 12px;"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-semibold">@if($sub->user){{ $sub->user->name }}@endif</h6>
                                    <small class="text-muted">{{ optional($sub->course)->title }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge rounded-pill" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 10px;">
                                        {{ $sub->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No recent activity yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Courses -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-header bg-transparent border-0 pb-0 pt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-gradient-info rounded-circle p-2 me-3">
                                <i class="fas fa-graduation-cap text-white"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-dark">Latest Courses</h5>
                        </div>
                        <a href="{{ route('dashboard.courses.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i>View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($latestCourses->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold">Course Title</th>
                                    <th class="border-0 fw-semibold">Status</th>
                                    <th class="border-0 fw-semibold">Duration</th>
                                    <th class="border-0 fw-semibold">Price</th>
                                    <th class="border-0 fw-semibold">Students</th>
                                    <th class="border-0 fw-semibold">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestCourses as $course)
                                <tr style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape bg-gradient-primary rounded-circle p-2 me-3">
                                                <i class="fas fa-book text-white"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $course->title }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                        $statusColor = $course->details?->status == 'available' ? 'success' : ($course->details?->status == 'upcoming' ? 'info' : 'secondary');
                                        $statusText = $course->details?->status == 'available' ? 'Available' : ($course->details?->status == 'upcoming' ? 'Upcoming' : 'Suspended');
                                        @endphp
                                        <span class="badge bg-{{ $statusColor }} rounded-pill px-3 py-2">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock text-muted me-2"></i>
                                            {{ $course->details?->total_duration ?? 0 }} min
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">
                                            @if($course->pricing?->isDiscountActive())
                                            <del class="text-muted small">{{ number_format($course->pricing?->price ?? 0, 0) }}</del><br>
                                            <span class="text-success">{{ number_format($course->pricing?->getFinalPrice() ?? 0, 0) }} EGP</span>
                                            @else
                                            <span>{{ number_format($course->pricing?->price ?? 0, 0) }} EGP</span>
                                            @endif
                                        </div>
                                    </td>
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
                                            <small class="fw-semibold">{{ $currentStudents }} / {{ $maxStudents }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar-alt text-muted me-2"></i>
                                            {{ $course->created_at->format('Y-m-d') }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-plus-circle fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-3">You haven't added any courses yet</p>
                        <a href="{{ route('dashboard.courses.create') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-plus me-2"></i>Create New Course
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="text-white mb-2 fw-bold">Ready to start your teaching journey?</h5>
                            <p class="text-white opacity-75 mb-0">Start by creating your first course or manage your current courses</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                <a href="{{ route('dashboard.courses.create') }}" class="btn btn-light rounded-pill px-4 fw-semibold">
                                    <i class="fas fa-plus me-2"></i>Create New Course
                                </a>
                                <a href="{{ route('dashboard.courses.index') }}" class="btn btn-outline-light rounded-pill px-4 fw-semibold">
                                    <i class="fas fa-cogs me-2"></i>Manage My Courses
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
           <div style="border-radius: 20px; overflow: hidden;" class="shadow-lg">
                @livewire('pending-enrollments')
            </div>
        </div>
    </div>
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

    .card:hover {
        transform: translateY(-2px);
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
    }
</style>
@endsection
