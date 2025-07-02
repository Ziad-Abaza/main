<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class QuizAttemptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'attempt_id' => $this->attempt_id,
            'user_id' => $this->user_id,
            'question_id' => $this->question_id,
            'selected_option_id' => $this->selected_option_id,
            'is_correct' => (bool)$this->is_correct,
            'attempt_time' => $this->attempt_time,
            'question' => $this->whenLoaded('question', function () {
                return [
                    'question_text' => $this->question->question_text,
                ];
            }),
            'selected_option' => $this->whenLoaded('selectedOption', function () {
                return [
                    'option_text' => $this->selectedOption->option_text,
                ];
            }),
        ];
    }
}
