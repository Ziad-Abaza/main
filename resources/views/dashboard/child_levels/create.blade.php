@extends('dashboard.layouts.app')

@section('title', 'Create Child Level Subscription')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Create Child Level Subscription</h4>
                    <a href="{{ route('console.child_levels.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('console.child_levels.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Child Selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="child_id">Child <span class="text-danger">*</span></label>
                                    <select class="form-control @error('child_id') is-invalid @enderror" id="child_id" name="child_id" required>
                                        <option value="">Select Child</option>
                                        @foreach($children as $child)
                                            <option value="{{ $child->id }}" {{ old('child_id') == $child->id ? 'selected' : '' }}>
                                                {{ $child->user->name ?? 'N/A' }} ({{ $child->code ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('child_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Level Selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level_id">Level <span class="text-danger">*</span></label>
                                    <select class="form-control @error('level_id') is-invalid @enderror" id="level_id" name="level_id" required>
                                        <option value="">Select Level</option>
                                        @foreach($levels as $level)
                                            <option value="{{ $level->level_id }}" {{ old('level_id') == $level->level_id ? 'selected' : '' }}>
                                                {{ $level->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('level_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Subscribe Date -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subscribe_date">Subscribe Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('subscribe_date') is-invalid @enderror"
                                           id="subscribe_date" name="subscribe_date"
                                           value="{{ old('subscribe_date') }}" required>
                                    @error('subscribe_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Expiry Date -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('expiry_date') is-invalid @enderror"
                                           id="expiry_date" name="expiry_date"
                                           value="{{ old('expiry_date') }}" required>
                                    @error('expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Subscription
                                </button>
                                <a href="{{ route('console.child_levels.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Set default dates
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const subscribeDate = now.toISOString().slice(0, 16);
        const expiryDate = new Date(now.getTime() + (365 * 24 * 60 * 60 * 1000)).toISOString().slice(0, 16);

        if (!document.getElementById('subscribe_date').value) {
            document.getElementById('subscribe_date').value = subscribeDate;
        }
        if (!document.getElementById('expiry_date').value) {
            document.getElementById('expiry_date').value = expiryDate;
        }
    });
</script>
@endpush
@endsection
