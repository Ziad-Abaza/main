@extends('instructor.layouts.app')
@section('title', 'Video Details - ' . $course->title)
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">
            <div class="card shadow-lg border-radius-lg overflow-hidden">
                <!-- Header -->
                <div class="card-header bg-light d-flex align-items-center p-3">
                    <i class="material-symbols-rounded fs-5 me-2">ondemand_video</i>
                    <h5 class="mb-0">Video Details - {{ $course->title }}</h5>
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <!-- Navigation -->
                    <div class="d-flex justify-content-between mb-4">
                        <a href="{{ route('dashboard.courses.videos.index', $course) }}"
                           class="btn btn-outline-secondary btn-sm">
                            <i class="material-symbols-rounded fs-6 me-1">arrow_back</i>
                            Back to Videos
                        </a>

                        <div class="btn-group" role="group">
                            <a href="{{ route('dashboard.courses.videos.edit', [$course, $video]) }}"
                               class="btn btn-outline-info btn-sm">
                                <i class="material-symbols-rounded fs-6 me-1">edit</i>
                                Edit Video
                            </a>

                            <form action="{{ route('dashboard.courses.videos.destroy', [$course, $video]) }}"
                                  method="POST"
                                  class="d-inline ms-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this video?')">
                                    <i class="material-symbols-rounded fs-6 me-1">delete</i>
                                    Delete Video
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Video Player Section -->
                    <div class="card mb-4 border border-gray-200">
                        <div class="card-body p-0">
                            <div class="ratio ratio-16x9">
                                @if($video->getVideo())
                                    <video class="w-100 h-100" controls>
                                        <source src="{{ $video->getVideo() }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif($video->video_url)
                                    <iframe class="w-100 h-100"
                                            src="{{ $video->video_url }}"
                                            allowfullscreen></iframe>
                                @else
                                    <div class="d-flex flex-column align-items-center justify-content-center p-5 bg-light">
                                        <i class="material-symbols-rounded fs-2 text-muted">video_off</i>
                                        <p class="text-muted mt-2 mb-0">No video available</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Video Details -->
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card border border-gray-200">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Thumbnail</h6>
                                    <div class="ratio ratio-16x9 bg-light rounded overflow-hidden mb-3">
                                        @if($video->getThumbnail())
                                            <img src="{{ $video->getThumbnail() }}"
                                                 alt="Video Thumbnail"
                                                 class="w-100 h-100 object-fit-cover">
                                        @else
                                            <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                                <i class="material-symbols-rounded fs-1 text-muted">image</i>
                                                <p class="text-muted mt-2 mb-0">No thumbnail</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-3">
                                        <h6 class="fw-bold mb-2">Duration</h6>
                                        <p class="mb-0">
                                            {{ $video->duration ? $video->duration . ' minutes' : 'N/A' }}
                                        </p>
                                    </div>

                                    <div class="mt-3">
                                        <h6 class="fw-bold mb-2">Order in Course</h6>
                                        <p class="mb-0">{{ $video->order_in_course ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card border border-gray-200">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">{{ $video->title }}</h5>

                                    <div class="mb-3">
                                        <h6 class="fw-bold mb-2">Description</h6>
                                        <p class="text-muted mb-0">{{ $video->description ?: 'No description provided.' }}</p>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold mb-2">Created At</h6>
                                            <p class="mb-0">{{ $video->created_at->format('M d, Y') }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="fw-bold mb-2">Last Updated</h6>
                                            <p class="mb-0">{{ $video->updated_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Questions Section -->
                        <div class="card border border-gray-200 mt-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">Questions</h6>
                                    <a href="{{ route('dashboard.courses.videos.quiz.index', $video) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="material-symbols-rounded fs-6 me-1">quiz</i>
                                        View Questions ({{ $video->questions_count }})
                                    </a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .border-gray-200 {
        border-color: #e2e8f0;
    }

    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endsection
