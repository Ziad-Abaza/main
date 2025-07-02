@extends('instructor.layouts.app')
@section('title', 'Edit Question - ' . $video->title)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-light text-white d-flex align-items-center p-3">
                    <i class="material-symbols-rounded fs-5 me-2">edit</i>
                    <h5 class="mb-0">Edit Question</h5>
                </div>

                <div class="card-body p-4">
                    <form
                        action="{{ route('dashboard.courses.videos.quiz.update', [$video, $question]) }}"
                        method="POST">
                        @csrf
                        @method('POST')

                        <!-- Question Text -->
                        <div class="mb-4">
                            <x-inputs.textarea name="question_text" label="Question Text" rows="3"
                                :value="old('question_text', $question->question_text)" required />
                        </div>

                        <!-- Question Type -->
                        <div class="mb-4">
                            <x-inputs.select name="question_type" label="Question Type" :options="[
                                    'single_choice' => 'Single Choice',
                                    'true_false' => 'True / False'
                                ]" :selected="$question->question_type" placeholder="Select type" required />
                        </div>

                        <!-- Points -->
                        <div class="mb-4">
                            <x-inputs.number name="points" label="Points" min="1"
                                :value="old('points', $question->points)" required />
                        </div>

                        <!-- Options Container -->
                        <div id="options-container">
                            @php
                            $correctIndex = null;
                            foreach ($question->questionOptions as $key => $option) {
                            if ($option->is_correct) {
                            $correctIndex = $key;
                            }
                            }
                            @endphp

                            @foreach ($question->questionOptions as $key => $option)
                            <div class="mb-4 option-group d-flex align-items-center gap-3">
                                <input type="text" name="options[{{ $key }}][text]"
                                    class="form-control border border-2 border-light focus-ring-primary p-2 flex-grow-1"
                                    value="{{ $option->option_text }}" required>
                                <input type="hidden" name="options[{{ $key }}][id]" value="{{ $option->option_id }}">
                                <div class="form-check">
                                    <input type="radio" name="correct_option" value="{{ $key }}"
                                        class="form-check-input m-0" id="option-correct-{{ $key }}"
                                        style="transform: scale(1.2);" {{ $correctIndex===$key ? 'checked' : '' }}>
                                    <label for="option-correct-{{ $key }}"
                                        class="form-check-label fw-semibold">Correct</label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Add Option Button -->
                        <div class="mb-4">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="add-option">+ Add
                                Option</button>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="material-symbols-rounded fs-6 me-1">save</i> Save Changes
                            </button>
                            <a href="{{ route('dashboard.courses.videos.show', [$video->course, $video]) }}"
                                class="btn btn-outline-secondary px-4">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let optionCount = {{ count($question->questionOptions) }};

    document.getElementById('add-option')?.addEventListener('click', () => {
        const container = document.getElementById('options-container');

        const group = document.createElement('div');
        group.className = 'mb-4 option-group d-flex align-items-center gap-3';

        group.innerHTML = `
            <input type="text" name="options[${optionCount}][text]"
                class="form-control border border-2 border-light focus-ring-primary p-2 flex-grow-1" required>

            <div class="form-check">
                <input type="radio" name="correct_option" value="${optionCount}"
                       class="form-check-input m-0" id="option-correct-${optionCount}"
                       style="transform: scale(1.2);">
                <label for="option-correct-${optionCount}" class="form-check-label fw-semibold">Correct</label>
            </div>
        `;

        container.appendChild(group);
        optionCount++;
    });
</script>
@endpush
@endsection
