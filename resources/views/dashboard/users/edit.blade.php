@extends('dashboard.layouts.app')

@section('title', 'Edit User - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-radius-lg">

                <!-- Header -->
                <div class="card-header bg-white pb-0">
                    <h5 class="mb-0">Edit User</h5>
                    <p class="text-sm text-muted mb-0">Update user details and roles.</p>
                </div>

                <!-- Body -->
                <div class="card-body p-4">

                    {{-- Success Message --}}
                    @if(session('success'))
                    <div class="alert alert-success text-white auto-hide" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    {{-- Error Message --}}
                    @if(session('error'))
                    <div class="alert alert-danger text-white auto-hide" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif

                    {{-- Form Start --}}
                    <form action="{{ route('console.users.update', $user) }}" method="POST">
                        @csrf
                        @method('POST')

                        <!-- Name -->
                        <x-inputs.text name="name" label="Full Name" :value="old('name', $user->name)" required />

                        <!-- Email -->
                        <x-inputs.email name="email" label="Email Address" :value="old('email', $user->email)"
                            required />

                        <!-- Roles -->
                        <div class="mb-3">
                            <label class="form-label">User Roles</label>
                            <div class="row g-2">
                                @foreach($roles as $role)
                                <div class="col-md-4 col-6">
                                    <x-inputs.checkbox name="roles[]" :value="$role->id" :id="'role_'.$role->id"
                                        :label="ucfirst($role->name)"
                                        :checked="in_array($role->id, old('roles', $user->roles->pluck('id')->toArray() ?? []))" />
                                </div>
                                @endforeach
                            </div>
                            @error('roles')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('console.users.index') }}" class="btn btn-outline-secondary btn-sm">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark btn-sm px-4">
                                Update User
                            </button>
                        </div>
                    </form>
                    {{-- Form End --}}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
