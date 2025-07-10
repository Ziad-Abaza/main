<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Http\Resources\User\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Services\CacheService;

class CourseController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Display a listing of the current authenticated user's courses with caching.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            // Generate unique cache key based on user ID and request parameters
            $cacheKey = 'user_courses_' . $user->user_id . '_' . md5($request->fullUrl());

            return $this->cacheService->remember($cacheKey, function () use ($request, $user) {
                $query = Course::with([
                    'category',
                    'instructor:user_id,name',
                    'videos',
                    'details',
                    'pricing',
                    'enrollment',
                    'assignments' => function ($query) use ($user) {
                        $query->with(['submissions' => function ($q) use ($user) {
                            $q->where('user_id', $user->user_id);
                        }]);
                    }
                ])
                    ->whereHas('userCourseProgress', function ($q) use ($user) {
                        $q->where('user_id', $user->user_id);
                    })
                    ->withCount('videos');

                // Apply filters
                if ($request->has('search') && !empty($request->search)) {
                    $searchTerm = $request->search;
                    $query->where('title', 'like', "%{$searchTerm}%");
                }

                if ($request->has('category_id') && !empty($request->category_id)) {
                    $query->where('category_id', $request->category_id);
                }

                if ($request->has('instructor_id') && !empty($request->instructor_id)) {
                    $query->where('instructor_id', $request->instructor_id);
                }

                $query->orderBy('created_at', 'desc');

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
            });
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Failed to retrieve user courses',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
