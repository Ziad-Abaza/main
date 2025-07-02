@extends('dashboard.layouts.app')

@section('title', 'Users - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-radius-lg">

                <div class="card-body px-0 pt-0 pb-2">
                    <!-- Filter Bar -->
                    <div class="px-4 pt-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h5 class="mb-0">Users</h5>
                            <p class="text-sm text-muted mb-0">Manage all users</p>
                        </div>

                        <!-- Search and Filter Controls -->
                        <div class="d-flex align-items-center gap-3">
                            <!-- Search Input -->
                            <div class="d-flex align-items-center">
                                <label for="search" class="me-2 mb-0 text-nowrap">Search:</label>
                                <form method="GET" action="{{ route('console.users.index') }}" class="d-flex">
                                    <input type="text"
                                           id="search"
                                           name="search"
                                           class="form-control form-control-sm"
                                           placeholder="Name or email..."
                                           value="{{ request('search') }}"
                                           style="min-width: 200px;">
                                    <button type="submit" class="btn btn-sm btn-primary ms-2">
                                        <i class="material-symbols-rounded fs-5">search</i>
                                    </button>
                                    @if(request('search') || request('role'))
                                    <a href="{{ route('console.users.index') }}" class="btn btn-sm btn-outline-secondary ms-2" title="Clear filters">
                                        <i class="material-symbols-rounded fs-5">clear</i>
                                    </a>
                                    @endif
                                </form>
                            </div>

                            <!-- Filter Dropdown -->
                            <div class="d-flex align-items-center">
                                <label for="filterRole" class="me-2 mb-0 text-nowrap">Filter by Role:</label>
                                <select id="filterRole" class="form-select form-select-sm w-auto" onchange="updateFilter(this.value);">
                                    <option value="{{ route('console.users.index') }}?{{ request('search') ? 'search=' . request('search') . '&' : '' }}" {{ request('role') ? '' : 'selected' }}>All Users</option>
                                    @foreach ($roles as $role)
                                    <option value="?{{ request('search') ? 'search=' . request('search') . '&' : '' }}role={{ $role->name }}" {{ request('role')==$role->name ? 'selected' : '' }}>
                                        {{ ucwords($role->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Cards View -->
                    <div class="d-block d-md-none">
                        <div class="px-4 pt-4">
                            @forelse ($users as $user)
                            <div class="card mb-3 border rounded shadow-sm searchable-item">
                                <div class="card-body">
                                    <h6 class="mb-1">{{ $user->name }}</h6>
                                    <p class="text-sm text-muted mb-1">{{ $user->email }}</p>
                                    <span class="badge bg-gradient-info mb-2">
                                        {{ $user->roles->first()->name ?? 'No Role' }}
                                    </span>
                                    <p class="text-xs text-secondary mb-2">Joined: {{ $user->created_at->format('Y-m-d')
                                        }}</p>
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('console.users.edit', $user) }}"
                                            class="btn btn-sm btn-outline-dark me-2" title="Edit">
                                            <i class="material-symbols-rounded fs-3">edit</i>
                                        </a>
                                        <form action="{{ route('console.users.delete', $user) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this user?');">
                                                <i class="material-symbols-rounded fs-3">delete</i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-muted py-4">No users found.</div>
                            @endforelse
                        </div>

                        <!-- Pagination for mobile -->
                        <nav aria-label="Page navigation" class="d-flex justify-content-center mt-4">
                            <ul class="pagination pagination-lg">
                                {{-- Previous Button --}}
                                <li class="page-item @if(!$users->onFirstPage()) active @else disabled @endif">
                                    <a class="page-link bg-light border border-2 border-light rounded-circle d-flex align-items-center justify-content-center"
                                        href="{{ $users->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('role') ? '&role=' . request('role') : '' }}" aria-label="Previous" style="width: 40px; height: 40px;">
                                        <i class="material-symbols-rounded fs-6">chevron_left</i>
                                    </a>
                                </li>

                                {{-- Page Numbers --}}
                                @php
                                $currentPage = $users->currentPage();
                                $lastPage = $users->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                                @endphp

                                @for ($i = $start; $i <= $end; $i++) <li class="page-item @if($i == $currentPage) active @endif">
                                    <a class="page-link rounded-circle bg-light d-flex align-items-center justify-content-center"
                                        href="{{ $users->url($i) }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('role') ? '&role=' . request('role') : '' }}" style="width: 40px; height: 40px;">
                                        {{ $i }}
                                    </a>
                                    </li>
                                    @endfor

                                    {{-- Next Button --}}
                                    <li class="page-item @if($users->hasMorePages()) active @else disabled @endif">
                                        <a class="page-link bg-light border border-2 border-light rounded-circle d-flex align-items-center justify-content-center"
                                            href="{{ $users->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('role') ? '&role=' . request('role') : '' }}" aria-label="Next" style="width: 40px; height: 40px;">
                                            <i class="material-symbols-rounded fs-6">chevron_right</i>
                                        </a>
                                    </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Desktop Table View -->
                    <div class="d-none d-md-block table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Registered At</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                <tr class="searchable-item">
                                    <td class="ps-4">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->name }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm text-dark mb-0">{{ $user->email }}</p>
                                    </td>
                                    <td>
                                        @if($user->roles->isNotEmpty())
                                        <span class="badge bg-gradient-info">{{ $user->roles->first()->name }}</span>
                                        @else
                                        <span class="badge bg-gradient-secondary">No Role</span>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-sm text-dark mb-0">{{ $user->created_at->format('Y-m-d') }}</p>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('console.users.edit', $user) }}"
                                            class="btn btn-sm btn-outline-dark me-2" title="Edit">
                                            <i class="material-symbols-rounded fs-5">edit</i>
                                        </a>
                                        <form action="{{ route('console.users.delete', $user) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this user?');">
                                                <i class="material-symbols-rounded fs-5">delete</i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No users found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation" class="d-flex justify-content-center mt-4">
                            <ul class="pagination pagination-lg">
                                {{-- Previous Button --}}
                                <li class="page-item @if(!$users->onFirstPage()) active @else disabled @endif">
                                    <a class="page-link bg-light border border-2 border-light rounded-circle d-flex align-items-center justify-content-center"
                                        href="{{ $users->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('role') ? '&role=' . request('role') : '' }}" aria-label="Previous"
                                        style="width: 40px; height: 40px;">
                                        <i class="material-symbols-rounded fs-6">chevron_left</i>
                                    </a>
                                </li>

                                {{-- Page Numbers --}}
                                @php
                                $currentPage = $users->currentPage();
                                $lastPage = $users->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                                @endphp

                                @for ($i = $start; $i <= $end; $i++) <li
                                    class="page-item @if($i == $currentPage) active @endif">
                                    <a class="page-link rounded-circle bg-light d-flex align-items-center justify-content-center"
                                        href="{{ $users->url($i) }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('role') ? '&role=' . request('role') : '' }}" style="width: 40px; height: 40px;">
                                        {{ $i }}
                                    </a>
                                    </li>
                                    @endfor

                                    {{-- Next Button --}}
                                    <li class="page-item @if($users->hasMorePages()) active @else disabled @endif">
                                        <a class="page-link bg-light border border-2 border-light rounded-circle d-flex align-items-center justify-content-center"
                                            href="{{ $users->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('role') ? '&role=' . request('role') : '' }}" aria-label="Next"
                                            style="width: 40px; height: 40px;">
                                            <i class="material-symbols-rounded fs-6">chevron_right</i>
                                        </a>
                                    </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateFilter(value) {
    window.location.href = value;
}
</script>
@endsection
