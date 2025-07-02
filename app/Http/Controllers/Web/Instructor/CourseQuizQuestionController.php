<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\QuizAssignment;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CourseQuizQuestionController extends Controller
{
    public function index(Course $course, QuizAssignment $quiz)
    {
        $this->authorizeAccess($course, $quiz);
        $questions = $quiz->questions()->with('questionOptions')->paginate(10);
        return view('instructor.quiz_assignment.questions.index', compact('course', 'quiz', 'questions'));
    }

    public function create(Course $course, QuizAssignment $quiz)
    {
        $this->authorizeAccess($course, $quiz);
        return view('instructor.quiz_assignment.questions.create', compact('course', 'quiz'));
    }

    public function store(Request $request, Course $course, QuizAssignment $quiz)
    {
        $this->authorizeAccess($course, $quiz);

        $validated = $request->validate([
            'question_text' => 'required|string|max:500',
            'points' => 'required|integer|min:1',
            'type' => 'required|in:mcq,written',
            'options' => 'required_if:type,mcq|array|min:2',
            'options.*.text' => 'required_if:type,mcq|string|max:255',
        ]);

        if ($request->input('type') === 'mcq' && $request->input('correct_option') === null) {
            return back()->withInput()->withErrors(['correct_option' => 'You must select the correct answer.']);
        }

        try {
            $question = $quiz->questions()->create([
                'question_text' => $validated['question_text'],
                'points' => $validated['points'],
                'type' => $validated['type'],
            ]);

            if ($validated['type'] === 'mcq') {
                $correctIdx = $request->input('correct_option');
                foreach ($validated['options'] as $idx => $option) {
                    $question->questionOptions()->create([
                        'option_text' => $option['text'],
                        'is_correct' => ((string)$idx === (string)$correctIdx),
                    ]);
                }
            }

            if ($request->input('action') === 'finish') {
                return redirect()->route('dashboard.courses.quiz.questions.index', [$course, $quiz])
                    ->with('success', 'Question added and quiz finished.');
            } else {
                return redirect()->route('dashboard.courses.quiz.questions.create', [$course, $quiz])
                    ->with('success', 'Question added. You can add another.');
            }
        } catch (\Throwable $e) {
            Log::error('Failed to store quiz question.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to create question.');
        }
    }

    public function edit(Course $course, QuizAssignment $quiz, Question $question)
    {
        $this->authorizeAccess($course, $quiz);
        if ($question->quiz_id !== $quiz->quiz_id) abort(403);
        $question->load('questionOptions');
        return view('instructor.quiz_assignment.questions.edit', compact('course', 'quiz', 'question'));
    }

    public function update(Request $request, Course $course, QuizAssignment $quiz, Question $question)
    {
        $this->authorizeAccess($course, $quiz);
        if ($question->quiz_id !== $quiz->quiz_id) abort(403);

        $validated = $request->validate([
            'question_text' => 'required|string|max:500',
            'points' => 'required|integer|min:1',
            'type' => 'required|in:mcq,written',
            'options' => 'required_if:type,mcq|array|min:2',
            'options.*.text' => 'required_if:type,mcq|string|max:255',
            'options.*.is_correct' => 'nullable',
        ]);

        $question->update([
            'question_text' => $validated['question_text'],
            'points' => $validated['points'],
            'type' => $validated['type'],
        ]);

        // handle options
        if ($validated['type'] === 'mcq') {
            $question->questionOptions()->delete();
            foreach ($validated['options'] as $option) {
                $question->questionOptions()->create([
                    'option_text' => $option['text'],
                    'is_correct' => isset($option['is_correct']) ? true : false,
                ]);
            }
        } else {
            $question->questionOptions()->delete();
        }

        return redirect()->route('dashboard.courses.quiz.questions.index', [$course, $quiz])
            ->with('success', 'Question updated successfully.');
    }

    public function destroy(Course $course, QuizAssignment $quiz, Question $question)
    {
        $this->authorizeAccess($course, $quiz);
        if ($question->quiz_id !== $quiz->quiz_id) abort(403);
        $question->delete();
        return back()->with('success', 'Question deleted.');
    }

    private function authorizeAccess(Course $course, QuizAssignment $quiz)
    {
        if ($course->instructor_id !== Auth::id() || $quiz->course_id !== $course->course_id) {
            abort(403, 'Unauthorized access');
        }
    }
}
