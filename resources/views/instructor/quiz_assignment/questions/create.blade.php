@extends('instructor.layouts.app')
@section('title', 'Add Question - ' . $quiz->title)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-primary text-white fw-bold">Add Question</div>
                <div class="card-body">
                    <livewire:instructor.quiz-question-form :course="$course" :quiz="$quiz" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
