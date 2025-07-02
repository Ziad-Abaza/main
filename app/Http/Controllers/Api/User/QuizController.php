<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Http\Resources\User\QuizAttemptResource;
use App\Models\QuizAttempt;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\Log;
class QuizController extends Controller
{
    /**
     *  Display a listing of the resource.
     */
    public function showQuizForVideo(Request $request, $videoId)
    {
        try {
            $user = Auth::user();

            // Validate the request
            $video = Video::findOrFail($videoId);

            //  Check if the user has already attempted the quiz
            /**
             * @var \App\Models\User $user
             */
            $isEnrolled = $user->isEnrolledIn($video->course_id);

            if (!$isEnrolled) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'You are not enrolled in this course',
                ], Response::HTTP_FORBIDDEN);
            }

            // Get the questions for the video
            $questions = Question::where('video_id', $videoId)
                ->with([
                    'questionOptions' => function ($query) {
                        $query->select('question_id', 'option_id', 'option_text', 'is_correct');
                    }
                ])
                ->get();

            if ($questions->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_NOT_FOUND,
                    'message' => 'No questions found for this video',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'data' => [
                    'video_id' => $video->video_id,
                    'video_title' => $video->title,
                    'quiz_questions' => $questions
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

    /**
     *  Get the questions for a video
     */
    public function submitQuizAnswers(Request $request, $videoId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'answers' => 'required|array',
                'answers.*.question_id' => 'required|uuid|exists:questions,question_id',
                'answers.*.selected_option_id' => 'required|uuid|exists:question_options,option_id',
            ]);

            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }

            $user = Auth::user();

            if (!$user) {
                Log::error('User not authenticated while submitting quiz answers.');
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'User not authenticated.',
                ], Response::HTTP_UNAUTHORIZED);
            }

            Log::info('Authenticated User:', ['user' => $user]);

            $video = Video::findOrFail($videoId);

            // Check if the user has already submitted answers for this video
            /**
             * @var \App\Models\User $user
             */
            $isEnrolled = $user->isEnrolledIn($video->course_id);

            if (!$isEnrolled) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'You are not enrolled in this course.',
                ], Response::HTTP_FORBIDDEN);
            }

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

                // Update the user's score in the database

                $attemptId = Str::uuid();
                QuizAttempt::create([
                    'attempt_id' => $attemptId,
                    'user_id' => $userId,
                    'question_id' => $question->question_id,
                    'selected_option_id' => $selectedOption,
                    'is_correct' => $isCorrect,
                    'attempt_time' => now(),
                ]);
            }

            $percentage = $totalQuestions > 0 ? ($score / $totalQuestions) * 100 : 0;

            // Update the user's score in the database
            $nextVideo = Video::where('course_id', $video->course_id)
                ->where('order_in_course', '>', $video->order_in_course)
                ->orderBy('order_in_course')
                ->first();

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'message' => 'Quiz submitted successfully.',
                'data' => [
                    'score' => $score,
                    'total_questions' => $totalQuestions,
                    'percentage' => round($percentage, 2),
                    'next_video' => $nextVideo ? [
                        'video_id' => $nextVideo->video_id,
                        'title' => $nextVideo->title,
                        'order_in_course' => $nextVideo->order_in_course
                    ] : null
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
            Log::error('Quiz submission failed: ' . $th->getMessage() . '\n' . $th->getTraceAsString());
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal Server Error',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     *  Get the quiz questions for a given video.
     */
    public function getQuizResults(Request $request, $videoId)
    {
        try {
            // Validate the request
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'Unauthorized',
                ], Response::HTTP_UNAUTHORIZED);
            }

            // Get the quiz questions for the given video
            $video = Video::findOrFail($videoId);

            // Get the quiz questions for the given video
            /**
             * @var \App\Models\User $user
             */
            $isEnrolled = $user->isEnrolledIn($video->course_id);

            if (!$isEnrolled) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'You are not enrolled in this course',
                ], Response::HTTP_FORBIDDEN);
            }

            // Get the quiz questions for the given video
            $quizAttempts = QuizAttempt::whereHas('question', function ($query) use ($videoId) {
                $query->where('video_id', $videoId);
            })
                ->where('user_id', $user->user_id)
                ->with(['question', 'selectedOption'])
                ->get();

            if ($quizAttempts->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_NOT_FOUND,
                    'message' => 'No quiz attempts found',
                ], Response::HTTP_NOT_FOUND);
            }

            // Get the quiz results for the given video
            $totalQuestions = $quizAttempts->unique('question_id')->count();
            $correctAnswers = $quizAttempts->where('is_correct', true)->unique('question_id')->count();
            $percentage = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;


            // Return the quiz results
            $nextVideo = Video::where('course_id', $video->course_id)
                ->where('order_in_course', '>', $video->order_in_course)
                ->orderBy('order_in_course')
                ->first();


            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'data' => [
                    'video_id' => $video->video_id,
                    'video_title' => $video->title,
                    'total_questions' => $totalQuestions,
                    'correct_answers' => $correctAnswers,
                    'percentage' => $percentage,
                    'next_video' => $nextVideo ? [
                        'video_id' => $nextVideo->video_id,
                        'title' => $nextVideo->title,
                        'order_in_course' => $nextVideo->order_in_course
                    ] : null,
                    'attempts' => QuizAttemptResource::collection($quizAttempts),
                ]
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'An error occurred while processing the request',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
