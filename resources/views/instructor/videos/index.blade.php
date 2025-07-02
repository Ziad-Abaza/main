@extends('instructor.layouts.app')
@section('title', 'Manage Videos - ' . $course->title)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg border-radius-lg overflow-hidden">
                <!-- Header -->
                <div class="card-header bg-light text-white d-flex align-items-center p-3">
                    <i class="material-symbols-rounded fs-5 me-2">ondemand_video</i>
                    <h5 class="mb-0">Videos for {{ $course->title }}</h5>
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <a href="{{ route('dashboard.courses.index') }}" class="btn btn-outline-secondary btn-sm">
                            Back to Courses
                        </a>
                        <a href="{{ route('dashboard.courses.videos.create', $course) }}"
                            class="btn btn-success btn-sm">
                            Add New Video
                        </a>
                    </div>

                    @if ($videos->isEmpty())
                    <div class="text-center py-4">
                        <i class="material-symbols-rounded fs-1 text-muted">ondemand_video</i>
                        <p class="text-muted mt-2">No videos found. Start by adding one.</p>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Duration</th>
                                    <th>Questions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($videos as $video)
                                <tr>
                                    <td>{{ $video->title }}</td>
                                    <td>{{ $video->duration ?? '-' }} min</td>
                                    <td>{{ $video->questions_count ?? 0 }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('dashboard.courses.videos.show', [$course, $video]) }}"
                                                class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="material-symbols-rounded fs-6">visibility</i>
                                            </a>
                                            <a href="{{ route('dashboard.courses.videos.edit', [$course, $video]) }}"
                                                class="btn btn-sm btn-outline-info" title="Edit">
                                                <i class="material-symbols-rounded fs-6">edit</i>
                                            </a>
                                            <form
                                                action="{{ route('dashboard.courses.videos.destroy', [$course, $video]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="material-symbols-rounded fs-6">delete</i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $videos->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
