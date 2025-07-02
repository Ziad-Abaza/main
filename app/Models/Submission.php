<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'assignment_id',
        'user_id',
        'file_path',
        'comment',
        'answers',
        'submitted_at',
        'grade',
        'feedback',
        'feedback_file_path',
    ];

    protected $casts = [
        'answers' => 'array',
        'submitted_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($submission) {
            $submission->uuid = Str::uuid();
        });
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        // Explicitly define the foreign and owner keys (both are user_id) to avoid any ambiguity
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
