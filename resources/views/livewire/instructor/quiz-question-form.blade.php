<div class="p-4 bg-white">
    @if ($successMessage)
    <div class="alert alert-success">{{ $successMessage }}</div>
    @endif

    <form wire:submit.prevent="submit">
        <!-- Question Text -->
        <div class="mb-3">
            <label class="form-label fw-bold">Question Text</label>
            <textarea wire:model.defer="question_text"
                class="form-control border border-light rounded p-3 focus-ring focus-ring-primary" required rows="4"
                placeholder="Write your question here..."></textarea>
            @error('question_text')
            <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <!-- Points -->
        <div class="mb-3">
            <label class="form-label fw-bold">Points</label>
            <input type="number" wire:model.defer="points"
                class="form-control border border-light rounded p-2 focus-ring focus-ring-primary" min="1" required>
            @error('points')
            <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <!-- Question Type -->
        <div class="mb-3">
            <label class="form-label fw-bold">Question Type</label>
            <select wire:model="type"
                class="form-select border border-light rounded p-2 focus-ring focus-ring-primary">
                <option value="">Select Type</option>
                <option value="mcq">Multiple Choice</option>
                <option value="written">Written</option>
            </select>
            @error('type')
            <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <!-- MCQ Options -->
        @if ($type === 'mcq')
        <div class="mt-4 p-3 border-2 border-secondary border-dashed rounded bg-white">
            <h6 class="fw-bold mb-3">Options</h6>

            @foreach ($options as $idx => $option)
            <div class="d-flex align-items-center gap-2 mb-2">
                <!-- Correct Option Radio -->
                <div class="form-check flex-shrink-0">
                    <input type="radio" wire:model="correct_option" value="{{ $idx }}" class="form-check-input mt-1"
                        id="option-radio-{{ $idx }}">
                </div>

                <!-- Option Input -->
                <div class="flex-grow-1">
                    <input type="text" wire:model.defer="options.{{ $idx }}.text"
                        class="form-control border border-light rounded p-2 focus-ring focus-ring-primary"
                        placeholder="Enter option text">
                </div>

                <!-- Remove Button -->
                <button type="button" wire:click="removeOption({{ $idx }})" class="btn btn-outline-danger btn-sm ms-2"
                    @if(count($options) <=2) disabled @endif>
                    &times;
                </button>
            </div>
            @endforeach

            <!-- Add Option Button -->
            <div class="mt-3">
                <button type="button" wire:click="addOption" class="btn btn-sm btn-outline-secondary">
                    + Add Option
                </button>
            </div>

            <!-- Error Messages -->
            <small class="text-muted mt-2 d-block">Tick the radio for the correct answer.</small>

            @if($errors->has('correct_option'))
            <div class="text-danger small mt-1">{{ $errors->first('correct_option') }}</div>
            @endif

            @if($errors->has('options') || $errors->has('options.*.text'))
            <div class="text-danger small mt-1">
                {{ $errors->first('options') ?: $errors->first('options.*.text') }}
            </div>
            @endif
        </div>
        @endif

        <!-- Buttons -->
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-success px-3 py-2" type="button" wire:click="submit('add')">
                <i class="fas fa-plus me-1"></i> Add Question
            </button>
            <button class="btn btn-primary px-3 py-2" type="button" wire:click="submit('finish')">
                Finish Quiz
            </button>
            <a href="{{ route('dashboard.courses.quiz.questions.index', [$course, $quiz]) }}"
                class="btn btn-secondary px-3 py-2">
                Cancel
            </a>
        </div>
    </form>
</div>
