<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstructorResource;
use App\Models\InstructorProfile;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = InstructorProfile::with('user.courses.enrollment')->get();

        return response()->json([
            'success' => true,
            'data' => InstructorResource::collection($instructors),
        ], 200);
    }

    public function show($instructor_profile_id)
    {
        $instructor = InstructorProfile::with('user.courses.enrollment')->findOrFail($instructor_profile_id);

        return response()->json([
            'success' => true,
            'data' => new InstructorResource($instructor),
        ], 200);
    }
}
