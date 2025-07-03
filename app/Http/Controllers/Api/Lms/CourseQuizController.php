<?php

namespace App\Http\Controllers\Api\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\QuizAssignment;
use App\Models\QuizAttempt;
use App\Models\QuestionOption;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Response;

class CourseQuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // Get all quizzes for enrolled courses
    public function index(Request $request)
    {
        try {
            $user = $request->user();

            $quizzes = QuizAssignment::whereHas('course.userCourseProgress', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
                ->with(['course' => function ($query) {
                    $query->select('course_id', 'title');
                }])
                ->get();

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'message' => 'Quizzes fetched successfully.',
                'data' => $quizzes->map(function ($quiz) {
                    return [
                        'quiz_id' => $quiz->quiz_id,
                        'title' => $quiz->title,
                        'course_title' => $quiz->course->title,
                        'start_at' => $quiz->start_at,
                        'end_at' => $quiz->end_at,
                        'duration_minutes' => $quiz->duration_minutes,
                        'status' => $quiz->status, // scheduled / available / ended
                        'is_attempted' => $quiz->is_attempted, // true / false
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to fetch quizzes.' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Get quiz details including questions and user attempts
    public function show(QuizAssignment $quiz, Request $request)
    {
        $user = $request->user();

        if (!$user->isEnrolledIn($quiz->course_id)) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_FORBIDDEN,
                'message' => 'You are not enrolled in this course.'
            ], Response::HTTP_FORBIDDEN);
        }

        $quizDetails = QuizAssignment::with([
            'questions.questionOptions',
            'questions.quizAttempts' => function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            }
        ])->find($quiz->quiz_id);

        return response()->json([
            'success' => true,
            'code' => Response::HTTP_OK,
            'message' => 'Quiz details retrieved successfully.',
            'data' => [
                'quiz_id' => $quizDetails->quiz_id,
                'title' => $quizDetails->title,
                'start_at' => $quizDetails->start_at,
                'end_at' => $quizDetails->end_at,
                'duration_minutes' => $quizDetails->duration_minutes,
                'status' => $quizDetails->status,
                'is_attempted' => $quizDetails->is_attempted,
                'questions' => $quizDetails->questions->map(function ($question) use ($user) {
                    $attempt = $question->quizAttempts->first();
                    return [
                        'question_id' => $question->question_id,
                        'question_text' => $question->question_text,
                        'type' => $question->type,
                        'points' => $question->points,
                        'attempted' => !!$attempt,
                        'given_answer' => $attempt && $attempt->essay_answer ? $attempt->essay_answer : null,
                        'selected_option_id' => $attempt && $attempt->selected_option_id ? $attempt->selected_option_id : null,
                        'is_correct' => $attempt && $attempt->is_correct ? $attempt->is_correct : null,
                    ];
                }),
            ]
        ]);
    }

    // Submit quiz answers
    public function submit(Request $request)
    {
        $user = $request->user();

        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'quiz_id' => 'required|exists:quiz_assignments,quiz_id',
                'answers' => 'required|array',
                'answers.*.question_id' => 'required|exists:questions,question_id',
                'answers.*.type' => 'required|in:mcq,essay',
                'answers.*.answer' => 'required',
            ]);

            $quiz = QuizAssignment::findOrFail($validated['quiz_id']);

            if (!$user->isEnrolledIn($quiz->course_id)) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'You are not enrolled in this course.'
                ], Response::HTTP_FORBIDDEN);
            }

            $results = [];

            foreach ($validated['answers'] as $answer) {
                $question = $quiz->questions()
                    ->where('question_id', $answer['question_id'])
                    ->firstOrFail();

                if ($answer['type'] === 'mcq') {
                    $option = QuestionOption::findOrFail($answer['answer']);
                    $isCorrect = $option->is_correct;

                    $attempt = QuizAttempt::create([
                        'user_id' => $user->user_id,
                        'question_id' => $question->question_id,
                        'selected_option_id' => $option->option_id,
                        'is_correct' => $isCorrect,
                        'attempt_time' => now(),
                    ]);

                    $results[] = [
                        'question_id' => $question->question_id,
                        'question_text' => $question->question_text,
                        'selected_option_id' => $option->option_id,
                        'selected_option_text' => $option->option_text,
                        'correct_option' => $question->questionOptions
                            ->filter(fn($opt) => $opt->is_correct)
                            ->first()?->option_text,
                        'is_correct' => $isCorrect,
                        'score' => $isCorrect ? $question->points : 0,
                        'max_score' => $question->points,
                        'type' => 'mcq'
                    ];
                } elseif ($answer['type'] === 'essay') {
                    $attempt = QuizAttempt::create([
                        'user_id' => $user->user_id,
                        'question_id' => $question->question_id,
                        'attempt_time' => now(),
                        'essay_answer' => $answer['answer'],
                    ]);

                    $results[] = [
                        'question_id' => $question->question_id,
                        'question_text' => $question->question_text,
                        'given_answer' => $answer['answer'],
                        'status' => 'pending_instructor_review',
                        'type' => 'essay'
                    ];
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'message' => 'Answers submitted successfully.',
                'data' => [
                    'results' => $results
                ]
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to submit answers.' . $e->getMessage()
            ]);
        }
    }

    // Get quiz results for the authenticated user
    public function results(QuizAssignment $quiz, Request $request)
    {
        $user = $request->user();

        if (!$user->isEnrolledIn($quiz->course_id)) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_FORBIDDEN,
                'message' => 'You are not enrolled in this course.'
            ], Response::HTTP_FORBIDDEN);
        }

        $quizDetails = QuizAssignment::with([
            'questions.questionOptions',
            'questions.quizAttempts' => function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            }
        ])->find($quiz->quiz_id);

        if (!$quizDetails) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'Quiz not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $totalScore = 0;
        $maxPossibleScore = 0;

        $questionsData = $quizDetails->questions->map(function ($question) use ($user, &$totalScore, &$maxPossibleScore) {
            $attempt = $question->quizAttempts->first();

            $questionData = [
                'question_id' => $question->question_id,
                'question_text' => $question->question_text,
                'type' => $question->type,
                'points' => $question->points,
                'attempted' => !!$attempt,
                'given_answer' => null,
                'selected_option_text' => null,
                'correct_answer' => null,
                'is_correct' => false,
                'score' => 0,
            ];

            $maxPossibleScore += $question->points;

            if ($attempt) {
                if ($question->type === 'mcq') {
                    $correctOption = $question->questionOptions->where('is_correct', true)->first();
                    $selectedOption = $question->questionOptions->find($attempt->selected_option_id);

                    $questionData['selected_option_text'] = $selectedOption?->option_text;
                    $questionData['correct_answer'] = $correctOption?->option_text;
                    $questionData['is_correct'] = $attempt->is_correct;

                    if ($attempt->is_correct) {
                        $questionData['score'] = $question->points;
                        $totalScore += $question->points;
                    }
                } elseif ($question->type === 'essay') {
                    $questionData['given_answer'] = $attempt->essay_answer;
                    $questionData['status'] = 'pending_instructor_review';
                }
            }

            return $questionData;
        });

        $percentage = $maxPossibleScore > 0 ? ($totalScore / $maxPossibleScore) * 100 : 0;

        return response()->json([
            'success' => true,
            'code' => Response::HTTP_OK,
            'message' => 'Quiz results retrieved successfully.',
            'data' => [
                'quiz_id' => $quizDetails->quiz_id,
                'title' => $quizDetails->title,
                'total_score' => $totalScore,
                'max_score' => $maxPossibleScore,
                'percentage' => round($percentage, 2),
                'questions' => $questionsData
            ]
        ]);
    }
}
