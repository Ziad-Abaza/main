@extends('instructor.layouts.app')
@section('title', 'Edit Question - ' . $quiz->title)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-info text-white fw-bold">Edit Question</div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ route('dashboard.courses.quiz.questions.update', [$course, $quiz, $question]) }}">
                        @csrf
                        @method('POST')

                        <!-- Question Text -->
                        <x-inputs.textarea name="question_text" label="Question Text" rows="4"
                            :value="old('question_text', $question->question_text)" required />

                        <!-- Points -->
                        <x-inputs.number name="points" label="Points" min="1" :value="old('points', $question->points)"
                            required />

                        <!-- Question Type -->
                        <x-inputs.select name="type" label="Question Type"
                            :options="['mcq' => 'Multiple Choice', 'written' => 'Written']"
                            :selected="old('type', $question->type)" id="qtype" onchange="toggleOptions()" />

                        <!-- Options Area -->
                        <div id="options-area" style="display: none;">
                            <h6>Options</h6>
                            <div id="opts">
                                <!-- dynamic options -->
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addOption()">Add
                                Option</button>
                            <small class="d-block text-muted mt-1">Tick the checkbox for the correct answer.</small>
                        </div>

                        <!-- Buttons -->
                        <div class="mt-4">
                            <button class="btn btn-success" type="submit">Update Question</button>
                            <a href="{{ route('dashboard.courses.quiz.questions.index', [$course, $quiz]) }}"
                                class="btn btn-secondary ms-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleOptions(){
    const typeSel = document.getElementById('qtype');
    document.getElementById('options-area').style.display = typeSel.value === 'mcq' ? 'block' : 'none';
}

function addOption(val='', checked=false){
    const container = document.getElementById('opts');
    const idx = container.children.length;
    const row = document.createElement('div');
    row.className='input-group mb-2';
    row.innerHTML = `
        <span class="input-group-text">
            <input type="checkbox" name="options[${idx}][is_correct]" ${checked?'checked':''}>
        </span>
        <input type="text" name="options[${idx}][text]" class="form-control" value="${val}" required>
    `;
    container.appendChild(row);
}

window.onload = function () {
    toggleOptions();
    const optsData = @json(old('options', $question->questionOptions->map->only(['option_text','is_correct'])) ?? []);

    if (Array.isArray(optsData) && optsData.length > 0) {
        optsData.forEach(o => {
            addOption(o.option_text ?? '', o.is_correct ?? false);
        });
    } else {
        addOption();
        addOption();
    }
};
</script>
@endsection
