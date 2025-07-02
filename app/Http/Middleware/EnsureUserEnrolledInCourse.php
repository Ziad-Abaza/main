<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserEnrolledInCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $courseId = $request->route('courseId') ?? $request->input('course_id');

        if (!$courseId) {
            return response()->json([
                'success' => false,
                'message' => 'Course ID is required.',
            ], 400);
        }

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required.',
            ], 401);
        }

        $user = Auth::user();
        /**
         * @var \App\Models\User $user
         */
        if (!$user->isEnrolledIn($courseId)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not enrolled in this course.',
            ], 403);
        }

        return $next($request);
    }
}
