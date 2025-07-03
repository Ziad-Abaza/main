<?php

namespace App\Http\Controllers\Api\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use App\Models\Course;
use App\Models\QuizAssignment;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuizAttempt;
use Throwable;
use Illuminate\Support\Str;

class CourseQuizController extends Controller
{
    // GET /api/quizzes/course/{courseId}
    public function showQuizForCourse(Request $request, $courseId)
    {
        try {
            $user = Auth::user();
            $course = Course::findOrFail($courseId);
            if (!$user->isEnrolledIn($courseId)) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'You are not enrolled in this course',
                ], Response::HTTP_FORBIDDEN);
            }
            $now = now();
            $quizzes = QuizAssignment::where('course_id', $courseId)
                ->orderBy('start_at', 'asc')
                ->get();
            if ($quizzes->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_NOT_FOUND,
                    'message' => 'No quizzes found for this course',
                ], Response::HTTP_NOT_FOUND);
            }
            $quizData = $quizzes->map(function($quiz) use ($now) {
                $status = 'open';
                if ($quiz->end_at && $quiz->end_at->isPast()) {
                    $status = 'closed';
                } elseif ($quiz->start_at && $now->lt($quiz->start_at)) {
                    $status = 'scheduled';
                }
                return [
                    'quiz_id' => $quiz->quiz_id,
                    'title' => $quiz->title,
                    'start_at' => $quiz->start_at,
                    'duration_minutes' => $quiz->duration_minutes,
                    'end_at' => $quiz->end_at,
                    'status' => $status,
                    'message' => $status === 'scheduled' ? 'Quiz opens at ' . $quiz->start_at->format('M d, Y H:i') : null,
                ];
            });
            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'data' => [
                    'course_id' => $course->course_id,
                    'course_title' => $course->title,
                    'quizzes' => $quizData,
                ]
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'An error occurred while processing your request',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // POST /api/quizzes/course/{courseId}
    public function submitQuizAnswers(Request $request, $courseId)
    {
        try {
            $user = Auth::user();
            $course = Course::findOrFail($courseId);
            if (!$user->isEnrolledIn($courseId)) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'You are not enrolled in this course.',
                ], Response::HTTP_FORBIDDEN);
            }
            $quiz = QuizAssignment::where('course_id', $courseId)
                ->orderBy('start_at', 'desc')
                ->first();
            if (!$quiz) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_NOT_FOUND,
                    'message' => 'No quiz found for this course',
                ], Response::HTTP_NOT_FOUND);
            }
            $validated = $request->validate([
                'answers' => 'required|array',
                'answers.*.question_id' => 'required|uuid|exists:questions,question_id',
                'answers.*.selected_option_id' => 'required|uuid|exists:question_options,option_id',
            ]);
            $submittedAnswers = $request->input('answers');
            $score = 0;
            $totalQuestions = count($submittedAnswers);
            $userId = Auth::id();
            foreach ($submittedAnswers as $answer) {
                $question = Question::with('questionOptions')->find($answer['question_id']);
                $correctOption = $question->questionOptions->firstWhere('is_correct', true);
                $selectedOption = $answer['selected_option_id'];
                $isCorrect = $correctOption && $correctOption->option_id === $selectedOption;
                if ($isCorrect) {
                    $score++;
                }
                QuizAttempt::create([
                    'attempt_id' => Str::uuid(),
                    'user_id' => $userId,
                    'question_id' => $question->question_id,
                    'selected_option_id' => $selectedOption,
                    'is_correct' => $isCorrect,
                    'attempt_time' => now(),
                ]);
            }
            $percentage = $totalQuestions > 0 ? ($score / $totalQuestions) * 100 : 0;
            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'message' => 'Quiz submitted successfully.',
                'data' => [
                    'score' => $score,
                    'total_questions' => $totalQuestions,
                    'percentage' => round($percentage, 2),
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'field validation failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $th) {
            Log::error('Course quiz submission failed: ' . $th->getMessage() . '\n' . $th->getTraceAsString());
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal Server Error',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // GET /api/quizzes/course/{courseId}/quiz-results
    public function getQuizResults(Request $request, $courseId)
    {
        try {
            $user = Auth::user();
            $course = Course::findOrFail($courseId);
            if (!$user->isEnrolledIn($courseId)) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'You are not enrolled in this course',
                ], Response::HTTP_FORBIDDEN);
            }
            $quiz = QuizAssignment::where('course_id', $courseId)
                ->orderBy('start_at', 'desc')
                ->first();
            if (!$quiz) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_NOT_FOUND,
                    'message' => 'No quiz found for this course',
                ], Response::HTTP_NOT_FOUND);
            }
            $attempts = QuizAttempt::where('user_id', $user->id)
                ->whereIn('question_id', Question::where('quiz_id', $quiz->quiz_id)->pluck('question_id'))
                ->get();
            $score = $attempts->where('is_correct', true)->count();
            $totalQuestions = $attempts->count();
            $percentage = $totalQuestions > 0 ? ($score / $totalQuestions) * 100 : 0;
            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'data' => [
                    'score' => $score,
                    'total_questions' => $totalQuestions,
                    'percentage' => round($percentage, 2),
                    'attempts' => $attempts,
                ],
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'An error occurred while processing your request',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $now = now();
            // Get all courses the user is enrolled in
            $courses = $user->enrolledCourses()->get();
            $allQuizzes = [];
            foreach ($courses as $course) {
                $quizzes = QuizAssignment::where('course_id', $course->course_id)
                    ->orderBy('start_at', 'asc')
                    ->get();
                foreach ($quizzes as $quiz) {
                    $status = 'open';
                    if ($quiz->end_at && $quiz->end_at->isPast()) {
                        $status = 'closed';
                    } elseif ($quiz->start_at && $now->lt($quiz->start_at)) {
                        $status = 'scheduled';
                    }
                    $allQuizzes[] = [
                        'quiz_id' => $quiz->quiz_id,
                        'title' => $quiz->title,
                        'start_at' => $quiz->start_at,
                        'duration_minutes' => $quiz->duration_minutes,
                        'end_at' => $quiz->end_at,
                        'status' => $status,
                        'message' => $status === 'scheduled' ? 'Quiz opens at ' . $quiz->start_at->format('M d, Y H:i') : null,
                        'course_id' => $course->course_id,
                        'course_title' => $course->title,
                    ];
                }
            }
            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'data' => [
                    'quizzes' => $allQuizzes,
                ]
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'An error occurred while processing your request',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($quizId)
    {
        try {
            $quiz = QuizAssignment::with('questions.questionOptions')->findOrFail($quizId);
            $status = 'open';
            $now = now();
            if ($quiz->end_at && $quiz->end_at->isPast()) {
                $status = 'closed';
            } elseif ($quiz->start_at && $now->lt($quiz->start_at)) {
                $status = 'scheduled';
            }
            $questions = $quiz->questions->map(function($q) {
                return [
                    'question_id' => $q->question_id,
                    'text' => $q->question_text,
                    'type' => $q->question_type,
                    'points' => $q->points,
                    'options' => $q->questionOptions->map(function($opt) {
                        return [
                            'option_id' => $opt->option_id,
                            'option_text' => $opt->option_text,
                        ];
                    }),
                ];
            });
            return response()->json([
                'success' => true,
                'code' => 200,
                'data' => [
                    'quiz_id' => $quiz->quiz_id,
                    'title' => $quiz->title,
                    'start_at' => $quiz->start_at,
                    'duration_minutes' => $quiz->duration_minutes,
                    'end_at' => $quiz->end_at,
                    'status' => $status,
                    'message' => $status === 'scheduled' ? 'Quiz opens at ' . $quiz->start_at->format('M d, Y H:i') : null,
                    'questions' => $questions,
                    'course_id' => $quiz->course_id,
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Quiz not found',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function submitQuizById(Request $request, $quizId)
    {
        try {
            $quiz = QuizAssignment::with('questions.questionOptions')->findOrFail($quizId);
            $validated = $request->validate([
                'answers' => 'required|array',
                'answers.*.question_id' => 'required|uuid|exists:questions,question_id',
                'answers.*.selected_option_id' => 'required|uuid|exists:question_options,option_id',
            ]);
            $submittedAnswers = $request->input('answers');
            $score = 0;
            $totalQuestions = count($submittedAnswers);
            $userId = auth()->id();
            foreach ($submittedAnswers as $answer) {
                $question = $quiz->questions->where('question_id', $answer['question_id'])->first();
                $correctOption = $question->questionOptions->firstWhere('is_correct', true);
                $selectedOption = $answer['selected_option_id'];
                $isCorrect = $correctOption && $correctOption->option_id === $selectedOption;
                if ($isCorrect) {
                    $score++;
                }
                \App\Models\QuizAttempt::create([
                    'attempt_id' => \Illuminate\Support\Str::uuid(),
                    'user_id' => $userId,
                    'question_id' => $question->question_id,
                    'selected_option_id' => $selectedOption,
                    'is_correct' => $isCorrect,
                    'attempt_time' => now(),
                ]);
            }
            $percentage = $totalQuestions > 0 ? ($score / $totalQuestions) * 100 : 0;
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Quiz submitted successfully.',
                'data' => [
                    'score' => $score,
                    'total_questions' => $totalQuestions,
                    'percentage' => round($percentage, 2),
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => 'field validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Internal Server Error',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
