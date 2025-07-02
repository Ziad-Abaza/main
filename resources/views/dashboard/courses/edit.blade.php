@extends('dashboard.layouts.app')
@section('title', 'Edit Course - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card shadow-lg border-radius-lg">
                <!-- Card Header -->
                <div class="card-header bg-white pb-0">
                    <h5 class="mb-0">Edit Course</h5>
                    <p class="text-sm text-muted mb-0">Modify the details of the course below.</p>
                </div>

                <!-- Form -->
                <div class="card-body p-4">
                    <form action="{{ route('console.courses.update', $course) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <!-- Course Title -->
                        <x-inputs.text name="title" label="Course Title" :value="old('title', $course->title)"
                            placeholder="Enter course title" required />

                        <!-- Description -->
                        <x-inputs.textarea name="description" label="Description"
                            :value="old('description', $course->description)" rows="5"
                            placeholder="Describe this course..." />

                        <!-- Category -->
                        <x-inputs.select name="category_id" label="Category"
                            :options="$categories->pluck('category_name', 'category_id')"
                            :selected="old('category_id', $course->category_id)" placeholder="Select Category"
                            required />

                        <!-- Instructor -->
                        <x-inputs.select name="instructor_id" label="Instructor"
                            :options="$instructors->pluck('name', 'user_id')"
                            :selected="old('instructor_id', $course->instructor_id)" placeholder="Select Instructor"
                            required />

                        <!-- Course Image -->
                        <x-inputs.file name="image" label="Course Image" accept="image/*"
                            note="Upload a new cover image if needed." />
                        @if ($course->image_path)
                        <div class="mt-2">
                            <img src="{{ asset($course->image_path) }}" alt="Current Image" width="100">
                        </div>
                        @endif

                        <!-- Course Icon -->
                        <x-inputs.file name="icon" label="Course Icon" accept="image/*"
                            note="Upload a new icon or logo if needed." />
                        @if ($course->icon_path)
                        <div class="mt-2">
                            <img src="{{ asset($course->icon_path) }}" alt="Current Icon" width="50">
                        </div>
                        @endif

                        <!-- Hidden coupon ID -->
                        <input type="hidden" name="coupon_id" value="{{ optional($generalCoupon)->coupon_id }}">

                        <!-- Coupon Section -->
                        <div class="form-check form-switch mb-3">
                            <input type="hidden" name="enable_coupon" value="0">
                            <input class="form-check-input" type="checkbox" id="enable_coupon" name="enable_coupon" {{
                                old('enable_coupon', $generalCoupon ? 1 : 0) ? 'checked' : '' }}>
                            <label class="form-check-label" for="enable_coupon">Enable Coupon</label>
                        </div>

                        <div id="couponFields"
                            style="display: {{ old('enable_coupon', $generalCoupon ? 1 : 0) ? 'block' : 'none' }};">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <x-inputs.text name="coupon_code" label="Coupon Code"
                                        :value="old('coupon_code', optional($generalCoupon)->code)" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <x-inputs.select name="discount_type" label="Discount Type"
                                        :options="['fixed' => 'Fixed Amount', 'percentage' => 'Percentage']"
                                        :selected="old('discount_type', optional($generalCoupon)->discount_type)"
                                        required />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <x-inputs.number name="discount_value" label="Discount Value" step="any"
                                        :value="old('discount_value', optional($generalCoupon)->discount_value)" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <x-inputs.number name="max_uses" label="Max Uses"
                                        :value="old('max_uses', optional($generalCoupon)->max_uses ?? 1)" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <x-inputs.date name="expires_at" label="Expiry Date"
                                        :value="old('expires_at', optional($generalCoupon)->expires_at?->format('Y-m-d'))" />
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('console.courses.index') }}"
                                class="btn btn-outline-secondary btn-sm px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark btn-sm px-4">
                                Update Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const enableCoupon = document.getElementById('enable_coupon');
        const couponFields = document.getElementById('couponFields');

        if (enableCoupon) {
            couponFields.style.display = enableCoupon.checked ? 'block' : 'none';

            enableCoupon.addEventListener('change', function () {
                couponFields.style.display = this.checked ? 'block' : 'none';
            });
        }
    });
</script>
@endpush
