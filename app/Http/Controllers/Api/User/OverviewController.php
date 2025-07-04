<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Assignment;

class OverviewController extends Controller
{
    public function coursesStats(Request $request)
    {
        $user = Auth::user();
        $total = $user->enrolledCourses()->count();
        $completed = $user->enrolledCourses()->wherePivot('completion_percentage', 100)->count();
        $in_progress = $total - $completed;
        return response()->json([
            'total' => $total,
            'completed' => $completed,
            'in_progress' => $in_progress,
        ]);
    }

    public function assignmentsStats(Request $request)
    {
        $user = Auth::user();
        $total = \App\Models\Submission::where('user_id', $user->user_id)->count();
        $completed = \App\Models\Submission::where('user_id', $user->user_id)->whereNotNull('submitted_at')->count();
        $pending = $total - $completed;
        return response()->json([
            'total' => $total,
            'completed' => $completed,
            'pending' => $pending,
        ]);
    }

    public function graphData(Request $request)
    {
        $user = Auth::user();
        // Example: progress over time (dummy data, replace with real logic)
        $coursesProgress = [
            ['date' => '2024-06-01', 'progress' => 20],
            ['date' => '2024-06-05', 'progress' => 40],
            ['date' => '2024-06-10', 'progress' => 60],
            ['date' => '2024-06-15', 'progress' => 80],
            ['date' => '2024-06-20', 'progress' => 100],
        ];
        $assignmentsOverTime = [
            ['date' => '2024-06-01', 'completed' => 2],
            ['date' => '2024-06-05', 'completed' => 4],
            ['date' => '2024-06-10', 'completed' => 7],
            ['date' => '2024-06-15', 'completed' => 10],
            ['date' => '2024-06-20', 'completed' => 15],
        ];
        return response()->json([
            'coursesProgress' => $coursesProgress,
            'assignmentsOverTime' => $assignmentsOverTime,
        ]);
    }
}
