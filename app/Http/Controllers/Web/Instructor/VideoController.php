<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    /**
     * Display a listing of videos for a specific course.
     */
    public function index(Request $request, Course $course)
    {
        if ($course->instructor_id !== $request->user()->user_id) {
            return back()->with('error', 'You are not authorized to access this course.');
        }

        $videos = $course->videos()
            ->orderBy('order_in_course')
            ->paginate(10);

        $videos->loadCount('questions');


        return view('instructor.videos.index', compact('course', 'videos'));
    }

    /**
     * Display the specified video.
     */
    public function show(Course $course, Video $video, Request $request)
    {
        if ($course->instructor_id !== $request->user()->user_id) {
            return back()->with('error', 'You are not authorized to view this course.');
        }

        if ($video->course_id !== $course->course_id) {
            return back()->with('error', 'This video does not belong to the selected course.');
        }

        $video->loadCount('questions');

        return view('instructor.videos.show', compact('course', 'video'));
    }

    /**
     * Show the form for creating a new video.
     */
    public function create(Course $course, Request $request)
    {
        if ($course->instructor_id !== $request->user()->user_id) {
            return back()->with('error', 'You are not authorized to add videos to this course.');
        }
        $nextOrder = $this->getNextOrderNumber($course->course_id);

        return view('instructor.videos.create', compact('course', 'nextOrder'));
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(Request $request, Course $course)
    {
        if ($course->instructor_id !== $request->user()->user_id) {
            return back()->with('error', 'You are not authorized to add videos to this course.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'order_in_course' => ['nullable', 'integer'],
            'thumbnail' => ['nullable', 'image'],
            'video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/x-msvideo', 'max:102400'],
            'youtube_url' => ['nullable', 'url'],
        ]);

        try {
            $video = new Video();
            $video->title = $validated['title'];
            $video->description = $validated['description'] ?? null;
            $video->course_id = $course->course_id;

            $video->order_in_course = $validated['order_in_course'] ??
                $this->getNextOrderNumber($course->course_id);

            $video->save();

            if ($request->hasFile('thumbnail')) {
                $video->setThumbnail($request->file('thumbnail'));
            }

            if ($request->hasFile('video_file')) {
                $video->setVideoFile($request->file('video_file'));
            } elseif (!empty($validated['youtube_url'])) {
                $video->video_url = $validated['youtube_url'];
                $video->save();
            }

            return redirect()
                ->route('dashboard.courses.videos.index', $course)
                ->with('success', 'Video created successfully!');
        } catch (\Exception $e) {
            Log::error("Video creation failed: " . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Failed to create video. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified video.
     */
    public function edit(Course $course, Video $video, Request $request)
    {
        if ($course->instructor_id !== $request->user()->user_id) {
            return back()->with('error', 'You are not authorized to edit this video.');
        }

        if ($video->course_id !== $course->course_id) {
            return back()->with('error', 'This video does not belong to the selected course.');
        }

        return view('instructor.videos.edit', compact('course', 'video'));
    }

    /**
     * Update the specified video in storage.
     */
    public function update(Request $request, Course $course, Video $video)
    {
        if ($course->instructor_id !== $request->user()->user_id) {
            return back()->with('error', 'You are not authorized to edit this video.');
        }

        if ($video->course_id !== $course->course_id) {
            return back()->with('error', 'This video does not belong to the selected course.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'order_in_course' => ['nullable', 'integer'],
            'thumbnail' => ['nullable', 'image'],
            'video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/x-msvideo', 'max:102400'],
            'youtube_url' => ['nullable', 'url'],
        ]);

        try {
            $video->title = $validated['title'];
            $video->description = $validated['description'] ?? null;

            if (isset($validated['order_in_course'])) {
                $video->order_in_course = $validated['order_in_course'];
            }

            if (!empty($validated['youtube_url'])) {
                $video->video_url = $validated['youtube_url'];
            }

            $video->save();

            if ($request->hasFile('thumbnail')) {
                $video->setThumbnail($request->file('thumbnail'));
            }

            if ($request->hasFile('video_file')) {
                $video->setVideoFile($request->file('video_file'));
            }

            return redirect()
                ->route('dashboard.courses.videos.index', $course)
                ->with('success', 'Video updated successfully!');
        } catch (\Exception $e) {
            Log::error("Video update failed: " . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Failed to update video. Please try again.');
        }
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(Course $course, Video $video, Request $request)
    {
        if ($course->instructor_id !== $request->user()->user_id) {
            return back()->with('error', 'You are not authorized to delete this video.');
        }

        if ($video->course_id !== $course->course_id) {
            return back()->with('error', 'This video does not belong to the selected course.');
        }

        try {
            $video->delete();
            return redirect()
                ->route('dashboard.courses.videos.index', $course)
                ->with('success', 'Video deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Video deletion failed: " . $e->getMessage());
            return back()
                ->with('error', 'Failed to delete video. Please try again.');
        }
    }

    /**
     * Get the next order number for a course.
     */
    private function getNextOrderNumber(string $courseId): int
    {
        return Video::where('course_id', $courseId)->max('order_in_course') + 1;
    }
}
