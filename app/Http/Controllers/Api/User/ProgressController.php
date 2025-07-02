<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\UserCourseProgress;
use App\Models\Video;
use App\Models\UserVideoProgress;
use App\Http\Resources\User\CourseProgressResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Throwable;

class ProgressController extends Controller
{
    /**
     * Display a listing of courses the authenticated user is enrolled in.
     */
    public function enrolledCourses(Request $request)
    {
        try {
            $user = Auth::user();

            $enrolledCourses = UserCourseProgress::where('user_id', $user->id)
                ->with([
                    'course:course_id,title,description,category_id,instructor_id',
                    'course.category:category_id,category_name',
                    'course.instructor:user_id,name'
                ])
                ->orderBy('last_accessed', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'code' => 200,
                'data' => CourseProgressResource::collection($enrolledCourses->items()),
                'pagination' => [
                    'current_page' => $enrolledCourses->currentPage(),
                    'per_page' => $enrolledCourses->perPage(),
                    'total' => $enrolledCourses->total(),
                    'last_page' => $enrolledCourses->lastPage()
                ]
            ], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Failed to retrieve enrolled courses',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the authenticated user's progress for a specific course, including video progress.
     */
    public function courseProgress(Request $request, Course $course)
    {
        try {
            $user = Auth::user();

            $courseProgress = UserCourseProgress::where('user_id', $user->id)
                ->where('course_id', $course->course_id)
                ->with([
                    'course:id,title',
                    'userVideoProgress' => function ($query) {
                        $query->with('video:id,title,order_in_course');
                    }
                ])->first();

            if (!$courseProgress) {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'You are not enrolled in this course or no progress found.',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'code' => 200,
                'data' => new CourseProgressResource($courseProgress),
            ], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Failed to retrieve course progress',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mark a video as completed for the authenticated user and update course progress.
     */
    public function markVideoComplete(Request $request, Video $video)
    {
        try {
            $user = Auth::user();
            $course = $video->course;

            if (!$course) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Video does not belong to a course.',
                ], Response::HTTP_BAD_REQUEST);
            }

            // Check enrollment
            $userCourseProgress = UserCourseProgress::where('user_id', $user->user_id)
                ->where('course_id', $course->course_id)
                ->first();

            if (!$userCourseProgress) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'You are not enrolled in this course.',
                ], Response::HTTP_FORBIDDEN);
            }

            DB::beginTransaction();

            // Mark video as complete
            $videoProgress = UserVideoProgress::updateOrCreate(
                [
                    'user_id' => $user->user_id,
                    'video_id' => $video->video_id,
                ],
                [
                    'course_id' => $course->course_id,
                    'completed_at' => now(),
                    'progress_seconds' => $video->duration,
                ]
            );

            // Recalculate completion percentage
            $completedVideosCount = UserVideoProgress::where('user_id', $user->user_id)
                ->where('course_id', $course->course_id)
                ->whereNotNull('completed_at')
                ->count();

            $totalVideosInCourse = $course->videos()->count();

            $completionPercentage = $totalVideosInCourse > 0
                ? ($completedVideosCount / $totalVideosInCourse) * 100
                : 0;

            $userCourseProgress->update([
                'completion_percentage' => $completionPercentage,
                'last_accessed' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'message' => 'Video marked as complete.',
                'data' => new CourseProgressResource($userCourseProgress->fresh()),
            ], Response::HTTP_OK);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to mark video as complete.',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
