<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Subscription;
use App\Models\UserCourseProgress;
use App\Models\CourseEnrollment;
use App\Models\CoursePricing;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        if(!Auth::check() || !Auth::user()->hasRole('instructor')) {
            return redirect()->route('dashboard.login')->with('error', 'You must be logged in to access the dashboard.');
        }

        $instructorId = Auth::id();

        $totalCourses = Course::where('instructor_id', $instructorId)->count();

        $totalStudents = Subscription::whereIn('course_id', function ($query) use ($instructorId) {
            $query->select('course_id')->from('courses')->where('instructor_id', $instructorId);
        })->distinct('user_id')->count('user_id');

        $statusStats = Course::where('instructor_id', $instructorId)
            ->join('course_details', 'courses.course_id', '=', 'course_details.course_id')
            ->selectRaw('course_details.status, count(*) as count')
            ->groupBy('course_details.status')
            ->pluck('count', 'status')->toArray();

            $totalEarnings = 0;

            $courses = Course::with(['subscriptions', 'pricing'])
                ->where('instructor_id', $instructorId)
                ->get();

            foreach ($courses as $course) {
                $finalPrice = $course->pricing?->getFinalPrice() ?? 0;
                $subscriptionCount = $course->subscriptions->count();
                $totalEarnings += $finalPrice * $subscriptionCount;
            }

        $availableSeats = CourseEnrollment::whereIn('course_id', function ($query) use ($instructorId) {
            $query->select('course_id')->from('courses')->where('instructor_id', $instructorId);
        })->whereColumn('current_students', '<', 'max_students')->count();

        $latestCourses = Course::with('details')
            ->where('instructor_id', $instructorId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentSubscriptions = Subscription::whereIn('course_id', function ($query) use ($instructorId) {
            $query->select('course_id')->from('courses')->where('instructor_id', $instructorId);
        })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $pendingEnrollments = CourseEnrollment::whereHas('course', function ($query) use ($instructorId) {
            $query->where('instructor_id', $instructorId);
        })
            ->where('status', 'pending')
            ->with('user', 'course')
            ->get();

        return view('instructor.dashboard', compact(
            'totalCourses',
            'totalStudents',
            'totalEarnings',
            'availableSeats',
            'statusStats',
            'latestCourses',
            'recentSubscriptions',
            'pendingEnrollments'
        ));
    }
}
