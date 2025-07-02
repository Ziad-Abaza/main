@extends('instructor.layouts.app')
@section('title', 'Quiz Questions - ' . $quiz->title)

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-1">Questions for Quiz: {{ $quiz->title }}</h4>
        <a href="{{ route('dashboard.courses.quiz.questions.create', [$course, $quiz]) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Question
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Question</th>
                            <th>Type</th>
                            <th>Points</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $q)
                        <tr>
                            <td>{{ $q->question_text }}</td>
                            <td>{{ strtoupper($q->type) }}</td>
                            <td>{{ $q->points }}</td>
                            <td>
                                <a href="{{ route('dashboard.courses.quiz.questions.edit', [$course, $quiz, $q]) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                <form action="{{ route('dashboard.courses.quiz.questions.destroy', [$course, $quiz, $q]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4">No questions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
