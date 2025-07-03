<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Question;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class QuizAssignment extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'quiz_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'course_id',
        'title',
        'start_at',
        'duration_minutes',
        'end_at',
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    protected $appends = ['status', 'is_attempted'];


    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }

    public function getStatusAttribute()
    {
        $now = Carbon::now();
        $startAt = $this->start_at ? Carbon::parse($this->start_at) : null;
        $duration = $this->duration_minutes;

        $endAt = $startAt && $duration
            ? $startAt->copy()->addMinutes($duration)
            : ($this->end_at ? Carbon::parse($this->end_at) : null);

        if (!$startAt) {
            return 'not_scheduled'; 
        }

        if ($now->lt($startAt)) {
            return 'scheduled';
        }

        if ($endAt && $now->gt($endAt)) {
            return 'ended';
        }

        return 'available';
    }


    public function getIsAttemptedAttribute()
    {
        $user = Auth::user();
        if (!$user) return false;

        return $this->questions()
            ->whereHas('quizAttempts', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })->exists();
    }
}
