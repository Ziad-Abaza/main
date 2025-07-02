<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Http\Resources\User\VideoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class VideoController extends Controller
{
    /**
     * Display a listing of videos for the given course.
     */
    public function index(Request $request, $courseId)
    {
        try {
            $user = Auth::user();

            /**
             * @var \App\Models\User $user
             */

            if($user->isEnrolledIn($courseId)){
            // Fetch videos with course, questions, and user progress
            $videos = Video::with([
                'course' => function ($query) {
                    return $query->select('course_id', 'title');
                },
                'questions.questionOptions',
                'userVideoProgress' => function ($query) use ($request) {
                    if ($request->user()) {
                        $query->where('user_id', $request->user()->id);
                    }
                }
            ])
                ->where('course_id', $courseId)
                ->orderBy('order_in_course')
                ->get();

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'data' => VideoResource::collection($videos),
                'course_title' => $videos->first() ? $videos->first()->course->title : null,
            ], Response::HTTP_OK);
            }else{
                return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'You are not enrolled in this course.',
                ]
                , Response::HTTP_UNAUTHORIZED);
            }
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to retrieve videos',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified video with next video info.
     */
    public function show(Request $request, $videoId)
    {
        try {
            $user = Auth::user();
            $courseId = Video::find($videoId)->course_id;
            /**
             * @var \App\Models\User $user
             */
            if($user->isEnrolledIn($courseId)){
            $video = Video::with([
                'course' => function ($query) {
                    $query->select('course_id', 'title');
                },
                'questions' => function ($query) {
                    $query->select('question_id', 'video_id', 'question_text', 'points');
                },
                'userVideoProgress' => function ($query) use ($request) {
                    if ($request->user()) {
                        $query->where('user_id', $request->user()->id)->select('video_id', 'user_id', 'is_completed', 'last_watched_time');
                    }
                }
            ])->find($videoId);

            if (!$video) {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'Video not found',
                ], Response::HTTP_NOT_FOUND);
            }

            // Get Next Video in Course
            $nextVideo = Video::where('course_id', $video->course_id)
                ->where('order_in_course', '>', $video->order_in_course)
                ->orderBy('order_in_course', 'asc')
                ->first(['video_id', 'title', 'duration', 'order_in_course']);

            return response()->json([
                'success' => true,
                'code' => Response::HTTP_OK,
                'data' => new VideoResource($video),
                'next_video' => $nextVideo ? [
                    'video_id' => $nextVideo->video_id,
                    'title' => $nextVideo->title,
                    'duration' => $nextVideo->duration,
                    'order_in_course' => $nextVideo->order_in_course,
                ] : null,
            ]);
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 403,
                    'message' => 'You are not enrolled in this course',
                    ], Response::HTTP_FORBIDDEN);
            }
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to retrieve video details',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
