<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class AssignmentController extends Controller
{
    /**
     * Display a listing of assignments for the current course and instructor.
     */
    public function index(Course $course)
    {
        try {
            // Ensure the course belongs to the instructor
            if ($course->instructor_id !== Auth::user()->user_id) {
                abort(403, 'Unauthorized access to this course');
            }

            $assignments = $course->assignments()
                ->where('instructor_id', Auth::user()->user_id)
                ->latest()
                ->get();

            return view('instructor.assignments.index', compact('course', 'assignments'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load assignments');
        }
    }

    /**
     * Show form to create a new assignment.
     */
    public function create(Course $course)
    {
        try {
            if ($course->instructor_id !== Auth::user()->user_id) {
                abort(403, 'Unauthorized access to this course');
            }

            return view('instructor.assignments.create', compact('course'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load create form');
        }
    }

    /**
     * Store a new assignment.
     */
    public function store(Request $request, Course $course)
    {
        try {
            if ($course->instructor_id !== Auth::user()->user_id) {
                abort(403, 'Unauthorized access to this course');
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'due_date' => 'required|date|after:now',
                'attachment' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv|max:10240', // Secure file types
            ]);

            $assignment = new Assignment([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'due_date' => $validated['due_date'],
                'instructor_id' => Auth::user()->user_id,
                'course_id' => $course->course_id
            ]);

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');

                // Generate unique safe filename
                $filename = uniqid() . '_' . sha1($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('', $filename, 'assignments');

                $assignment->attachment_path = $path;
            }

            $assignment->save();

            return redirect()
                ->route('dashboard.courses.assignments.index', $course)
                ->with('success', 'Assignment created successfully');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to create assignment');
        }
    }

    /**
     * Show edit form for an assignment.
     */
    public function edit(Course $course, Assignment $assignment)
    {
        try {
            if ($course->instructor_id !== Auth::user()->user_id || $assignment->instructor_id !== Auth::user()->user_id) {
                abort(403, 'Unauthorized access to this assignment');
            }

            return view('instructor.assignments.edit', compact('course', 'assignment'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load edit form');
        }
    }

    /**
     * Update an existing assignment.
     */
    public function update(Request $request, Course $course, Assignment $assignment)
    {
        try {
            if ($course->instructor_id !== Auth::user()->user_id || $assignment->instructor_id !== Auth::user()->user_id) {
                abort(403, 'Unauthorized access to this assignment');
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'due_date' => 'required|date|after:now',
                'attachment' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv|max:10240',
            ]);

            $assignment->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'due_date' => $validated['due_date']
            ]);

            if ($request->hasFile('attachment')) {
                // Delete old attachment if exists
                if ($assignment->attachment_path) {
                    Storage::disk('assignments')->delete($assignment->attachment_path);
                }

                $file = $request->file('attachment');
                $filename = uniqid() . '_' . sha1($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('', $filename, 'assignments');

                $assignment->update(['attachment_path' => $path]);
            }

            return redirect()
                ->route('dashboard.courses.assignments.index', $course)
                ->with('success', 'Assignment updated successfully');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to update assignment');
        }
    }

    /**
     * Delete an assignment.
     */
    public function destroy(Course $course, Assignment $assignment)
    {
        try {
            if ($course->instructor_id !== Auth::user()->user_id || $assignment->instructor_id !== Auth::user()->user_id) {
                abort(403, 'Unauthorized access to this assignment');
            }

            if ($assignment->attachment_path) {
                Storage::disk('assignments')->delete($assignment->attachment_path);
            }

            $assignment->delete();

            return redirect()
                ->route('dashboard.courses.assignments.index', $course)
                ->with('success', 'Assignment deleted successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to delete assignment');
        }
    }
}
