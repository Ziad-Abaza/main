@extends('dashboard.layouts.app')
@section('title', 'Courses in Level - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-radius-lg">
                <div class="card-header bg-white pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Courses in Level "{{ $level->name }}"</h5>
                    <a href="{{ route('console.level-courses.edit', $level) }}" class="btn btn-dark btn-sm px-4">
                        Edit Courses
                    </a>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group">
                        @forelse ($level->courses as $course)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $course->title }}
                            <form action="{{ route('console.level-courses.delete', [$level, $course]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?');">
                                    Remove
                                </button>
                            </form>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted">No courses assigned yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
