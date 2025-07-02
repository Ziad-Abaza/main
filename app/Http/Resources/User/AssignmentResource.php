<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AssignmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'has_attachment' => !is_null($this->attachment_path),
            'attachment_url' => $this->when($this->attachment_path, function() {
                return asset('storage/assignments/' . $this->attachment_path);
            }),
            'course' => $this->whenLoaded('course', function () {
                return [
                    'id' => $this->course->course_id,
                    'title' => $this->course->title,
                ];
            }),
            'submission' => $this->whenLoaded('submissions', function () {
                $submission = $this->submissions->first();
                if (!$submission) return null;

                return [
                    'id' => $submission->id,
                    'comment' => $submission->comment,
                    'feedback' => $submission->feedback,
                    'grade' => $submission->grade,
                    'has_feedback_file' => !is_null($submission->feedback_file_path),
                    'feedback_file_url' => $submission->feedback_file_path ? asset('storage/assignments/' . $submission->feedback_file_path) : null,
                    'created_at' => $submission->created_at,
                    'has_file' => !is_null($submission->file_path),
                    'file_url' => $submission->file_path ? asset('storage/assignments/' . $submission->file_path) : null,
                ];
            }),
            'status' => $this->getStatus(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function getStatus(): string
    {
        if ($this->submissions->isNotEmpty()) {
            return 'submitted';
        }

        if ($this->due_date) {
            return $this->due_date->isPast() ? 'overdue' : 'pending';
        }

        return 'pending';
    }
}
