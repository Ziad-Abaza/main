@extends('instructor.layouts.app')
@section('title', 'Create Quiz - ' . $course->title)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-primary text-white fw-bold">Create New Quiz</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dashboard.courses.quiz.store', $course) }}">
                        @csrf

                        <!-- Quiz Title -->
                        <x-inputs.text name="title" label="Quiz Title" :value="old('title')" required />

                        <!-- Start Date & Time -->
                        <x-inputs.date name="start_at" label="Start Date & Time" :value="old('start_at')"
                            required />

                        <!-- Duration Minutes -->
                        <x-inputs.number name="duration_minutes" label="Duration (minutes)" min="1"
                            :value="old('duration_minutes', 60)" required />

                        <!-- Buttons -->
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-success">Create Quiz</button>
                            <a href="{{ route('dashboard.courses.quiz.index', $course) }}"
                                class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
