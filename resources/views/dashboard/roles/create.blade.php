@extends('dashboard.layouts.app')

@section('title', 'Create Role - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-radius-lg">

                <!-- Card Header -->
                <div class="card-header bg-white pb-0">
                    <h5 class="mb-0">Create New Role</h5>
                    <p class="text-sm text-muted mb-0">Fill in the details to create a new role.</p>
                </div>

                <!-- Form -->
                <div class="card-body p-4">
                    <form action="{{ route('console.roles.store') }}" method="POST">
                        @csrf

                        <!-- Role Name -->
                        <x-inputs.text name="name" label="Role Name" :value="old('name')" placeholder="Enter role name"
                            required />

                        <!-- Description -->
                        <x-inputs.textarea name="description" label="Description" rows="5"
                            placeholder="Describe this role..." :value="old('description')" />

                        <!-- Permissions -->
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="row g-2">
                                @forelse ($allPermissions as $permission)
                                <div class="col-md-4 col-6">
                                    <x-inputs.checkbox name="permissions[]" :value="$permission->name"
                                        :id="'permission_'.$loop->index"
                                        :label="ucwords(str_replace('_', ' ', $permission->name))"
                                        :checked="is_array(old('permissions')) ? in_array($permission->name, old('permissions')) : false" />
                                </div>
                                @empty
                                <p class="text-muted">No permissions available.</p>
                                @endforelse
                            </div>
                            @error('permissions')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('console.roles.index') }}" class="btn btn-outline-secondary btn-sm px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark btn-sm px-4">
                                Create Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
