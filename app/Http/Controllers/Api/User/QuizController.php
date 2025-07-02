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
     * عرض الأسئلة الخاصة بالفيديو
     */
    public function showQuizForVideo(Request $request, $videoId)
    {
        try {
            $user = Auth::user();

            // التحقق من وجود الفيديو
            $video = Video::findOrFail($videoId);

            // التحقق من أن المستخدم مسجل في الدورة
            /**
             * @var \App\Models\User $user
             */
            $isEnrolled = $user->userCourseProgress()
                ->where('course_id', $video->course_id)
                ->exists();

            if (!$isEnrolled) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'يجب عليك التسجيل في الدورة لرؤية هذا الاختبار.',
                ], Response::HTTP_FORBIDDEN);
            }

            // جلب الأسئلة مع الخيارات
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
                    'message' => 'لا توجد أسئلة لهذا الفيديو.',
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
                'message' => 'فشل في استرجاع الأسئلة',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * إرسال إجابات المستخدم وحساب النتيجة
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

            // التحقق من تسجيل المستخدم في الدورة
            /**
             * @var \App\Models\User $user
             */
            $isEnrolled = $user->userCourseProgress()
                ->where('course_id', $video->course_id)
                ->exists();

            if (!$isEnrolled) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'يجب عليك التسجيل في الدورة لتقديم هذا الاختبار.',
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

                // حفظ كل إجابة في QuizAttempt

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

            // جلب الفيديو التالي
            $nextVideo = Video::where('course_id', $video->course_id)
                ->where('order_in_course', '>', $video->order_in_course)
                ->orderBy('order_in_course')
                ->first();

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'message' => 'تم تقديم الإجابات بنجاح!',
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
                'message' => 'فشل في التحقق من البيانات',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $th) {
            Log::error('Quiz submission failed: ' . $th->getMessage() . '\n' . $th->getTraceAsString());
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'فشل في تقديم الإجابات',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * استرجاع نتائج الاختبار للمستخدم بناءً على معرف الفيديو ومستخدم
     */
    public function getQuizResults(Request $request, $videoId)
    {
        try {
            // الحصول على المستخدم الحالي
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'المستخدم غير مصادق عليه.',
                ], Response::HTTP_UNAUTHORIZED);
            }

            // التحقق من وجود الفيديو
            $video = Video::findOrFail($videoId);

            // التحقق من تسجيل المستخدم في الدورة
            /**
             * @var \App\Models\User $user
             */
            $isEnrolled = $user->userCourseProgress()
                ->where('course_id', $video->course_id)
                ->exists();

            if (!$isEnrolled) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'يجب عليك التسجيل في الدورة لرؤية نتائج هذا الاختبار.',
                ], Response::HTTP_FORBIDDEN);
            }

            // جلب جميع المحاولات الخاصة بالفيديو
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
                    'message' => 'لا توجد نتائج لهذا الاختبار للمستخدم.',
                ], Response::HTTP_NOT_FOUND);
            }

            // حساب النتيجة
            $totalQuestions = $quizAttempts->unique('question_id')->count();
            $correctAnswers = $quizAttempts->where('is_correct', true)->unique('question_id')->count();
            $percentage = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;


            // جلب الفيديو التالي
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
                'message' => 'فشل في استرجاع نتائج الاختبار',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
