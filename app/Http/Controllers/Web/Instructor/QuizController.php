<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage_courses']);
    }
    /**
     * Display a listing of the quiz questions for the specified video.
     */
    public function index(Video $video)
    {
        if ($video->course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $questions = $video->questions()->with('questionOptions')->paginate(10);
        return view('instructor.quiz.index', compact('video', 'questions'));
    }

    /**
     * Show the form for creating a new quiz question.
     */
    public function create(Video $video)
    {
        if ($video->course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('instructor.quiz.create', compact('video'));
    }

    /**
     * Store a newly created quiz question in storage.
     */

    public function store(Request $request, Video $video)
    {
        try {
            if ($video->course->instructor_id !== Auth::id()) {
                Log::warning('Unauthorized access attempt by user ID: ' . Auth::id());
                abort(403, 'Unauthorized access');
            }

            $validated = $request->validate([
                'question_text' => 'required|string|max:500',
                'points' => 'required|integer|min:1',
                'options' => 'required|array|min:2',
                'options.*.text' => 'required|string|max:255',
                'options.*.is_correct' => 'nullable',
            ]);

            $question = Question::create([
                'video_id' => $video->video_id,
                'question_text' => $validated['question_text'],
                'points' => $validated['points'],
            ]);

            foreach ($validated['options'] as $index => $option) {
                $question->questionOptions()->create([
                    'option_text' => $option['text'],
                    'is_correct' => isset($option['is_correct']) ? true : false,
                ]);
            }

            return redirect()->route('dashboard.courses.videos.show', [ $video->course, $video ])
                ->with('success', 'Question added successfully.');
        } catch (\Throwable $e) {
            Log::error('Failed to store quiz question.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return back()->withErrors('Failed to add question.');
        }
    }


    /**
     * Show the form for editing the specified quiz question.
     */
    public function edit(Video $video, Question $question)
    {
        if ($video->course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $question->load('questionOptions');
        return view('instructor.quiz.edit', compact('video', 'question'));
    }

    /**
     * Update the specified quiz question in storage.
     */
    public function update(Request $request, Video $video, Question $question)
    {
        if ($video->course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'question_text' => 'required|string|max:500',
            'points' => 'required|integer|min:1',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string|max:255',
            'options.*.is_correct' => 'nullable|boolean',
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'points' => $request->points,
        ]);

        foreach ($request->options as $optionData) {
            if (isset($optionData['id'])) {
                $option = QuestionOption::find($optionData['id']);
                if ($option) {
                    $option->update([
                        'option_text' => $optionData['text'],
                        'is_correct' => $optionData['is_correct'] ?? false,
                    ]);
                }
            } else {
                $question->questionOptions()->create([
                    'option_text' => $optionData['text'],
                    'is_correct' => $optionData['is_correct'] ?? false,
                ]);
            }
        }

        return redirect()->route('dashboard.courses.videos.show', [$video->course, $video])
            ->with('success', 'Question updated successfully.');
    }

    /**
     * Remove the specified quiz question from storage.
     */
    public function destroy(Video $video, Question $question)
    {
        if ($video->course->instructor_id !== Auth::id() || $question->video_id !== $video->video_id) {
            abort(403, 'Unauthorized access');
        }

        $question->delete();
        return back()->with('success', 'Question deleted successfully.');
    }
}
