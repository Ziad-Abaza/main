@extends('instructor.layouts.app')
@section('title', 'Add New Video - ' . $course->title)
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-lg border-radius-lg overflow-hidden">
                <!-- Header -->
                <div class="card-header bg-light text-white d-flex align-items-center p-3">
                    <i class="material-symbols-rounded fs-5 me-2">add_circle</i>
                    <h5 class="mb-0">Add New Video to "{{ $course->title }}"</h5>
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <a href="{{ route('dashboard.courses.videos.index', $course) }}"
                            class="btn btn-outline-secondary btn-sm">
                            <i class="material-symbols-rounded fs-6 me-1">arrow_back</i>
                            Back to Videos
                        </a>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('dashboard.courses.videos.store', $course) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Video Title -->
                        <div class="mb-4">
                            <x-inputs.text name="title" label="Video Title" :value="old('title')" required />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-inputs.textarea name="description" label="Description (Optional)"
                                :value="old('description')" rows="3" />
                        </div>

                        <!-- Video Source Section -->
                        <div class="mb-4 p-3 bg-light rounded">
                            <h6 class="fw-bold mb-3">Video Source</h6>

                            <!-- Tabs Navigation -->
                            <ul class="nav nav-pills mb-3 d-flex align-items-center justify-content-between overflow-hidden"
                                id="videoSourceTabs" role="tablist">
                                <li class="nav-item w-lg-50 d-flex justify-content-center" role="presentation">
                                    <button class="nav-link w-100 active" id="upload-tab" data-bs-toggle="pill"
                                        data-bs-target="#upload-pane" type="button" role="tab">
                                        <i class="material-symbols-rounded fs-6 me-1">file_upload</i>
                                        Upload Video
                                    </button>
                                </li>
                                <li class="nav-item w-lg-50 d-flex justify-content-center" role="presentation">
                                    <button class="nav-link w-100" id="youtube-tab" data-bs-toggle="pill"
                                        data-bs-target="#youtube-pane" type="button" role="tab">
                                        <i class="fa-brands fa-youtube fs-6 me-1"></i>
                                        YouTube Link
                                    </button>
                                </li>
                            </ul>

                            <!-- Tabs Content -->
                            <div class="tab-content" id="videoSourceTabsContent">
                                <!-- Upload Video Tab -->
                                <div class="tab-pane fade show active" id="upload-pane" role="tabpanel">
                                    <div class="mb-3">
                                        <x-inputs.file name="video_file" label="Upload Video File" accept="video/*"
                                            note="MP4, AVI, MOV (Max: 100MB)" />
                                    </div>

                                    <div class="mb-3">
                                        <x-inputs.file name="thumbnail" label="Video Thumbnail" accept="image/*"
                                            note="JPG, PNG, JPEG" />
                                    </div>
                                </div>

                                <!-- YouTube Tab -->
                                <div class="tab-pane fade" id="youtube-pane" role="tabpanel">
                                    <div class="mb-3">
                                        <x-inputs.text name="youtube_url" label="YouTube Video URL"
                                            placeholder="https://www.youtube.com/watch?v=..."
                                            :value="old('youtube_url')" />
                                        <small class="text-muted">Paste full YouTube video URL</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Video Order -->
                        <div class="mb-4">
                            <x-inputs.number name="order_in_course" label="Order in Course" min="1"
                                :value="old('order_in_course', $nextOrder ?? '')" />
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="material-symbols-rounded fs-6 me-1">save</i>
                                Save Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
    }

    .nav-link.active {
        background-color: #6a11cb !important;
        color: white !important;
    }

    .form-label {
        font-weight: 600;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection
