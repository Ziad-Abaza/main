@extends('dashboard.layouts.app')
@section('title', 'Edit Assigned Courses - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card shadow-lg border-radius-lg">
                <div class="card-header bg-white pb-0">
                    <h5 class="mb-0">Edit Assigned Courses for "{{ $level->name }}"</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('console.level-courses.update', $level) }}" method="POST">
                        @csrf
                        @method('POST')

                        <x-inputs.select name="course_ids[]" label="Select Courses (Multiple Selection)"
                            :options="$courses->pluck('title', 'course_id')"
                            :selected="$level->courses->pluck('course_id')->toArray()" multiple />

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('console.level-courses.index') }}"
                                class="btn btn-outline-secondary btn-sm px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark btn-sm px-4">
                                Update Courses
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const courseSelect = document.querySelector('select[name="course_ids[]"]');
    if (courseSelect) {
        // Add visual feedback for multiple selection
        courseSelect.addEventListener('change', function() {
            const selectedCount = Array.from(this.selectedOptions).length;
            const label = this.previousElementSibling;
            if (label && label.tagName === 'LABEL') {
                const baseText = 'Select Courses (Multiple Selection)';
                if (selectedCount > 0) {
                    label.textContent = `${baseText} - ${selectedCount} selected`;
                } else {
                    label.textContent = baseText;
                }
            }
        });

        // Trigger change event to show initial count
        courseSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
@endsection
