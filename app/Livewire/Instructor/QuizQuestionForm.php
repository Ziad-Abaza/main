<?php

namespace App\Livewire\Instructor;

use Livewire\Component;
use App\Models\Course;
use App\Models\QuizAssignment;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\Auth;

class QuizQuestionForm extends Component
{
    public Course $course;
    public QuizAssignment $quiz;

    public $question_text = '';
    public $points = 1;
    public $type = 'mcq';
    public $options = [];
    public $correct_option = null;
    public $action = 'add';

    public $successMessage = null;

    public function mount($course, $quiz)
    {
        $this->course = $course;
        $this->quiz = $quiz;
        $this->options = [
            ['text' => ''],
            ['text' => ''],
        ];
    }

    public function addOption()
    {
        $this->options[] = ['text' => ''];
    }

    public function removeOption($idx)
    {
        unset($this->options[$idx]);
        $this->options = array_values($this->options);
        if ($this->correct_option !== null && $this->correct_option == $idx) {
            $this->correct_option = null;
        }
    }

    public function updatedType($value)
    {
        if ($value === 'mcq' && count($this->options) < 2) {
            $this->options = [ ['text' => ''], ['text' => ''] ];
        }
        if ($value === 'written') {
            $this->options = [];
            $this->correct_option = null;
        }
    }

    public function submit($action = null)
    {
        $this->action = $action ?? $this->action;
        $rules = [
            'question_text' => 'required|string|max:500',
            'points' => 'required|integer|min:1',
            'type' => 'required|in:mcq,written',
        ];
        if ($this->type === 'mcq') {
            $rules['options'] = 'required|array|min:2';
            $rules['options.*.text'] = 'required|string|max:255';
            if ($this->correct_option === null) {
                $this->addError('correct_option', 'You must select the correct answer.');
                return;
            }
        }
        $this->validate($rules);

        // Authorization (same as controller)
        if ($this->course->instructor_id !== Auth::id() || $this->quiz->course_id !== $this->course->course_id) {
            abort(403, 'Unauthorized access');
        }

        $question = $this->quiz->questions()->create([
            'question_text' => $this->question_text,
            'points' => $this->points,
            'type' => $this->type,
        ]);

        if ($this->type === 'mcq') {
            foreach ($this->options as $idx => $option) {
                $question->questionOptions()->create([
                    'option_text' => $option['text'],
                    'is_correct' => ((string)$idx === (string)$this->correct_option),
                ]);
            }
        }

        if ($this->action === 'finish') {
            return redirect()->route('dashboard.courses.quiz.questions.index', [$this->course, $this->quiz])
                ->with('success', 'Question added and quiz finished.');
        } else {
            $this->reset(['question_text', 'points', 'type', 'options', 'correct_option']);
            $this->type = 'mcq';
            $this->options = [ ['text' => ''], ['text' => ''] ];
            $this->successMessage = 'Question added. You can add another.';
        }
    }

    public function render()
    {
        return view('livewire.instructor.quiz-question-form');
    }
}
