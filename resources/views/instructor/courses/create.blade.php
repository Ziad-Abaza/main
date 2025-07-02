@extends('instructor.layouts.app')
@section('title', 'Create New Course - Instructor Panel')

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
                <div class="card-header bg-light bg-primary text-white d-flex align-items-center p-3">
                    <i class="material-symbols-rounded fs-5 me-2">school</i>
                    <h5 class="mb-0">Add New Course</h5>
                </div>

                <!-- Form -->
                <form action="{{ route('dashboard.courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body p-4">

                        <!-- Title -->
                        <div class="mb-4">
                        <x-inputs.text name="title" label="Course Title" placeholder="Enter course title" class="form-control-lg" required />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                        <x-inputs.textarea name="description" label="Description" placeholder="Brief description about the course" rows="3" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                        <x-inputs.select name="category_id" label="Category" :options="$categories->pluck('category_name', 'category_id')"
                            placeholder="Select a category" required />
                        </div>
                        <!-- Level & Language -->


                        <div class="row mb-4">
                            <div class="col-md-6">
                            <x-inputs.select name="level" label="Level" :options="[
                                'beginner' => 'Beginner',
                                'intermediate' => 'Intermediate',
                                'advanced' => 'Advanced',]" placeholder="Select level" required />
                            </div>
                            <div class="col-md-6">
                                <x-inputs.select name="language" label="language" placeholder="Select language"
                                :options="[
                                    'en' => 'English',
                                    'ar' => 'Arabic',
                                ]"
                                required/>
                            </div>
                        </div>

                        <!-- Course Status -->
                        <div class="mb-4">
                            <x-inputs.select name="status" label="Course Status" placeholder="Course Status"
                            :options="[
                                'available' => 'Available',
                                'upcoming' => 'Upcoming',
                                'suspended' => 'Suspended'
                            ]"
                            required/>
                            <small class="text-muted">Choose the current status of the course.</small>
                        </div>

                        <!-- Course Image -->
                        <div class="mb-4">
                            <x-inputs.file name="course_image" label="Course Image" accept="image/*" note="Upload a cover image for the course." />
                        </div>

                        <!-- Course Icon -->
                        <div class="mb-4">
                            <x-inputs.file name="course_icon" label="Course Icon" accept="image/*" note="Upload an icon or logo for the course." />
                        </div>

                        <!-- Objectives -->
                        <div class="mb-4">
                            <x-quill-editor id="objectives" name="objectives" height="200px"
                                label="Learning Objectives" />
                        </div>

                        <!-- Prerequisites -->
                        <div class="mb-4">
                            <x-quill-editor id="prerequisites" name="prerequisites" height="150px"
                                label="Prerequisites (Optional)" />
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <x-quill-editor id="content" name="content" height="300px"
                                label="Course Content Overview" />
                        </div>

                        <!-- Duration -->
                        <div class="mb-4">
                            <x-inputs.number name="total_duration" label="Total Duration (Minutes)" min="1" required placeholder="Enter total duration in minutes"/>
                        </div>

                        <!-- Pricing Section -->
                        <div class="mt-4 pt-3 section-border">
                            <h6 class="fw-bold mb-3">Pricing</h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                        <x-inputs.number name="price" placeholder="Base Price" label="Base Price (EGP)" min="0" required />
                                </div>
                                <div class="col-md-6">
                                    <x-inputs.number name="discount_price" placeholder="Discounted Price" label="Discounted Price (Optional)" min="0" />
                                    <small class="text-muted">Must be less than base price</small>
                                </div>
                                <div class="col-md-6">
                                    <x-inputs.date name="discount_start" label="Discount Start Date" :required="true"
                                        min="{{ now()->toDateString() }}" />
                                </div>

                                <div class="col-md-6">
                                    <x-inputs.date name="discount_end" label="Discount End Date" note="End date must be after the start date" />
                                </div>
                            </div>
                        </div>

                        <!-- Enrollment Settings -->
                        <div class="mt-4 pt-3 section-border">
                            <h6 class="fw-bold mb-3">Enrollment Settings</h6>
                            <div class="mb-3">
                                <x-inputs.number name="max_students" placeholder="Enter the number of available spots for this course" label="Maximum Students Allowed" min="1" required />
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="material-symbols-rounded fs-6 me-1">save</i> Save Course
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
