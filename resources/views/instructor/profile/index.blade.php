@extends('instructor.layouts.app')
@section('title', 'User Profile - Dashboard')

@section('content')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">

            <!-- Cover & Avatar -->
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4 position-relative">
                <!-- Cover Image -->
                <div class="position-relative">
                    <img src="{{ asset('assets/image/brand/brand(9).png') }}" alt="Cover" class="img-fluid w-100"
                        style="height: 200px; object-fit: cover;">
                    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4">
                        <div class="rounded-circle border border-4 border-white bg-white p-1 shadow-sm">
                            <img src="{{ asset($user->getAvatar()) }}" alt="Profile Image" class="rounded-circle"
                                width="120" height="120" style="object-fit: cover;">
                        </div>
                    </div>
                </div>

                <!-- User Info -->
                <div class="card-body text-center pt-5 px-4 pb-4">
                    <h3 class="mb-1">{{ $user->name }}</h3>
                    <p class="text-muted mb-2">{{ $user->email }}</p>

                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                        @foreach ($user->roles as $role)
                        <span class="badge bg-gradient-primary rounded-pill px-3 py-2">
                            {{ ucwords($role->name) }}
                        </span>
                        @endforeach
                    </div>

                    <p class="text-muted small mb-4">Member since {{ $user->created_at->format('M Y') }}</p>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{route('dashboard.profile.edit', $user->user_id)}}" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                            <i class="material-symbols-rounded me-1">edit</i>Edit Profile
                        </a>
                        <a href="{{route('dashboard.profile.change-password')}}" class="btn btn-dark px-4 py-2 rounded-pill">
                            <i class="material-symbols-rounded me-1">lock</i>Change Password
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row g-4">
                <!-- Left Column - Details -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Personal Information</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <h6 class="text-muted fw-semibold">Full Name</h6>
                                    <p class="fs-5 mb-0">{{ $user->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted fw-semibold">Email Address</h6>
                                    <p class="fs-5 mb-0">{{ $user->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted fw-semibold">Role(s)</h6>
                                    <p class="fs-5 mb-0">
                                        {{ $user->roles->pluck('name')->join(', ') ?: 'No roles assigned' }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted fw-semibold">Member Since</h6>
                                    <p class="fs-5 mb-0">{{ $user->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="col-12 mt-3">
                                    <h6 class="text-muted fw-semibold">Bio</h6>
                                    <p class="fs-5 mb-0">
                                        {{ $user->bio ?? 'No bio provided.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Activity / Quick Actions -->
                <div class="col-lg-4">
                    <!-- Recent Activity -->
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Recent Activity</h5>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-start mb-3">
                                    <div class="me-3 text-success">
                                        <i class="material-symbols-rounded fs-4">check_circle</i>
                                    </div>
                                    <div>
                                        <p class="mb-0 small">Logged in to the system</p>
                                        <small class="text-muted">Today at 9:30 AM</small>
                                    </div>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <div class="me-3 text-primary">
                                        <i class="material-symbols-rounded fs-4">create</i>
                                    </div>
                                    <div>
                                        <p class="mb-0 small">Updated profile information</p>
                                        <small class="text-muted">Yesterday at 3:15 PM</small>
                                    </div>
                                </li>
                                <li class="d-flex align-items-start">
                                    <div class="me-3 text-warning">
                                        <i class="material-symbols-rounded fs-4">file_download</i>
                                    </div>
                                    <div>
                                        <p class="mb-0 small">Downloaded course materials</p>
                                        <small class="text-muted">2 days ago</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
