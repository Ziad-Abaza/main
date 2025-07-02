<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CourseEnrollment extends Model
{
    use SoftDeletes, HasUuids;

    protected $primaryKey = 'enrollment_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'course_id',
        'user_id',
        'max_students',
        'current_students',
        'is_processing_enrollment'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function isFull()
    {
        return $this->current_students >= $this->max_students;
    }

    public function availableSeats()
    {
        return max(0, $this->max_students - $this->current_students);
    }
}
