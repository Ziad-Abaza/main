@extends('instructor.layouts.app')
@section('title', 'Quizzes - ' . $course->title)

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Quizzes for: {{ $course->title }}</h4>
            <div class="d-flex align-items-center gap-3">
                <select class="form-select w-auto" onchange="window.location.href=this.value">
                    <option value="{{ route('dashboard.courses.assignments.index', $course) }}">Assignments</option>
                    <option value="{{ route('dashboard.courses.quiz.index', $course) }}" selected>Quizzes</option>
                </select>
                <p class="text-muted mb-0">Total quizzes: {{ $quizzes->total() }}</p>
            </div>
        </div>
        <a href="{{ route('dashboard.courses.quiz.create', $course) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Quiz
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table-hover mb-0 table">
                    <thead class="bg-light">
                        <tr>
                            <th>Title</th>
                            <th>Start Time</th>
                            <th>Duration (min)</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quizzes as $quiz)
                            <tr>
                                <td>{{ $quiz->title }}</td>
                                <td>{{ optional($quiz->start_at)->format('M d, Y H:i') }}</td>
                                <td>{{ $quiz->duration_minutes }}</td>
                                <td>
                                    @if($quiz->end_at && $quiz->end_at->isPast())
                                        <span class="badge bg-secondary">Closed</span>
                                    @elseif($quiz->start_at && now()->lt($quiz->start_at))
                                        <span class="badge bg-info">Scheduled</span>
                                    @else
                                        <span class="badge bg-success">Open</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('dashboard.courses.quiz.questions.index', [$course, $quiz]) }}"
                                            class="btn btn-sm btn-outline-secondary" title="View Questions">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dashboard.courses.quiz.edit', [$course, $quiz]) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('dashboard.courses.quiz.destroy', [$course, $quiz]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                            @csrf
                                            @method('DELETE')
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
                                        <p>No quizzes found. Create your first quiz!</p>
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
@endsection
