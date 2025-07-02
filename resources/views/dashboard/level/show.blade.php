@extends('dashboard.layouts.app')
@section('title', 'View Level - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-radius-lg">
                <div class="card-header bg-white pb-0">
                    <h5 class="mb-0">Level Details</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <strong>Name:</strong>
                        <p>{{ $level->name }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p>{{ $level->description ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Created At:</strong>
                        <p>{{ $level->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    <div class="d-flex justify-content-start mt-4">
                        <a href="{{ route('console.levels.edit', $level) }}" class="btn btn-dark btn-sm px-4 me-2">
                            Edit
                        </a>
                        <a href="{{ route('console.levels.index') }}" class="btn btn-outline-secondary btn-sm px-4">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
