@extends('dashboard.layouts.app')

@section('title', 'Child Level Subscription Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Child Level Subscription Details</h4>
                    <div>
                        <a href="{{ route('console.child_levels.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('console.child_levels.edit', $childLevel) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Subscription Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Subscription Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Subscription ID:</strong></td>
                                            <td>{{ $childLevel->subscription_id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span class="badge badge-{{ $childLevel->status == 'active' ? 'success' : ($childLevel->status == 'inactive' ? 'warning' : ($childLevel->status == 'expired' ? 'danger' : 'secondary')) }}">
                                                    {{ ucfirst($childLevel->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Subscribe Date:</strong></td>
                                            <td>{{ $childLevel->subscribe_date ? (is_string($childLevel->subscribe_date) ? $childLevel->subscribe_date : $childLevel->subscribe_date->format('M d, Y H:i:s')) : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Expiry Date:</strong></td>
                                            <td>
                                                @if($childLevel->expiry_date)
                                                    @php
                                                        $expiryDate = is_string($childLevel->expiry_date) ? \Carbon\Carbon::parse($childLevel->expiry_date) : $childLevel->expiry_date;
                                                    @endphp
                                                    <span class="{{ $expiryDate->isPast() ? 'text-danger' : 'text-success' }}">
                                                        {{ $expiryDate->format('M d, Y H:i:s') }}
                                                    </span>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td>{{ $childLevel->created_at->format('M d, Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Updated:</strong></td>
                                            <td>{{ $childLevel->updated_at->format('M d, Y H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Child Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Child Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Child Name:</strong></td>
                                            <td>{{ $childLevel->child->user->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Child Code:</strong></td>
                                            <td>{{ $childLevel->child->code ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Parent Name:</strong></td>
                                            <td>{{ $childLevel->child->user->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $childLevel->child->user->email ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>{{ $childLevel->child->user->phone ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Level Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Level Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Level Name:</strong></td>
                                            <td>{{ $childLevel->level->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Level Description:</strong></td>
                                            <td>{{ $childLevel->level->description ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Level ID:</strong></td>
                                            <td>{{ $childLevel->level->level_id ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Update Form -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Update Status</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('console.child_levels.update-status', $childLevel) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status">New Status</label>
                                                    <select class="form-control" id="status" name="status" required>
                                                        <option value="active" {{ $childLevel->status == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ $childLevel->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                        <option value="expired" {{ $childLevel->status == 'expired' ? 'selected' : '' }}>Expired</option>
                                                        <option value="suspended" {{ $childLevel->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <div>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save"></i> Update Status
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
