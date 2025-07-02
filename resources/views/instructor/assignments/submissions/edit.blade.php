@extends('instructor.layouts.app')
@section('title','Grade Submission')
@section('content')
<div class="container-fluid py-4">
    <a href="{{ route('dashboard.courses.assignments.submissions.index', [$course,$assignment]) }}" class="btn btn-link p-0 mb-3"><i class="fas fa-arrow-left me-1"></i> Back to Submissions</a>

    <!-- Submission Info -->
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center">
            <img src="{{ optional($submission->user)->getAvatar() ?? asset('assets/image/default-avatar.png') }}" alt="avatar" class="rounded-circle me-3" width="48" height="48">
            <div>
                <h5 class="card-title mb-1">Grade submission of {{ optional($submission->user)->name ?? 'Deleted User' }}</h5>
                <p class="card-text small text-muted mb-0">Submitted on {{ $submission->created_at->format('M d, Y H:i') }}</p>
                <a href="{{ Storage::disk('assignments')->url($submission->file_path) }}" target="_blank" class="small d-block mb-1">Download submitted file</a>
                @if($submission->comment)
                    <p class="mb-0"><span class="fw-semibold">Student comment:</span> <em>{{ $submission->comment }}</em></p>
                @endif
            </div>
        </div>
    </div>

    <!-- Grade Form -->
    <div class="card">
        <form action="{{ route('dashboard.courses.assignments.submissions.update',[$course,$assignment,$submission]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Grade (0-100)</label>
                    <input type="number" name="grade" value="{{ old('grade',$submission->grade) }}" min="0" max="100" class="form-control" placeholder="Enter grade">
                </div>
                <div class="mb-3">
                    <label class="form-label">Feedback</label>
                    <textarea name="feedback" rows="4" class="form-control" placeholder="Write feedback (optional)">{{ old('feedback',$submission->feedback) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload File (optional)</label>
                    <input type="file" name="file" class="form-control" />
                    @if($submission->feedback_file_path)
                        <div class="form-text"><a href="{{ Storage::disk('assignments')->url($submission->feedback_file_path) }}" target="_blank">Current feedback file</a></div>
                    @endif
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary"><i class="fas fa-save me-1"></i> Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
