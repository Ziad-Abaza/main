@extends('instructor.layouts.app')
@section('title', 'Edit Profile - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-0 rounded-4">

                <!-- Card Header -->
                <div class="card-header bg-white pb-0">
                    <h5 class="mb-0">Edit Profile</h5>
                    <p class="text-sm text-muted mb-0">Update your personal information.</p>
                </div>

                <!-- Form -->
                <div class="card-body p-4">
                    <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <!-- Full Name -->
                        <div class="mb-3">
                        <x-inputs.text name="name" label="Full Name" :value="old('name', auth()->user()->name)"
                            required />
                        </div>


                        <!-- Email Address -->
                        <div class="mb-3">
                        <x-inputs.email name="email" label="Email Address" :value="old('email', auth()->user()->email)"
                            required />
                        </div>
                        
                        <!-- Avatar -->
                        <div class="mb-4 text-center">
                            <label for="avatar" class="d-block mb-2">Current Profile Picture</label>
                            <div class="mb-3">
                                <img src="{{ $user->getAvatar() }}" alt="Current Avatar" class="rounded-circle border"
                                    width="120" height="120">
                            </div>
                            <x-inputs.file name="avatar" label="Upload New Profile Picture" accept="image/*" />
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('dashboard.profile.index') }}" class="btn btn-outline-secondary px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark px-4">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
