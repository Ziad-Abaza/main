@extends('dashboard.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
            <h3 class="mb-2 text-dark">Welcome back, {{ $user->name }}!</h3>
            <p class="text-muted">This is your admin console. You can manage users, courses, content and monitor
                system activity.</p>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Admin Info - New Design -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow-lg rounded-4 p-4"
                style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); color: #f0f4ff;">
                <h4 class="mb-3 text-white" style="font-weight: 700; letter-spacing: 1.2px;">Account Information</h4>
                <hr style="border-color: rgba(255,255,255,0.3);">
                <ul class="list-unstyled mt-3">

                    <!-- Name -->
                    <li class="d-flex align-items-center justify-content-between gap-3 py-2 px-2 border-bottom mb-2"
                        style="background-color: rgba(255, 255, 255, 0.05); border-radius: 8px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-user text-info"></i>
                            <span class="fw-semibold" style="font-size: 0.95rem;">Name:</span>
                        </div>
                        <span class="text-light" style="font-size: 0.95rem;">{{ $user->name }}</span>
                    </li>

                    <!-- Email -->
                    <li class="d-flex align-items-center justify-content-between gap-3 py-2 px-2 border-bottom mb-2"
                        style="background-color: rgba(255, 255, 255, 0.05); border-radius: 8px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-envelope text-success"></i>
                            <span class="fw-semibold" style="font-size: 0.95rem;">Email:</span>
                        </div>
                        <span class="text-light" style="font-size: 0.95rem;">{{ $user->email }}</span>
                    </li>

                    <!-- Role -->
                    <li class="d-flex align-items-center justify-content-between gap-3 py-2 px-2 border-bottom mb-2"
                        style="background-color: rgba(255, 255, 255, 0.05); border-radius: 8px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-user-tag text-warning"></i>
                            <span class="fw-semibold" style="font-size: 0.95rem;">Role:</span>
                        </div>
                        @if($user->roles->isNotEmpty())
                        <span class="badge"
                            style="background: #f9a825; color: #222; font-weight: 700; padding: 0.3em 0.9em; border-radius: 12px;">
                            {{ $user->roles->first()->name }}
                        </span>
                        @else
                        <span class="badge"
                            style="background: #90a4ae; color: #fff; font-weight: 700; padding: 0.3em 0.9em; border-radius: 12px;">
                            No Role Assigned
                        </span>
                        @endif
                    </li>

                    <!-- Last Login -->
                    <li class="d-flex align-items-center justify-content-between gap-3 py-2 px-2"
                        style="background-color: rgba(255, 255, 255, 0.05); border-radius: 8px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-clock text-light"></i>
                            <span class="fw-semibold" style="font-size: 0.95rem;">Last Login:</span>
                        </div>
                        <span class="text-light" style="font-size: 0.95rem;">{{ now()->format('Y-m-d H:i') }}</span>
                    </li>

                </ul>
            </div>
        </div>

        <!-- System Overview -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow-lg border-radius-lg p-4">
                <h5 class="mb-3">System Overview</h5>
                <div class="progress-wrapper mb-3">
                    <div class="progress-info">
                        <div>Total Users</div>
                        <div class="progress-percentage"><span>{{ $systemOverview['total_users'] }}</span></div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-gradient-success" role="progressbar"
                            style="width: {{ min(100, $systemOverview['total_users'] / 100 * 75) }}%"
                            aria-valuenow="{{ $systemOverview['total_users'] }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
                <div class="progress-wrapper mb-3">
                    <div class="progress-info">
                        <div>Active Courses</div>
                        <div class="progress-percentage"><span>{{ $systemOverview['active_courses'] }}</span></div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-gradient-info" role="progressbar"
                            style="width: {{ min(100, $systemOverview['active_courses'] / 100 * 89) }}%"
                            aria-valuenow="{{ $systemOverview['active_courses'] }}" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="progress-wrapper">
                    <div class="progress-info">
                        <div>Pending Tasks</div>
                        <div class="progress-percentage"><span>{{ $systemOverview['pending_tasks'] }}</span></div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-gradient-danger" role="progressbar"
                            style="width: {{ min(100, $systemOverview['pending_tasks'] * 5) }}%"
                            aria-valuenow="{{ $systemOverview['pending_tasks'] }}" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Recent Activity -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow-lg border-radius-lg p-4">
                <h5 class="mb-3">Recent Activity</h5>
                <ul class="list-group list-group-flush">
                    @foreach ($recentActivity as $activity)
                    <li class="list-group-item d-flex justify-content-between align-items-center searchable-item">
                        <div class="d-flex align-items-center">
                            <i class="material-symbols-rounded text-success me-2">{{ $activity['icon'] }}</i>
                            <span>{{ $activity['action'] }}</span>
                        </div>
                        <small class="text-muted">{{ $activity['time'] }}</small>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow-lg border-radius-lg p-4">
                <h5 class="mb-3">Quick Statistics</h5>
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-light rounded">
                            <h6 class="text-sm text-muted mb-1">Total Users</h6>
                            <h4 class="mb-0">{{ $systemOverview['total_users'] }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-light rounded">
                            <h6 class="text-sm text-muted mb-1">Active Courses</h6>
                            <h4 class="mb-0">{{ $systemOverview['active_courses'] }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-light rounded">
                            <h6 class="text-sm text-muted mb-1">Pending Reviews</h6>
                            <h4 class="mb-0">{{ $systemOverview['pending_tasks'] }}</h4>
                        </div>
                    </div>
                </div>

                <h5 class="mt-4 mb-3">Tasks</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Review new course submissions
                        <span class="badge bg-gradient-warning">3 pending</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Approve instructor applications
                        <span class="badge bg-gradient-danger">1 new</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Check reported issues
                        <span class="badge bg-gradient-success">0 open</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Latest Users -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow-lg border-radius-lg p-4">
                <h5 class="mb-3">Latest Registered Users</h5>
                <ul class="list-group list-group-flush">
                    @foreach ($latestUsers as $user)
                    <li class="list-group-item d-flex justify-content-between align-items-center searchable-item">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/img/avatar.png') }}" alt="User Image" class="rounded-circle me-3"
                                width="40" height="40">
                            <div>
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <small>{{ $user->email }}</small>
                            </div>
                        </div>
                        <span class="badge bg-gradient-secondary">
                            {{ $user->roles->first()?->role_name ?? 'Student' }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Recent Courses -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow-lg border-radius-lg p-4">
                <h5 class="mb-3">Recent Courses</h5>
                <ul class="list-group list-group-flush">
                    @foreach ($recentCourses as $course)
                    <li class="list-group-item d-flex justify-content-between align-items-center searchable-item">
                        <span>{{ Str::limit($course->title, 25) }}</span>
                        <span class="badge bg-gradient-success">Published</span>
                    </li>
                    @endforeach
                </ul>

                <h5 class="mt-4 mb-3">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('console.courses.create') }}" class="btn btn-outline-dark mb-2">
                        <i class="material-symbols-rounded me-2">school</i>Create New Course
                    </a>
                    <a href="" class="btn btn-outline-dark mb-2">
                        <i class="material-symbols-rounded me-2">people</i>Manage Users
                    </a>
                    <a href="{{ route('console.absences.index') }}" class="btn btn-outline-dark mb-2">
                        <i class="material-symbols-rounded me-2">fact_check</i>View Absences
                    </a>
                    <a href="{{ route('console.absences.scan') }}" class="btn btn-outline-dark mb-2">
                        <i class="material-symbols-rounded me-2">qr_code_scanner</i>Scan Attendance
                    </a>
                    <a href="{{ route('console.absences.generate') }}" class="btn btn-outline-dark">
                        <i class="material-symbols-rounded me-2">badge</i>Generate QR Codes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Admin Dashboard Loaded");
    });
</script>
@endpush
