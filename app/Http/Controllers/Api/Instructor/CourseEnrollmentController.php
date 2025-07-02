<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CourseEnrollmentController extends Controller
{
    /**
     * Display a listing of pending course enrollments for the instructor's courses.
     */
    public function index()
    {
        $instructorId = Auth::user()->user_id;

        $enrollments = CourseEnrollment::whereHas('course', function ($query) use ($instructorId) {
            $query->where('instructor_id', $instructorId);
        })
            ->where('status', 'pending')
            ->with('course', 'course.instructor')
            ->get();

        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $enrollments,
        ], Response::HTTP_OK);
    }

    /**
     * Approve the specified enrollment.
     */
    public function approve(string $id)
    {
        $enrollment = CourseEnrollment::findOrFail($id);

        // Ensure the instructor owns the course
        if ($enrollment->course->instructor_id !== Auth::user()->user_id) {
            return response()->json([
                'success' => false,
                'code' => 403,
                'message' => 'Unauthorized to approve this enrollment.',
            ], Response::HTTP_FORBIDDEN);
        }

        $enrollment->status = 'approved';
        $enrollment->save();

        // Create UserCourseProgress record
        \App\Models\UserCourseProgress::create([
            'user_id' => $enrollment->user_id,
            'course_id' => $enrollment->course_id,
            'completion_percentage' => 0,
            'last_accessed' => now(),
        ]);

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Enrollment approved successfully.',
        ], Response::HTTP_OK);
    }

    /**
     * Reject the specified enrollment.
     */
    public function reject(string $id)
    {
        $enrollment = CourseEnrollment::findOrFail($id);

        // Ensure the instructor owns the course
        if ($enrollment->course->instructor_id !== Auth::user()->user_id) {
            return response()->json([
                'success' => false,
                'code' => 403,
                'message' => 'Unauthorized to reject this enrollment.',
            ], Response::HTTP_FORBIDDEN);
        }

        // Delete the enrollment record
        $enrollment->forceDelete();

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Enrollment rejected and record deleted successfully.',
        ], Response::HTTP_OK);
    }
}
