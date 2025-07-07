<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'child_university_id',
        'instructor_id',
        'date',
        'time',
        'scanned_by',
        'exported_at',
    ];

    /**
     * Get the childUniversity that owns the Absence
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function childUniversity(): BelongsTo
    {
        return $this->belongsTo(ChildrenUniversity::class, 'child_university_id', 'id');
    }

    /**
     * Get the instructor that owns the Absence
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id', 'user_id');
    }
}
