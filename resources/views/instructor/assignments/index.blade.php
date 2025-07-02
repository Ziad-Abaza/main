@extends("instructor.layouts.app")
@section("title", "Student Management")

@section("content")
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Student Management: {{ $course->title }}</h4>
                <div class="d-flex align-items-center gap-3">
                    <select class="form-select w-auto" onchange="window.location.href=this.value">
                        <option value="{{ route('dashboard.courses.assignments.index', $course) }}" selected>Assignments</option>
                        <option value="{{ route('dashboard.courses.quiz.index', $course) }}">Quizzes</option>
                    </select>
                    <p class="text-muted mb-0">Total assignments: {{ $assignments->count() }}</p>
                </div>
            </div>
            <a href="{{ route("dashboard.courses.assignments.create", $course) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Assignment
            </a>
        </div>
        
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table-hover mb-0 table">
                        <thead class="bg-light">
                            <tr>
                                <th>Title</th>
                                <th>Due Date</th>
                                <th>Submissions</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignments as $assignment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-0">{{ $assignment->title }}</h6>
                                                <small
                                                    class="text-muted">{{ Str::limit($assignment->description, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $assignment->due_date->isPast() ? "bg-danger" : "bg-success" }}">
                                            {{ $assignment->due_date->format("M d, Y") }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route("dashboard.courses.assignments.submissions.index", [$course, $assignment]) }}"
                                            class="text-decoration-none">
                                            {{ $assignment->submissions->count() }}
                                        </a>
                                    </td>
                                    <td>{{ $assignment->created_at->format("M d, Y") }}</td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route("dashboard.courses.assignments.edit", [$course, $assignment]) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form
                                                action="{{ route("dashboard.courses.assignments.destroy", [$course, $assignment]) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this assignment?');">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>No assignments found. Create your first assignment!</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-select {
            border-radius: 0.5rem;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            font-size: 0.875rem;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>
@endsection
