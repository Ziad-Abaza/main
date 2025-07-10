<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\CourseDetail;
use App\Models\CoursePricing;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage_courses']);
    }
    /**
     * Display a listing of the instructor's courses.
     */
    public function index()
    {
        $instructorId = auth::id();

        $courses = Course::with([
            'category',
            'details',
            'pricing',
            'enrollment'
        ])->where('instructor_id', $instructorId)->paginate(10);

        return view('instructor.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $categories = Category::all();
        return view('instructor.courses.create', compact('categories'));
    }

    /**
     * Store a newly created course in storage.
     */


    public function store(Request $request)
    {
        Log::debug('Start storing new course', $request->all());

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,category_id',
            'level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|in:ar,en,fr',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|lt:price',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after:discount_start',
            'max_students' => 'required|integer|min:1',
            'total_duration' => 'required|integer|min:1',
            'objectives' => 'required|string',
            'prerequisites' => 'nullable|string',
            'content' => 'required|string',
            'course_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'course_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'course_status' => 'nullable|in:available,upcoming,suspended',
        ]);

        try {
            $course = Course::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'instructor_id' => auth::id(),
            ]);

            Log::debug('Course created', ['course_id' => $course->course_id]);

            if ($request->hasFile('course_image')) {
                $course->setImage($request->file('course_image'));
            }

            if ($request->hasFile('course_icon')) {
                $course->setIcon($request->file('course_icon'));
            }

            $totalDurationMinutes = (int) round($request->total_duration * 60);

            CourseDetail::create([
                'detail_id' => Str::uuid(),
                'course_id' => $course->course_id,
                'level' => $request->level,
                'language' => $request->language,
                'status' => $request->input('course_status', 'available'),
                'objectives' => $request->objectives,
                'prerequisites' => $request->prerequisites,
                'content' => $request->content,
                'total_duration' => $totalDurationMinutes,
            ]);

            Log::debug('CourseDetail created', [
                'course_id' => $course->course_id,
                'level' => $request->level,
            ]);

            $dataCoursePricing = [
                'course_id' => $course->course_id,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
            ];

            if (!empty($request->discount_start)) {
                $dataCoursePricing['discount_start'] = $request->discount_start;
            }

            if (!empty($request->discount_end)) {
                $dataCoursePricing['discount_end'] = $request->discount_end;
            }

            CoursePricing::create($dataCoursePricing);


            Log::debug('CoursePricing created', ['course_id' => $course->course_id]);

            CourseEnrollment::create([
                'course_id' => $course->course_id,
                'max_students' => $request->max_students,
                'current_students' => 0,
            ]);

            Log::debug('CourseEnrollment created', ['course_id' => $course->course_id]);

            return redirect()->route('dashboard.courses.index')
                ->with('success', 'Course created successfully');
        } catch (\Exception $e) {
            Log::error('Error while storing course', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Something went wrong. Please check logs.']);
        }
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        return view('instructor.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        $categories = Category::all();
        return view('instructor.courses.edit', compact('course', 'categories'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        Log::info('Start update course', ['course_id' => $course->course_id, 'request' => $request->all()]);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,category_id',
            'level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|in:ar,en,fr',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|lt:price',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after:discount_start',
            'max_students' => 'required|integer|min:1',
            'total_duration' => 'required|integer|min:1',
            'objectives' => 'required|string',
            'prerequisites' => 'nullable|string',
            'content' => 'required|string',
            'course_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'course_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'course_status' => 'nullable|in:available,upcoming,suspended',
        ]);
        Log::info('Validation passed');

        $updated = $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);
        Log::info('Course updated', ['updated' => $updated, 'course' => $course->toArray()]);

        if ($request->hasFile('course_image')) {
            $course->setImage($request->file('course_image'));
            Log::info('Course image updated');
        } else {
            Log::info('No course image uploaded');
        }

        if ($request->hasFile('course_icon')) {
            $course->setIcon($request->file('course_icon'));
            Log::info('Course icon updated');
        } else {
            Log::info('No course icon uploaded');
        }

        $detailsUpdated = $course->details()->update([
            'level' => $request->level,
            'language' => $request->language,
            'objectives' => $request->objectives,
            'prerequisites' => $request->prerequisites,
            'content' => $request->content,
            'total_duration' => (int) round($request->total_duration * 60),
            'status' => $request->input('course_status', 'available'),
        ]);
        Log::info('Course details updated', ['updated' => $detailsUpdated]);

        $dataCoursePricing = [
            'course_id' => $course->course_id,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
        ];

        if (!empty($request->discount_start)) {
            $dataCoursePricing['discount_start'] = $request->discount_start;
        }

        if (!empty($request->discount_end)) {
            $dataCoursePricing['discount_end'] = $request->discount_end;
        }

        $pricingUpdated = $course->pricing()->update($dataCoursePricing);
        Log::info('Course pricing updated', ['updated' => $pricingUpdated, 'data' => $dataCoursePricing]);

        $enrollmentUpdated = $course->enrollment()->update([
            'max_students' => $request->max_students,
        ]);
        Log::info('Course enrollment updated', ['updated' => $enrollmentUpdated]);

        Log::info('Finished update course');

        return redirect()->route('dashboard.courses.index')
            ->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('dashboard.courses.index')
            ->with('success', 'Course deleted successfully');
    }
}
