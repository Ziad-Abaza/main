<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Submission;
use App\Http\Resources\User\AssignmentResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class AssignmentController extends Controller
{
    /**
     * Get all assignments for a specific course
     */
    public function index(Course $course)
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        // Check if user is enrolled in the course
        $isEnrolled = $authUser->userCourseProgress()
            ->where('course_id', $course->course_id)
            ->exists();

        if (!$isEnrolled) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_FORBIDDEN,
                'message' => 'You must be enrolled in the course to view assignments.',
            ], Response::HTTP_FORBIDDEN);
        }

        $assignments = $course->assignments()
            ->with(['submissions' => function ($query) use ($authUser) {
                $query->where('user_id', $authUser->user_id);
            }])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'code' => Response::HTTP_OK,
            'data' => AssignmentResource::collection($assignments)
        ]);
    }

    /**
     * Get a specific assignment
     */
    public function show(Assignment $assignment)
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        // Check if user is enrolled in the course related to this assignment
        $isEnrolled = $authUser->userCourseProgress()
            ->where('course_id', $assignment->course_id)
            ->exists();

        if (!$isEnrolled) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_FORBIDDEN,
                'message' => 'You must be enrolled in the course to view this assignment.',
            ], Response::HTTP_FORBIDDEN);
        }

        $assignment->load([
            'course:course_id,title',
            'submissions' => function ($query) use ($authUser) {
                $query->where('user_id', $authUser->user_id);
            }
        ]);

        return response()->json([
            'success' => true,
            'code' => Response::HTTP_OK,
            'data' => new AssignmentResource($assignment)
        ]);
    }

    /**
     * Submit an assignment
     */
    public function submit(Request $request, Assignment $assignment)
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        // Check if user is enrolled in the course
        $isEnrolled = $authUser->userCourseProgress()
            ->where('course_id', $assignment->course_id)
            ->exists();

        if (!$isEnrolled) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_FORBIDDEN,
                'message' => 'You must be enrolled in the course to submit assignments.',
            ], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'comment'  => 'nullable|string|max:500',
            'file'     => 'required|file|max:10240', // 10MB max
        ]);

        // Check for existing submission
        $existingSubmission = $assignment->submissions()
            ->where('user_id', $authUser->user_id)
            ->first();

        if ($existingSubmission) {
            // Delete old file if exists
            if ($existingSubmission->file_path) {
                Storage::disk('assignments')->delete($existingSubmission->file_path);
            }
            $submission = $existingSubmission;
        } else {
            $submission = new Submission([
                'user_id' => $authUser->user_id,
                'assignment_id' => $assignment->id,
            ]);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = uniqid() . '_submission_' . $file->getClientOriginalName();
            $path = $file->storeAs('submissions', $filename, 'assignments');
            $submission->file_path = $path;
        }

        $submission->comment = $request->comment;

        $submission->save();

        return response()->json([
            'success' => true,
            'message' => 'Assignment submitted successfully',
            'data' => new AssignmentResource($assignment->load('submissions')),
        ]);
    }

    /**
     * Get all assignments for the authenticated user across all enrolled courses
     */
    public function getAllAssignments(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get all courses the user is enrolled in
        $enrolledCourseIds = $user->userCourseProgress()
            ->pluck('course_id');

        // Get assignments for all enrolled courses
        $assignments = Assignment::whereIn('course_id', $enrolledCourseIds)
            ->with(['course:course_id,title', 'submissions' => function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            }])
            ->when($request->has('status'), function ($query) use ($request) {
                if ($request->status === 'pending') {
                    return $query->whereDoesntHave('submissions', function ($q) {
                        $q->where('user_id', Auth::user()->user_id);
                    })->where('due_date', '>', now());
                } elseif ($request->status === 'submitted') {
                    return $query->whereHas('submissions', function ($q) {
                        $q->where('user_id', Auth::user()->user_id);
                    });
                } elseif ($request->status === 'overdue') {
                    return $query->whereDoesntHave('submissions', function ($q) {
                        $q->where('user_id', Auth::user()->user_id);
                    })->where('due_date', '<', now());
                } elseif ($request->status === 'unsubmitted') {
                    return $query->whereDoesntHave('submissions', function ($q) {
                        $q->where('user_id', Auth::user()->user_id);
                    });
                }
            })
            ->when($request->has('search'), function ($query) use ($request) {
                return $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->when($request->has('course_id'), function ($query) use ($request) {
                return $query->where('course_id', $request->course_id);
            })
            ->orderBy($request->input('sort_by', 'due_date'), $request->input('sort_order', 'asc'))
            ->paginate($request->input('per_page', 10));

        return response()->json([
            'success' => true,
            'code' => Response::HTTP_OK,
            'data' => AssignmentResource::collection($assignments),
            'pagination' => [
                'current_page' => $assignments->currentPage(),
                'per_page' => $assignments->perPage(),
                'total' => $assignments->total(),
                'last_page' => $assignments->lastPage(),
            ]
        ]);
    }

    /**
     * Download assignment attachment
     */
    public function downloadAttachment(Assignment $assignment)
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        // Check if user is enrolled in the course
        $isEnrolled = $authUser->userCourseProgress()
            ->where('course_id', $assignment->course_id)
            ->exists();

        if (!$isEnrolled) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_FORBIDDEN,
                'message' => 'You must be enrolled in the course to download assignments.',
            ], Response::HTTP_FORBIDDEN);
        }

        if (!$assignment->attachment_path) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'No attachment found for this assignment.',
            ], Response::HTTP_NOT_FOUND);
        }

        $filePath = Storage::disk('assignments')->path($assignment->attachment_path);
        return response()->download($filePath);
    }

    /**
     * Download submission file
     */
    public function downloadSubmission(Assignment $assignment, Submission $submission)
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        // Check if user is enrolled in the course
        $isEnrolled = $authUser->userCourseProgress()
            ->where('course_id', $assignment->course_id)
            ->exists();

        if (!$isEnrolled) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_FORBIDDEN,
                'message' => 'You must be enrolled in the course to download submissions.',
            ], Response::HTTP_FORBIDDEN);
        }

        // Check if submission belongs to the assignment and user
        if ($submission->assignment_id !== $assignment->id || $submission->user_id !== $authUser->user_id) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_FORBIDDEN,
                'message' => 'You do not have permission to download this submission.',
            ], Response::HTTP_FORBIDDEN);
        }

        if (!$submission->file_path) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'No file found for this submission.',
            ], Response::HTTP_NOT_FOUND);
        }

        $filePath = Storage::disk('assignments')->path($submission->file_path);
        return response()->download($filePath);
    }

    /**
     * View assignment attachment (for supported file types)
     */
    public function viewAttachment(Assignment $assignment)
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        // Check if user is enrolled in the course
        $isEnrolled = $authUser->userCourseProgress()
            ->where('course_id', $assignment->course_id)
            ->exists();

        if (!$isEnrolled) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_FORBIDDEN,
                'message' => 'You must be enrolled in the course to view assignments.',
            ], Response::HTTP_FORBIDDEN);
        }

        if (!$assignment->attachment_path) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'No attachment found for this assignment.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Get file extension
        $extension = pathinfo($assignment->attachment_path, PATHINFO_EXTENSION);

        // Define viewable file types
        $viewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif'];

        if (!in_array(strtolower($extension), $viewableTypes)) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'This file type cannot be viewed in browser. Please download it instead.',
            ], Response::HTTP_BAD_REQUEST);
        }

        $filePath = Storage::disk('assignments')->path($assignment->attachment_path);
        return response()->file($filePath);
    }

    /**
     * Update existing submission (replace file/comment) before graded or deadline
     */
    public function updateSubmission(Request $request, Assignment $assignment)
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $submission = $assignment->submissions()->where('user_id', $authUser->user_id)->firstOrFail();

        // cannot edit after graded or deadline
        if ($submission->grade !== null || $assignment->due_date->isPast()) {
            return response()->json(['success'=>false,'message'=>'Cannot edit after grading or deadline'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'comment' => 'nullable|string|max:500',
            'file'    => 'required|file|max:10240'
        ]);

        // replace existing file
        if ($submission->file_path) {
            Storage::disk('assignments')->delete($submission->file_path);
        }
        $file = $request->file('file');
        $filename = uniqid().'_submission_'.$file->getClientOriginalName();
        $path = $file->storeAs('submissions', $filename, 'assignments');
        $submission->file_path = $path;
        $submission->comment = $request->comment;
        $submission->save();

        return response()->json(['success'=>true,'data'=> new AssignmentResource($assignment->fresh('submissions'))]);
    }

    /**
     * Delete submission before graded or deadline
     */
    public function destroySubmission(Assignment $assignment)
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();
        $submission = $assignment->submissions()->where('user_id', $authUser->user_id)->firstOrFail();
        if ($submission->grade !== null || $assignment->due_date->isPast()) {
            return response()->json(['success'=>false,'message'=>'Cannot delete after grading or deadline'], Response::HTTP_FORBIDDEN);
        }
        if ($submission->file_path) {
            Storage::disk('assignments')->delete($submission->file_path);
        }
        $submission->delete();
        return response()->noContent();
    }
}
