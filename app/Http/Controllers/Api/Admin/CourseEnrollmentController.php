<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseEnrollmentController extends Controller
{
    /**
     * Display a listing of pending course enrollments.
     */
    public function index()
    {
        $enrollments = CourseEnrollment::where('status', 'pending')
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

        $enrollment->status = 'rejected';
        $enrollment->save();

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Enrollment rejected successfully.',
        ], Response::HTTP_OK);
    }
}
