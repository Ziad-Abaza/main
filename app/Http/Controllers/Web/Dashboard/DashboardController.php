<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\UserCourseProgress;
use App\Models\UserVideoProgress;
use App\Models\QuizAttempt;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:view_console']);
    }

    /**
     * Show the admin dashboard with system overview and recent activity.
     */
    public function index(Request $request)
    {
        // Account Information
        $user = $request->user();

        // Quick Statistics
        $totalUsers = User::count();
        $activeCourses = Course::count();
        $pendingTasks = 3; // You can replace this with real logic if needed

        // Recent Courses
        $recentCourses = Course::with('instructor')
            ->latest()
            ->take(5)
            ->get();

        // Latest Registered Users
        $latestUsers = User::with('roles')
            ->latest()
            ->take(5)
            ->get();

        // Recent Activity - Example from database or logs
        $recentActivity = [
            [
                'icon' => 'person_add',
                'action' => 'New user registered: ' . ($latestUsers->first()?->name ?? 'John Doe'),
                'time' => now()->diffForHumans(),
            ],
            [
                'icon' => 'school',
                'action' => 'New course published: ' . ($recentCourses->first()?->title ?? 'Advanced Laravel'),
                'time' => now()->subHour()->diffForHumans(),
            ],
            [
                'icon' => 'edit',
                'action' => 'Updated category: Web Development',
                'time' => now()->subDays(2)->diffForHumans(),
            ],
        ];

        // System Overview Progress Bars
        $systemOverview = [
            'total_users' => $totalUsers,
            'active_courses' => $activeCourses,
            'pending_tasks' => $pendingTasks,
        ];

        return view('dashboard.dashboard', compact(
            'user',
            'systemOverview',
            'recentCourses',
            'latestUsers',
            'recentActivity'
        ));
    }
}
