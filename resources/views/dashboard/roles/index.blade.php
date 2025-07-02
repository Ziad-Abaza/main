@extends('dashboard.layouts.app')

@section('title', 'Roles - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-radius-lg">

                <!-- Card Header -->
                <div class="card-header bg-white d-flex justify-content-between align-items-center pb-3">
                    <h5 class="mb-0">Roles Management</h5>
                    <a href="{{ route('console.roles.create') }}" class="btn btn-dark btn-sm px-4">
                        Create New Role
                    </a>
                </div>

                <!-- Mobile View (Cards) -->
                <div class="d-block d-md-none px-4 pt-2">
                    @forelse ($roles as $role)
                    <div class="card mb-3 border rounded shadow-sm">
                        <div class="card-body">
                            <h6 class="mb-1">{{ ucfirst($role->name) }}</h6>
                            <p class="text-sm text-muted mb-1">{{ $role->description }}</p>
                            <p class="text-xs text-secondary mb-2">Users: {{ $role->users_count }}</p>
                            <div class="d-flex justify-content-end">
                                @if (!in_array($role->name, ['admin', 'student', 'instructor']))
                                <a href="{{ route('console.roles.edit', $role) }}"
                                    class="btn btn-sm btn-outline-dark me-2" title="Edit">
                                    <i class="material-icons-round">edit</i>
                                </a>
                                <form action="{{ route('console.roles.delete', $role) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this role?');">
                                        <i class="material-icons-round">delete</i>
                                    </button>
                                </form>
                                @else
                                <span class="badge bg-gradient-secondary text-xs">Protected</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">No roles found.</div>
                    @endforelse
                </div>

                <!-- Desktop View (Table) -->
                <div class="d-none d-md-block table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Role Name</th>
                                <th>Description</th>
                                <th>Users Count</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-sm font-weight-bold mb-0">{{ ucfirst($role->name) }}</p>
                                </td>
                                <td>
                                    <p class="text-sm text-dark mb-0">{{ $role->description }}</p>
                                </td>
                                <td>
                                    <span class="badge bg-gradient-info">{{ $role->users_count }}</span>
                                </td>
                                <td class="pe-4 text-end">
                                    @if (!in_array($role->name, ['admin', 'student', 'instructor']))
                                    <a href="{{ route('console.roles.edit', $role) }}"
                                        class="btn btn-sm btn-outline-dark me-2" title="Edit">
                                        <i class="material-icons-round">edit</i>
                                    </a>
                                    <form action="{{ route('console.roles.delete', $role) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this role?');">
                                            <i class="material-icons-round">delete</i>
                                        </button>
                                    </form>
                                    @else
                                    <span class="badge bg-gradient-secondary text-xs">Protected</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No roles found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
