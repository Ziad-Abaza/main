<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Models\Course;

class InstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $this->user;

        $coursesCount = $user->courses->count();

        $totalStudents = $user->courses->sum(function ($course) {
            return $course->enrollment?->current_students ?? 0;
        });

        $totalVideos = $user->courses->sum('videos_count');

        $latestCourse = $user->courses->sortByDesc('created_at')->first();

        return [
            'instructor_profile_id' => $this->instructor_profile_id,
            'name' => $user->name,
            'user_id' => $this->user_id,
            'bio' => $this->bio,
            'specialization' => $this->specialization,
            'experience' => $this->experience,
            'linkedin_url' => $this->linkedin_url,
            'github_url' => $this->github_url,
            'website_url' => $this->website_url,
            'skills' => $this->skills,
            'image' => $user->getAvatar(),
            'statistics' => [
                'courses_count' => $coursesCount,
                'total_students' => $totalStudents,
                'total_videos' => $totalVideos,
                'latest_course' => $latestCourse ? [
                    'title' => $latestCourse->title,
                    'image' => $latestCourse->getImage(),
                    'created_at' => $latestCourse->created_at->toDateString()
                ] : null,
            ]
        ];
    }
}
