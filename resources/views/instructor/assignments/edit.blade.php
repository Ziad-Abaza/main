@extends('instructor.layouts.app')
@section('title', 'Edit Assignment')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Assignment</h5>
                    <p class="text-muted small mb-0">For course: {{ $course->title }}</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.courses.assignments.update', [$course, $assignment]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <!-- Assignment Title -->
                        <div class="mb-3">
                            <x-inputs.text name="title" label="Assignment Title"
                                :value="old('title', $assignment->title)" required />
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <x-inputs.textarea name="description" label="Description"
                                :value="old('description', $assignment->description)" rows="4" required />
                        </div>

                        <!-- Due Date -->
                        <div class="mb-3">
                            <x-inputs.date name="due_date" label="Due Date"
                                :value="old('due_date', $assignment->due_date->format('Y-m-d\TH:i'))" required />
                        </div>

                        <!-- Attachment -->
                        <div class="mb-3">
                            <x-inputs.file name="attachment" label="Attachment"
                                note="Upload new file to replace current one. Max file size: 10MB" />

                            @if($assignment->attachment_path)
                            <div class="mt-2">
                                <span class="text-muted">Current file:</span>
                                <a href="{{ Storage::url($assignment->attachment_path) }}" target="_blank">
                                    <i class="fas fa-file"></i> View Attachment
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard.courses.assignments.index', $course) }}"
                                class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Assignments
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Assignment Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-calendar text-info"></i>
                            Created: {{ $assignment->created_at->format('M d, Y') }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-users text-warning"></i>
                            Submissions: {{ $assignment->submissions->count() }}
                        </li>
                        @if($assignment->attachment_path)
                        <li>
                            <i class="fas fa-paperclip text-success"></i>
                            Has attachment
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
