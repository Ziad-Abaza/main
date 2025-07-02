<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use App\Http\Requests\Courses\StoreCourseRequest;
use App\Http\Requests\Courses\UpdateCourseRequest;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $courses = Course::with(['category', 'instructor'])->paginate($perPage);

            return view('dashboard.courses.index', compact('courses'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch courses');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = Category::all();
            $instructors = User::whereHas('roles', fn($q) => $q->where('name', 'instructor'))->get();

            return view('dashboard.courses.create', compact('categories', 'instructors'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to load course creation form');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $course = Course::create($validatedData);

            // Handle images
            if ($request->hasFile('image')) {
                $course->setImage($request->file('image'));
            }
            if ($request->hasFile('icon')) {
                $course->setIcon($request->file('icon'));
            }

            // Handle General Coupon
            if ($request->boolean('enable_coupon')) {
                $course->coupons()->create([
                    'code' => $request->coupon_code ?? null,
                    'discount_type' => $request->discount_type ?? 'general',
                    'discount_value' => $request->discount_value,
                    'max_uses' => $request->max_uses ?? 1,
                    'expires_at' => $request->expires_at
                ]);
            }

            return redirect()->route('dashboard.courses.index')->with('success', 'Course created successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to create course');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        try {
            $categories = Category::all();
            $instructors = User::whereHas('roles', fn($q) => $q->where('name', 'instructor'))->get();

            // Get existing general coupon
            $generalCoupon = $course->coupons()->where('discount_type', 'general')->first();

            return view('dashboard.courses.edit', compact('course', 'categories', 'instructors', 'generalCoupon'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to load course edit form');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        try {
            $validatedData = $request->validated();
            $course->update($validatedData);

            // Handle images
            if ($request->hasFile('image')) {
                $course->setImage($request->file('image'));
            }
            if ($request->hasFile('icon')) {
                $course->setIcon($request->file('icon'));
            }

            // Handle General Coupon
            if ($request->boolean('enable_coupon')) {
                $couponData = [
                    'code' => $request->coupon_code,
                    'discount_value' => $request->discount_value,
                    'discount_type' => 'general',
                    'max_uses' => $request->max_uses ?? 1,
                    'expires_at' => $request->expires_at
                ];

                if ($request->filled('coupon_id')) {
                    $course->coupons()
                        ->where('coupon_id', $request->coupon_id)
                        ->update($couponData);
                } else {
                    $course->coupons()->create($couponData);
                }
            } else {
                // Delete existing general coupon if disabled
                $course->coupons()->where('discount_type', 'general')->delete();
            }

            return redirect()->route('dashboard.courses.index')->with('success', 'Course updated successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to update course');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $course->deleteImage();
            $course->deleteIcon();
            $course->delete();

            return redirect()->route('dashboard.courses.index')->with('success', 'Course deleted successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to delete course');
        }
    }
}
