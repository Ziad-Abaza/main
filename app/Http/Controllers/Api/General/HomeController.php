<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Response;
use Throwable;
use App\Http\Resources\InstructorResource;
use Illuminate\Support\Facades\Log;
use App\Services\CacheService;

class HomeController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function index()
    {
        try {
            // 1. Featured Courses with Cache
            $featuredCourses = $this->cacheService->remember('featured_courses', function () {
                return Course::with(['category', 'videos'])
                    ->orderByDesc('created_at')
                    ->take(3)
                    ->get()
                    ->map(function ($course) {
                        return [
                            'course_id' => $course->course_id,
                            'title' => $course->title,
                            'description' => $course->description,
                            'instructor_name' => optional($course->instructor)->name ?? 'Unknown',
                            'category' => optional($course->category)->category_name ?? 'Uncategorized',
                            'video_count' => $course->videos()->count(),
                            'image' => $course->getImage(),
                        ];
                    });
            });

            // 2. Popular Categories with Cache
            $popularCategories = $this->cacheService->remember('popular_categories', function () {
                return Category::withCount('courses')
                    ->orderByDesc('courses_count')
                    ->take(4)
                    ->get()
                    ->map(function ($category) {
                        return [
                            'category_id' => $category->category_id,
                            'category_name' => $category->category_name,
                            'icon' => $category->getImage(),
                            'courses_count' => $category->courses_count,
                        ];
                    });
            });

            // 3. Top Instructors with Cache
            $topInstructors = $this->cacheService->remember('top_instructors', function () {
                return User::whereHas('instructorProfile')
                    ->with('instructorProfile')
                    ->take(3)
                    ->get()
                    ->map(function ($user) {
                        $profile = $user->instructorProfile;
                        return new InstructorResource($profile);
                    });
            });

            // 4. Limited Time Offers with Cache
            $deals = $this->cacheService->remember('limited_time_offers', function () {
                return Course::whereHas('pricing', function ($query) {
                    $query->where('discount_price', '>', 0)
                        ->whereNotNull('discount_start')
                        ->whereNotNull('discount_end')
                        ->where('discount_start', '<=', now())
                        ->where('discount_end', '>=', now());
                })
                    ->with(['pricing', 'instructor'])
                    ->join('course_pricings', 'courses.course_id', '=', 'course_pricings.course_id')
                    ->select('courses.*')
                    ->orderByDesc('course_pricings.discount_price')
                    ->take(3)
                    ->get()
                    ->map(function ($course) {
                        $pricing = $course->pricing;
                        return [
                            'course_id' => $course->course_id,
                            'title' => $course->title,
                            'category' => optional($course->category)->category_name ?? 'Uncategorized',
                            'instructor_name' => optional($course->instructor)->name ?? 'Unknown',
                            'original_price' => $pricing?->price ?? 0,
                            'discounted_price' => $pricing?->getFinalPrice() ?? 0,
                            'coupon_code' => null,
                            'discount_type' => $pricing?->discount_price ? 'percentage' : null,
                            'discount_value' => $pricing?->discount_price ?? null,
                            'image' => $course->getImage(),
                            'timeLeft' => $pricing?->getTimeLeft(),
                            'enrollments' => $course->enrollment?->total_enrollments ?? 0,
                            'discount' => $pricing?->discount_price ?? 0,
                        ];
                    });
            });

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'data' => [
                    'featured_courses' => $featuredCourses,
                    'popular_categories' => $popularCategories,
                    'top_instructors' => $topInstructors,
                    'limited_time_offers' => $deals,
                ]
            ], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to retrieve homepage data',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
