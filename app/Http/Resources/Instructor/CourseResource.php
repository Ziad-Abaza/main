<?php

namespace App\Http\Resources\Instructor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'course_id' => $this->course_id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'thumbnail_url' => $this->thumbnail_url,
            'is_published' => $this->is_published,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'instructor' => [
                'user_id' => optional($this->instructor)->user_id,
                'name' => optional($this->instructor)->name,
            ],

            'category' => [
                'category_id' => optional($this->category)->category_id,
                'category_name' => optional($this->category)->category_name,
            ],

            'videos_count' => $this->videos_count,

            'videos' => $this->whenLoaded('videos', function () {
                return $this->videos->map(function ($video) {
                    return [
                        'video_id' => $video->video_id,
                        'title' => $video->title,
                        'duration' => $video->duration,
                        'created_at' => $video->created_at,
                        'video_url' =>  $video->getVideo('video') ?? null,
                    ];
                })->sortBy('order_in_course')->values();
            }),
        ];
    }
}
