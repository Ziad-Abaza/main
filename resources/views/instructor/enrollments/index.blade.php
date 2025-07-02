@extends('instructor.layouts.app')
@section('title', 'Pending Enrollments - Instructor Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-radius-lg overflow-hidden">
                <div class="card-header bg-light d-flex align-items-center p-3">
                    <i class="material-symbols-rounded fs-5 me-2">person_add</i>
                    <h5 class="mb-0">Pending Enrollments</h5>
                </div>

                <div class="card-body p-4">
                    <!-- Livewire Component -->
                    <livewire:pending-enrollments />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
