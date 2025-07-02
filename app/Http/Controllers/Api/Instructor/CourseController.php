<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Http\Resources\Instructor\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Throwable;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses created by the authenticated instructor.
     */
    public function index(Request $request)
    {
        try {
            /** @var \App\Models\User $instructor */
            $instructor = Auth::user();

            // Build query
            $query = Course::where('instructor_id', $instructor->user_id)
                ->with(['category', 'videos'])
                ->withCount('videos');

            // 🔍 Search
            if ($request->has('search') && !empty($request->search)) {
                $query->where('title', 'like', '%' . $request->search . '%');
            }

            // 📂 Filter by category
            if ($request->has('category_id') && !empty($request->category_id)) {
                $query->where('category_id', $request->category_id);
            }

            // 📄 Pagination
            $perPage = $request->input('per_page', 10);
            $courses = $query->latest()->paginate($perPage);

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'data' => CourseResource::collection($courses->items()),
                'pagination' => [
                    'current_page' => $courses->currentPage(),
                    'per_page' => $courses->perPage(),
                    'total' => $courses->total(),
                    'last_page' => $courses->lastPage(),
                ],
            ], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to retrieve courses',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created course in storage, assigned to the authenticated instructor.
     */
    public function store(Request $request)
    {
        try {
            /** @var \App\Models\User $instructor */
            $instructor = Auth::user();

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255|unique:courses,title',
                'description' => 'required|string',
                'category_id' => 'required|uuid|exists:categories,category_id',
                'price' => 'nullable|numeric|min:0',
                'thumbnail_url' => 'nullable|url',
                'is_published' => 'sometimes|boolean',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $validatedData = $validator->validated();

            $course = Course::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'category_id' => $validatedData['category_id'],
                'instructor_id' => $instructor->user_id,
                'price' => $validatedData['price'] ?? 0.00,
                'thumbnail_url' => $validatedData['thumbnail_url'] ?? null,
                'is_published' => $validatedData['is_published'] ?? false,
                'slug' => Str::slug($validatedData['title']) . '-' . Str::lower(Str::random(6)),
            ]);

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_CREATED,
                'message' => 'Course created successfully',
                'data' => new CourseResource($course->load('category')),
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to create course',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified course if owned by the instructor.
     */
    public function show(Request $request, Course $course)
    {
        try {
            /** @var \App\Models\User $instructor */
            $instructor = Auth::user();

            if ($course->instructor_id !== $instructor->user_id) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'Unauthorized. You do not own this course.',
                ], Response::HTTP_FORBIDDEN);
            }

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'data' => new CourseResource($course->load(
                    'category',
                    'videos',
                    'instructor:user_id,name'
                )),
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to retrieve course details',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified course in storage if owned by the instructor.
     */
    public function update(Request $request, Course $course)
    {
        try {
            /** @var \App\Models\User $instructor */
            $instructor = Auth::user();

            if ($course->instructor_id !== $instructor->user_id) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'Unauthorized. You do not own this course.',
                ], Response::HTTP_FORBIDDEN);
            }

            $validator = Validator::make($request->all(), [
                'title' => "required|string|max:255|unique:courses,title," . $course->course_id . ",course_id",
                'description' => 'required|string',
                'category_id' => 'required|uuid|exists:categories,category_id',
                'price' => 'nullable|numeric|min:0',
                'thumbnail_url' => 'nullable|url',
                'is_published' => 'sometimes|boolean',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $validatedData = $validator->validated();
            $updateData = $validatedData;

            // Update slug if title changed
            if (isset($validatedData['title']) && $validatedData['title'] !== $course->title) {
                $updateData['slug'] = Str::slug($validatedData['title']) . '-' . Str::lower(Str::random(6));
            }

            $course->update($updateData);

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'message' => 'Course updated successfully',
                'data' => new CourseResource($course->load('category')),
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to update course',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified course from storage if owned by the instructor.
     */
    public function destroy(Request $request, Course $course)
    {
        try {
            /** @var \App\Models\User $instructor */
            $instructor = Auth::user();

            if ($course->instructor_id !== $instructor->user_id) {
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_FORBIDDEN,
                    'message' => 'Unauthorized. You do not own this course.',
                ], Response::HTTP_FORBIDDEN);
            }

            $course->delete();

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_NO_CONTENT,
                'message' => 'Course deleted successfully',
            ], Response::HTTP_NO_CONTENT);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to delete course',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
