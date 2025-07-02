<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index()
    {
        $instructorId = auth::id();
        $assignments = Assignment::whereHas('instructorProfile', function($q) use ($instructorId) {
            $q->where('user_id', $instructorId);
        })->latest()->get();

        return response()->json(['success' => true, 'data' => $assignments]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'attachment' => 'nullable|file|mimes:pdf,docx',
            'due_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $data = $validator->validated();
        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('assignments');
        }
        $data['instructor_profile_id'] = auth::id();

        $assignment = Assignment::create($data);

        return response()->json(['success' => true, 'data' => $assignment]);
    }
}
