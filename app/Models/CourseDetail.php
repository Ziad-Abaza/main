<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CourseDetail extends Model
{
    use SoftDeletes, HasUuids;

    protected $primaryKey = 'detail_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'objectives',
        'prerequisites',
        'content',
        'total_duration',
        'language',
        'level',
        'course_id',
        'status'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
}
