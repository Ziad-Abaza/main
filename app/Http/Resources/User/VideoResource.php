<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'video_id' => $this->video_id,
            'title' => $this->title,
            'description' => $this->description ?? '',
            'duration' => $this->formatDuration($this->duration),
            'order_in_course' => $this->order_in_course,
            'video_url' => $this->video_url ?? $this->getVideo(),
            'thumbnail' => $this->getThumbnail(),
            // 'video_url' => $this->getVideo(),
            'course' => $this->whenLoaded('course', function () {
                return [
                    'course_id' => $this->course->course_id,
                    'title' => $this->course->title,
                ];
            }),
            'is_have_question' => $this->whenLoaded('questions', function () {
                return $this->questions->isNotEmpty();
            }),
            'user_progress' => $this->whenLoaded('userVideoProgress', function () {
                $progress = optional($this->userVideoProgress)->first();
                return $progress ? [
                    'is_completed' => (bool)$progress->is_completed,
                    'last_watched_time' => $progress->last_watched_time,
                ] : null;
            }),
        ];
    }

    private function formatDuration($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $remainingSeconds = $seconds % 60;

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $remainingSeconds);
        } else {
            return sprintf('%02d:%02d', $minutes, $remainingSeconds);
        }
    }
}
