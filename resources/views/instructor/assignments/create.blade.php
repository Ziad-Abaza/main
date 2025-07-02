@extends('instructor.layouts.app')
@section('title', 'Create Assignment')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Create New Assignment</h5>
                    <p class="text-muted small mb-0">For course: {{ $course->title }}</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.courses.assignments.store', $course) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Assignment Title -->
                        <div class="mb-3">
                            <x-inputs.text name="title" label="Assignment Title" :value="old('title')" required />
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <x-inputs.textarea name="description" label="Description" :value="old('description')"
                                rows="4" required />
                        </div>

                        <!-- Due Date -->
                        <div class="mb-3">
                            <x-inputs.date name="due_date" label="Due Date" :value="old('due_date')"
                                required />
                        </div>

                        <!-- Attachment -->
                        <div class="mb-3">
                            <x-inputs.file name="attachment" label="Attachment (Optional)" note="Max file size: 10MB" />
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard.courses.assignments.index', $course) }}"
                                class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Assignments
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tips</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-info-circle text-info"></i>
                            Provide clear instructions in the description
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-clock text-warning"></i>
                            Set reasonable deadlines
                        </li>
                        <li>
                            <i class="fas fa-file text-success"></i>
                            Attach relevant materials if needed
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
