<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseProgressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_course_id' => $this->user_course_id,
            'course_id' => $this->course_id,
            'completion_percentage' => round($this->completion_percentage, 2),
            'last_accessed' => $this->last_accessed,

            'course' => [
                'course_id' => optional($this->course)->course_id,
                'title' => optional($this->course)->title,
                'description' => optional($this->course)->description,
                'thumbnail_url' => optional($this->course)->thumbnail_url,

                'instructor' => [
                    'user_id' => optional(optional($this->course)->instructor)->user_id,
                    'name' => optional(optional($this->course)->instructor)->name,
                ],

                'category' => [
                    'category_id' => optional(optional($this->course)->category)->category_id,
                    'category_name' => optional(optional($this->course)->category)->category_name,
                ],
            ],

            'video_progress' => $this->userVideoProgress->map(function ($progress) {
                return [
                    'video_id' => $progress->video_id,
                    'completed_at' => $progress->completed_at,
                    'progress_seconds' => $progress->progress_seconds,
                    'video' => [
                        'title' => optional($progress->video)->title,
                        'order_in_course' => optional($progress->video)->order_in_course,
                    ]
                ];
            })
        ];
    }
}
