@extends('instructor.layouts.app')
@section('title', 'Submissions')

@section('content')
<div class="container-fluid py-4">
    <a href="{{ route('dashboard.courses.assignments.index', $course) }}" class="text-sm text-blue-400 hover:underline mb-3 inline-block">
        ← Back to Assignments
    </a>

    <h3 class="mb-4">Submissions for: <span class="font-semibold">{{ $assignment->title }}</span></h3>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Student</th>
                            <th>Submitted At</th>
                            <th>Grade</th>
                            <th>File</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($submissions as $sub)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ optional($sub->user)->getAvatar() ?? asset('assets/image/default-avatar.png') }}" alt="avatar" class="rounded-circle me-2" width="32" height="32">
                                    <span>{{ optional($sub->user)->name ?? 'Deleted User' }}</span>
                                </div>
                            </td>
                            <td>{{ $sub->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                @if($sub->grade !== null)
                                    <span class="badge bg-success">{{ $sub->grade }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">Ungraded</span>
                                @endif
                            </td>
                            <td>
                                @if($sub->file_path)
                                    <a href="{{ Storage::disk('assignments')->url($sub->file_path) }}" target="_blank">Download</a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('dashboard.courses.assignments.submissions.edit', [$course, $assignment, $sub]) }}" class="btn btn-sm btn-outline-primary">Grade</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No submissions yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $submissions->links() }}
    </div>
</div>
@endsection
