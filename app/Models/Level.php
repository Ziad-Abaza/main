<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Level extends Model
{
    use HasUuids;

    protected $primaryKey = 'level_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'description'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_level', 'level_id', 'course_id');
    }

    public function children()
    {
        return $this->hasMany(ChildrenUniversity::class, 'level_id');
    }
}
