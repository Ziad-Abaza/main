@extends('dashboard.layouts.app')

@section('title', 'Child Level Subscriptions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Child Level Subscriptions</h4>
                    <div>
                        <a href="{{ route('console.child_levels.export') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Export
                        </a>
                        <a href="{{ route('console.child_levels.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Subscription
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" action="{{ route('console.child_levels.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search">Search</label>
                                    <input type="text" class="form-control" id="search" name="search"
                                           value="{{ request('search') }}" placeholder="Child code or level name">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">All Statuses</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="level_id">Level</label>
                                    <select class="form-control" id="level_id" name="level_id">
                                        <option value="">All Levels</option>
                                        @foreach($levels as $level)
                                            <option value="{{ $level->level_id }}" {{ request('level_id') == $level->level_id ? 'selected' : '' }}>
                                                {{ $level->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="{{ route('console.child_levels.index') }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Subscriptions Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Subscription ID</th>
                                    <th>Child</th>
                                    <th>Level</th>
                                    <th>Subscribe Date</th>
                                    <th>Expiry Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscriptions as $subscription)
                                    <tr>
                                        <td>{{ $subscription->subscription_id }}</td>
                                        <td>
                                            <div>
                                                <strong>{{ $subscription->child->user->name ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $subscription->child->code ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td>{{ $subscription->level->name ?? 'N/A' }}</td>
                                        <td>{{ $subscription->subscribe_date ? (is_string($subscription->subscribe_date) ? $subscription->subscribe_date : $subscription->subscribe_date->format('M d, Y')) : 'N/A' }}</td>
                                        <td>
                                            @if($subscription->expiry_date)
                                                @php
                                                    $expiryDate = is_string($subscription->expiry_date) ? \Carbon\Carbon::parse($subscription->expiry_date) : $subscription->expiry_date;
                                                @endphp
                                                <span class="{{ $expiryDate->isPast() ? 'text-danger' : 'text-success' }}">
                                                    {{ $expiryDate->format('M d, Y') }}
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $subscription->status == 'active' ? 'success' : ($subscription->status == 'inactive' ? 'warning' : ($subscription->status == 'expired' ? 'danger' : 'secondary')) }}">
                                                {{ ucfirst($subscription->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('console.child_levels.show', $subscription) }}"
                                                   class="btn btn-info btn-sm" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('console.child_levels.edit', $subscription) }}"
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('console.child_levels.delete', $subscription) }}"
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this subscription?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No child level subscriptions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $subscriptions->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
