@extends('instructor.layouts.app')
@section('title', 'Edit Quiz - ' . $course->title)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-info text-white fw-bold">Edit Quiz</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dashboard.courses.quiz.update', [$course, $quiz]) }}">
                        @csrf
                        @method('POST')

                        <!-- Quiz Title -->
                        <x-inputs.text name="title" label="Quiz Title" :value="old('title', $quiz->title)" required />

                        <!-- Start Date & Time -->
                        <x-inputs.date name="start_at" label="Start Date & Time"
                            :value="old('start_at', optional($quiz->start_at)->format('Y-m-d\TH:i'))" required />

                        <!-- Duration Minutes -->
                        <x-inputs.number name="duration_minutes" label="Duration (minutes)" min="1"
                            :value="old('duration_minutes', $quiz->duration_minutes)" required />

                        <!-- Buttons -->
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-success">Update Quiz</button>
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
