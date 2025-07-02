@extends('instructor.layouts.app')
@section('title', 'Quiz - ' . $video->title)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark fw-bold">Quiz Questions</h5>
                    <a href="{{ route('dashboard.courses.videos.quiz.create', $video) }}"
                        class="btn btn-success btn-sm px-3">
                        <i class="material-symbols-rounded fs-6 me-1">add</i>Add New Question
                    </a>
                </div>

                <div class="card-body p-0">
                    @if ($questions->isEmpty())
                    <div class="text-center py-5">
                        <i class="material-symbols-rounded fs-2 text-muted">quiz</i>
                        <p class="text-muted mt-2">No questions added yet.</p>
                    </div>
                    @else
                    <ul class="list-group list-group-flush">
                        @foreach ($questions as $question)
                        <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                            <div>
                                <h6 class="fw-medium mb-1">{{ $question->question_text }}</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($question->questionOptions as $option)
                                    <span class="badge {{ $option->is_correct ? 'bg-success' : 'bg-light text-dark' }}">
                                        {{ $option->option_text }}
                                        @if ($option->is_correct)
                                        <i class="material-symbols-rounded fs-5 ms-1 text-white">check_circle</i>
                                        @endif
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="btn-group" role="group">
                                <a href="{{ route('dashboard.courses.videos.quiz.edit', [$video, $question]) }}"
                                    class="btn btn-outline-info btn-sm" title="Edit">
                                    <i class="material-symbols-rounded fs-6">edit</i>
                                </a>
                                <form
                                    action="{{ route('dashboard.courses.videos.quiz.destroy', [$video, $question]) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Are you sure?')" title="Delete">
                                        <i class="material-symbols-rounded fs-6">delete</i>
                                    </button>
                                </form>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
