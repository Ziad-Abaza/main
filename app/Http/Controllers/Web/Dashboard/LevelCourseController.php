<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class LevelCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage_levels']);
    }


    /**
     *  view the main page for linking courses to levels
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $levels = Level::with('courses')->paginate($perPage);

            return view('dashboard.level-course.index', compact('levels'));
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch data');
        }
    }

    /**
     * view the form for adding a course to a level
     */
    public function create()
    {
        try {
            $levels = Level::all();
            $courses = Course::all();

            return view('dashboard.level-course.create', compact('levels', 'courses'));
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to load create form');
        }
    }

    /**
     * Store the linked courses to a level
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'level_id' => ['required', Rule::exists('levels', 'level_id')],
            'course_ids' => ['required', 'array'],
            'course_ids.*' => [Rule::exists('courses', 'course_id')]
        ]);

        try {
            $level = Level::findOrFail($validated['level_id']);
            $level->courses()->syncWithoutDetaching($validated['course_ids']);

            return redirect()->route('console.level-courses.index')->with('success', 'linked courses successfully');
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to link courses');
        }
    }

    /**
     * view the courses linked to a specific level
     */
    public function show(Level $level)
    {
        $level->load('courses');

        return view('dashboard.level-course.show', compact('level'));
    }

    /**
     * view the form for editing the courses linked to a level
     */
    public function edit(Level $level)
    {
        $level->load('courses');
        $courses = Course::all();

        return view('dashboard.level-course.edit', compact('level', 'courses'));
    }

    /**
     *  Update the courses linked to a level
     */
    public function update(Request $request, Level $level)
    {
        $validated = $request->validate([
            'course_ids' => ['nullable', 'array'],
            'course_ids.*' => [Rule::exists('courses', 'course_id')]
        ]);

        try {
            $level->courses()->sync($validated['course_ids'] ?? []);

            // Dispatch a job to sync enrollments and progress for all students in this level
            \App\Jobs\SyncLevelStudentsJob::dispatch($level->level_id);

            return redirect()->route('console.level-courses.index')->with('success', 'Courses updated successfully');
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to update courses');
        }
    }

    /**
     * Remove a course from a level
     */
    public function destroy(Level $level, Course $course)
    {
        try {
            $level->courses()->detach($course->course_id);

            return redirect()->back()->with('success', 'Course removed successfully');
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to remove course');
        }
    }
}
