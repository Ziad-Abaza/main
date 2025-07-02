<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Http\Resources\User\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\UserCourseProgress;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\CourseEnrollment;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseController extends Controller
{
    /**
     * Display a listing of available courses.
     */
    public function index(Request $request)
    {
        try {
            $query = Course::with([
                'category',
                'instructor:user_id,name',
                'videos'
            ])
                ->withCount('videos');

            // Search by title
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $query->where('title', 'like', "%{$searchTerm}%");
            }

            // Filter by category
            if ($request->filled('category_id')) {
                $categoryId = $request->input('category_id');
                $query->where('category_id', $categoryId);
            }

            // Filter by instructor
            if ($request->has('instructor_id') && !empty($request->instructor_id)) {
                $query->where('instructor_id', $request->instructor_id);
            }

            // Order
            $query->orderBy('created_at', 'desc');

            // Pagination
            $perPage = $request->input('per_page', 10);
            $courses = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'code' => 200,
                'data' => CourseResource::collection($courses->items()),
                'pagination' => [
                    'current_page' => $courses->currentPage(),
                    'per_page' => $courses->perPage(),
                    'total' => $courses->total(),
                    'last_page' => $courses->lastPage(),
                ],
            ], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Failed to retrieve courses',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified course details with all related data and enrollment status.
     */
    public function show($id, Request $request)
    {
        try {
            $course = Course::with([
                'category:category_id,category_name',
                'instructor',
                'videos:video_id,course_id,title,duration',
                'certificates',
                'coupons:coupon_id,course_id,code,discount_type,discount_value',
                'details',
                'enrollment:enrollment_id,course_id,max_students,current_students,is_processing_enrollment',
                'pricing:pricing_id,course_id,price,discount_price,discount_start,discount_end',
            ])
                ->withCount([
                    'videos',
                    'userCourseProgress'
                ])
                ->where('course_id', $id)
                ->firstOrFail();

            $discountInfo = null;
            if ($course->pricing && $course->pricing->isDiscountActive()) {
                $discountInfo = [
                    'original_price' => $course->pricing->price,
                    'discounted_price' => $course->pricing->getFinalPrice(),
                    'discount_percentage' => $course->pricing->discount_price,
                    'discount_start' => $course->pricing->discount_start,
                    'discount_end' => $course->pricing->discount_end,
                    'time_left' => $course->pricing?->getTimeLeft(),
                ];
            }

            $enrolled = false;
            if (auth('sanctum')->check()) {
                $user = auth('sanctum')->user();
                $enrolled = UserCourseProgress::where([
                    'user_id' => $user->user_id,
                    'course_id' => $id
                ])->exists();
            }

            $isProcessingEnrollment = $course->enrollment ? $course->enrollment->is_processing_enrollment : false;

            $courseDetails = [
                'course' => [
                    'id' => $course->course_id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'image' => $course->getImage(),
                    'icon' => $course->getIcon(),
                    'status' => $course->details->status ?? null,
                    'level' => $course->details->level ?? null,
                    'total_duration' => $course->details->total_duration ?? null,
                    'language' => $course->details->language ?? null,
                    'created_at' => $course->created_at,
                    'updated_at' => $course->updated_at
                ],
                'instructor' => $course->instructor ? [
                    'id' => $course->instructor->user_id,
                    'name' => $course->instructor->name,
                    'email' => $course->instructor->email,
                    'avatar' => $course->instructor->getAvatar(),
                ] : null,
                'category' => $course->category ? [
                    'id' => $course->category->category_id,
                    'name' => $course->category->category_name
                ] : null,
                'details' => $course->details ? [
                    'objectives' => $course->details->objectives,
                    'prerequisites' => $course->details->prerequisites,
                    'content' => $course->details->content,
                ] : null,
                'enrollment' => $course->enrollment ? [
                    'max_students' => $course->enrollment->max_students,
                    'current_students' => $course->enrollment->current_students,
                    'available_seats' => $course->enrollment->availableSeats(),
                    'is_processing' => $course->enrollment->is_processing_enrollment,
                ] : null,
                'pricing' => $discountInfo,
                'enrolled' => $enrolled,
                'is_processing_enrollment' => $isProcessingEnrollment,
                'stats' => [
                    'videos_count' => $course->videos_count,
                    'progress_count' => $course->user_course_progress_count,
                ],
                'relationships' => [
                    'videos' => $course->videos->map(function ($video) {
                        return [
                            'id' => $video->video_id,
                            'title' => $video->title,
                            'duration' => $video->duration,
                        ];
                    }),
                    'certificates' => $course->certificates->map(function ($cert) use ($course) {
                        return [
                            'id' => $cert->certificate_id,
                            'user_has_certificate' => Auth::check() && Auth::id() == $cert->user_id,
                            'course_has_certificate' => $cert->course_id == $course->course_id,
                        ];
                    }),

                    'coupons' => $course->coupons->map(function ($coupon) {
                        return [
                            'id' => $coupon->coupon_id,
                            'code' => $coupon->code,
                            'discount_type' => $coupon->discount_type,
                            'discount_value' => $coupon->discount_value,
                        ];
                    })
                ]
            ];

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'data' => $courseDetails
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'Course not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (Throwable $th) {
            Log::error('Course details fetch error', [
                'course_id' => $id,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to retrieve course details',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Enroll the authenticated user in a course.
     */
    public function enroll($id, Request $request)
    {


        try {
            $course = Course::findOrFail($id);
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'user' => $user,
                    'success' => false,
                    'code' => 401,
                    'message' => 'Unauthorized',
                ], Response::HTTP_UNAUTHORIZED);
            }

            // Check if the user is already enrolled
            if (CourseEnrollment::where('user_id', $user->user_id)->where('course_id', $id)->exists()) {
                return response()->json([
                    'success' => false,
                    'code' => 400,
                    'message' => 'Enrollment request already exists for this course',
                ], Response::HTTP_BAD_REQUEST);
            }
             $enrollment = CourseEnrollment::create([
                'course_id' => $id,
                'user_id' => $user->user_id,
                'max_students' => 10,
                'current_students' => 0,
                'status' => 'pending',
                'is_processing_enrollment' => true,
            ]);



            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Enrollment request submitted successfully. Awaiting approval.',
            ], Response::HTTP_OK);
        } catch (Throwable $th) {
             if(isset($enrollment)){
                  $enrollment->update(['is_processing_enrollment' => false]);
               }

                return response()->json([
                    'success' => false,
                    'code' => 500,
                    'message' => 'Failed to enroll in the course',
                    'error' => $th->getMessage(),
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
