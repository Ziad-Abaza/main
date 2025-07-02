<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Models\QuizAssignment; // You need to create this model & migration

class CourseQuizController extends Controller
{
    /**
     * Display a listing of the quizzes for the specified course.
     */
    public function index(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Assuming QuizAssignment model has relation with Course
        $quizzes = $course->quizzes()->paginate(10);
        return view('instructor.quiz_assignment.index', compact('course', 'quizzes'));
    }

    /**
     * Show the form for creating a new quiz.
     */
    public function create(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('instructor.quiz_assignment.create', compact('course'));
    }

    /**
     * Store a newly created quiz in storage.
     */
    public function store(Request $request, Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        try {
            $quiz = $course->quizzes()->create($validated);
            return redirect()->route('dashboard.courses.quiz.questions.create', [$course, $quiz])
                ->with('success', 'Quiz created successfully. Now add questions to your quiz.');
        } catch (\Throwable $e) {
            Log::error('Failed to store quiz.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return back()->withErrors('Failed to create quiz. Please try again later.');
        }
    }

    /**
     * Show the form for editing the specified quiz.
     */
    public function edit(Course $course, QuizAssignment $quiz)
    {
        if ($course->instructor_id !== Auth::id() || $quiz->course_id !== $course->course_id) {
            abort(403, 'Unauthorized access');
        }

        return view('instructor.quiz_assignment.edit', compact('course', 'quiz'));
    }

    /**
     * Update the specified quiz in storage.
     */
    public function update(Request $request, Course $course, QuizAssignment $quiz)
    {
        if ($course->instructor_id !== Auth::id() || $quiz->course_id !== $course->course_id) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $quiz->update($validated);
        return redirect()->route('dashboard.courses.quiz.index', $course)
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified quiz from storage.
     */
    public function destroy(Course $course, QuizAssignment $quiz)
    {
        if ($course->instructor_id !== Auth::id() || $quiz->course_id !== $course->course_id) {
            abort(403, 'Unauthorized access');
        }

        $quiz->delete();
        return back()->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Extend the quiz duration.
     */
    public function extend(Request $request, Course $course, QuizAssignment $quiz)
    {
        if ($course->instructor_id !== Auth::id() || $quiz->course_id !== $course->course_id) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'extra_minutes' => 'required|integer|min:1',
        ]);

        $quiz->duration_minutes += $validated['extra_minutes'];
        $quiz->save();

        return back()->with('success', 'Quiz time extended successfully.');
    }

    /**
     * Stop the quiz immediately.
     */
    public function stop(Course $course, QuizAssignment $quiz)
    {
        if ($course->instructor_id !== Auth::id() || $quiz->course_id !== $course->course_id) {
            abort(403, 'Unauthorized access');
        }

        $quiz->end_at = now();
        $quiz->save();

        return back()->with('success', 'Quiz stopped successfully.');
    }
}
