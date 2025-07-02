<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use App\Http\Resources\User\AssignmentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class SubmissionController extends Controller
{
    public function index(Assignment $assignment)
    {
        // Ensure instructor owns assignment
        $this->authorizeInstructor($assignment);

        $submissions = $assignment->submissions()->with('user:user_id,name')->latest()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $submissions
        ]);
    }

    public function show(Assignment $assignment, Submission $submission)
    {
        $this->authorizeInstructor($assignment, $submission);

        $submission->load('user:user_id,name');

        return response()->json([
            'success' => true,
            'data' => $submission
        ]);
    }

    public function update(Request $request, Assignment $assignment, Submission $submission)
    {
        $this->authorizeInstructor($assignment, $submission);

        $validated = $request->validate([
            'grade' => 'nullable|numeric|min:0|max:100',
            'feedback' => 'nullable|string|max:1000',
            'file' => 'nullable|file|max:10240'
        ]);

        if ($request->hasFile('file')) {
            if ($submission->feedback_file_path) {
                Storage::disk('assignments')->delete($submission->feedback_file_path);
            }
            $file = $request->file('file');
            $filename = uniqid().'_feedback_'.$file->getClientOriginalName();
            $path = $file->storeAs('feedback', $filename, 'assignments');
            $submission->feedback_file_path = $path;
        }

        $submission->grade = $validated['grade'] ?? $submission->grade;
        $submission->feedback = $validated['feedback'] ?? $submission->feedback;
        $submission->save();

        return response()->json([
            'success' => true,
            'message' => 'Submission graded successfully',
            'data' => $submission
        ]);
    }

    private function authorizeInstructor(Assignment $assignment, Submission $submission = null)
    {
        $instructorId = Auth::user()->user_id;
        if ($assignment->instructor_id !== $instructorId) {
            abort(403, 'Unauthorized');
        }
        if ($submission && $submission->assignment_id !== $assignment->id) {
            abort(404, 'Submission not found');
        }
    }
}
