<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\QuizAssignment;

class Question extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'question_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'video_id',
        'quiz_id',
        'question_text',
        'points',
        'type',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    public function questionOptions()
    {
        return $this->hasMany(QuestionOption::class, 'question_id');
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class, 'question_id');
    }

    public function quiz()
    {
        return $this->belongsTo(QuizAssignment::class, 'quiz_id');
    }
}
