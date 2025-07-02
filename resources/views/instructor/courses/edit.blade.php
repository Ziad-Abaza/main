@extends('instructor.layouts.app')
@section('title', 'Edit Course - Instructor Panel')

@section('content')
<style>
    .card {
        border: 2px solid #dee2e6;
        border-radius: 1rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(0, 0, 0, 0.1);
    }

    .form-control,
    .form-select {
        border: 2px solid #ced4da;
        border-radius: 0.5rem;
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .form-group label {
        font-weight: 600;
        color: #343a40;
    }

    .section-border {
        border: 1px dashed #adb5bd;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        background-color: #f9fafb;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
        font-weight: 600;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-radius-lg overflow-hidden">
                <!-- Header -->
                <div class="card-header bg-light text-white d-flex align-items-center p-3">
                    <i class="material-symbols-rounded fs-5 me-2">school</i>
                    <h5 class="mb-0">Edit Course</h5>
                </div>

                <!-- Form -->
                <form action="{{ route('dashboard.courses.update', $course) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card-body p-4">

                        <!-- Title -->
                        <div class="mb-4">
                            <x-inputs.text name="title" label="Course Title" :value="$course->title" required />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-inputs.textarea name="description" label="Description" :value="$course->description"
                                rows="3" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-inputs.select name="category_id" label="Category"
                                :options="$categories->pluck('category_name', 'category_id')"
                                :value="$course->category_id" placeholder="Select a category" required />
                        </div>

                        <!-- Level & Language -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <x-inputs.select name="level" label="Level"
                                    :options="['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced']"
                                    :value="$course->details?->level" placeholder="Select level" required />
                            </div>
                            <div class="col-md-6">
                                <x-inputs.select name="language" label="Language"
                                    :options="['en' => 'English', 'ar' => 'Arabic', 'fr' => 'French']"
                                    :value="$course->details?->language" placeholder="Select language" required />
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <x-inputs.select name="status" label="Course Status"
                                :options="['available' => 'Available', 'upcoming' => 'Upcoming', 'suspended' => 'Suspended']"
                                :value="$course->details?->status" required />
                        </div>

                        <!-- Course Image -->
                        <div class="mb-4">
                            <x-inputs.file name="course_image" label="Course Image" accept="image/*"
                                note="Upload a new cover image if needed." />

                            @if ($course->getImage())
                            <div class="mt-2">
                                <img src="{{ $course->getImage() }}" alt="Current Image" style="max-height: 150px;">
                            </div>
                            @endif
                        </div>

                        <!-- Course Icon -->
                        <div class="mb-4">
                            <x-inputs.file name="course_icon" label="Course Icon" accept="image/*"
                                note="Upload a new icon or logo if needed." />

                            @if ($course->getIcon())
                            <div class="mt-2">
                                <img src="{{ $course->getIcon() }}" alt="Current Icon" style="max-height: 80px;">
                            </div>
                            @endif
                        </div>

                        <!-- Objectives -->
                        <div class="mb-4">
                            <x-quill-editor id="objectives" name="objectives" height="200px" label="Learning Objectives"
                                :value="$course->details->objectives ?? ''" />
                        </div>

                        <!-- Prerequisites -->
                        <div class="mb-4">
                            <x-quill-editor id="prerequisites" name="prerequisites" height="150px"
                                label="Prerequisites (Optional)" :value="$course->details->prerequisites ?? ''" />
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <x-quill-editor id="content" name="content" height="300px" label="Course Content Overview"
                                :value="$course->details->content ?? ''" />
                        </div>

                        <!-- Total Duration -->
                        <div class="mb-4">
                            <x-inputs.number name="total_duration" label="Total Duration (Minutes)"
                                :value="$course->details?->total_duration" min="1" required />
                        </div>

                        <!-- Pricing Section -->
                        <div class="mt-4 pt-3 section-border">
                            <h6 class="fw-bold mb-3">Pricing</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <x-inputs.number name="price" label="Base Price (EGP)"
                                        :value="$course->pricing?->price" min="0" required />
                                </div>
                                <div class="col-md-6">
                                    <x-inputs.number name="discount_price" label="Discounted Price (Optional)"
                                        :value="$course->pricing?->discount_price" min="0" />
                                    <small class="text-muted">Must be less than base price</small>
                                </div>
                                <div class="col-md-6">
                                    <x-inputs.date name="discount_start" label="Discount Start Date"
                                        :value="optional($course->pricing?->discount_start)->format('Y-m-d')" />
                                </div>
                                <div class="col-md-6">
                                    <x-inputs.date name="discount_end" label="Discount End Date"
                                        :value="optional($course->pricing?->discount_end)->format('Y-m-d')" />
                                </div>
                            </div>
                        </div>

                        <!-- Enrollment Settings -->
                        <div class="mt-4 pt-3 section-border">
                            <h6 class="fw-bold mb-3">Enrollment Settings</h6>
                            <div class="mb-3">
                                <x-inputs.number name="max_students" label="Maximum Students Allowed"
                                    :value="$course->enrollment?->max_students" min="1" required />
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="material-symbols-rounded fs-6 me-1">save</i> Save Changes
                            </button>
                            <a href="{{ route('dashboard.courses.index') }}" class="btn btn-outline-secondary px-4">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
