@extends('dashboard.layouts.app')
@section('title', 'Change Password - Dashboard')

@section('content')

<style>
    .glass-card {
        backdrop-filter: blur(12px);
        background-color: rgba(255, 255, 255, 0.92);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        transition: all 0.3s ease-in-out;
    }

    .btn-gradient {
        background: linear-gradient(to right, #6f42c1, #4e73df);
        color: white;
        font-weight: 500;
        padding: 0.5rem 1.5rem;
        transition: all 0.3s ease-in-out;
    }

    .btn-gradient:hover {
        background: linear-gradient(to right, #5a32a8, #3c5bcf);
        transform: translateY(-2px);
    }

    .input-outline:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 69%;
        transform: translateY(-50%);
        color: #999;
    }
</style>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card glass-card shadow-lg border-0 rounded-5 overflow-hidden">

                <!-- Header -->
                <div class="card-header text-center py-5"
                    style="background: linear-gradient(to right, #6f42c1, #4e73df);">
                    <h3 class="mb-1 fw-bold">🔐 Change Password</h3>
                    <p class="mb-0 text-white opacity-75">Make sure to use a strong and secure password.</p>
                </div>

                <!-- Form -->
                <div class="card-body p-5">
                    <form action="{{ route('console.profile.change-password.post') }}" method="POST">
                        @csrf

                        <!-- Current Password -->
                        <x-inputs.password name="current_password" label="Current Password"
                            placeholder="Enter current password" required />

                        <!-- New Password -->
                        <x-inputs.password name="password" label="New Password" placeholder="Enter new password"
                            required />

                        <!-- Confirm Password -->
                        <x-inputs.password name="password_confirmation" label="Confirm New Password"
                            placeholder="Re-enter new password" required />

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('console.profile.index') }}"
                                class="btn btn-outline-secondary px-4 rounded-pill d-flex align-items-center">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-gradient px-4 rounded-pill d-flex align-items-center">
                                <i class="material-symbols-rounded me-2">lock_open</i> Change Password
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
    document.getElementById('enable_coupon').addEventListener('change', function () {
        const couponFields = document.getElementById('couponFields');
        couponFields.style.display = this.checked ? 'block' : 'none';
    });
</script>
@endpush
