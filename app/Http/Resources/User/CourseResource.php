<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\AssignmentResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'course_id' => $this->course_id,
            'title' => $this->title,
            'description' => $this->description,
            'instructor_name' => optional($this->instructor)->name ?? 'Unknown',
            'instructor_image' => optional($this->instructor)->getAvatar() ?? null,
            'instructor_id' => optional($this->instructor)->user_id ?? 'Unknown',
            'category_name' => optional($this->category)->category_name ?? 'Uncategorized',
            'videos_count' => $this->videos_count,
            'image' => $this->getImage(),
            'icon' => $this->getIcon(),
            'created_at' => $this->created_at,

            'details' => $this->details ? [
                'level' => $this->details->level,
                'language' => $this->details->language,
                'status' => $this->details->status,
                'total_duration' => $this->details->total_duration ? round($this->details->total_duration / 60, 1) : 0.0,
            ] : null,

            'pricing' => $this->pricing ? [
                'price' => $this->pricing->price,
                'final_price' => $this->final_price,
                'discount_price' => $this->pricing->isDiscountActive() ? $this->pricing->getFinalPrice() : null,
                'discount_start' => $this->pricing->discount_start,
                'discount_end' => $this->pricing->discount_end,
            ] : null,

            'enrollment' => $this->enrollment ? [
                'max_students' => $this->enrollment->max_students,
                'current_students' => $this->enrollment->current_students,
                'available_seats' => $this->available_seats,
            ] : null,

            'assignments' => $this->whenLoaded('assignments', function () {
                return AssignmentResource::collection($this->assignments);
            }),
        ];
    }
}
