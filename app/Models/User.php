<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @method bool hasRole(string $role)
 */
class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasUuids, InteractsWithMedia;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = ['roles'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's roles.
     */
    public function getRolesAttribute()
    {
        // This ensures that the roles relationship is loaded and returned
        // when 'roles' is in $appends. It will only be loaded if not already.
        if (! $this->relationLoaded('roles')) {
            $this->load('roles');
        }
        return $this->getRelation('roles');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id', 'user_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * Get the user's name.
     */
    public function hasRole($role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function hasPermission($permissionName): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permissionName) {
                $query->where('name', $permissionName);
            })->exists();
    }
    public function instructorProfile()
    {
        return $this->hasOne(InstructorProfile::class, 'user_id');
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class, 'user_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'user_id');
    }

    public function userCourseProgress()
    {
        return $this->hasMany(UserCourseProgress::class, 'user_id', 'user_id');
    }

    public function userVideoProgress()
    {
        return $this->hasMany(UserVideoProgress::class, 'user_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'user_course_progress', 'user_id', 'course_id')
            ->withPivot(['completion_percentage', 'last_accessed', 'user_course_id'])
            ->withTimestamps();
    }

    /**
     * Check if the user is the instructor of the given course.
     *
     * @param string $courseId
     * @return bool
     */
    public function isEnrolledIn(string $courseId): bool
    {
        return $this->enrolledCourses()
            ->where('courses.course_id', $courseId)
            ->exists();
    }
    /**
     * Check if the user is the instructor of the given course.
     *
     * @param string $courseId
     * @return bool
     */
    public function isInstructorOfCourse(string $courseId): bool
    {
        return $this->courses()
            ->where('courses.course_id', $courseId)
            ->exists();
    }
    public function getAvatar()
    {
        $media = $this->getFirstMedia('avatar');
        return $media ? $media->getUrl() : asset('assets/image/default-avatar.png');
    }

    public function setAvatar($file)
    {
        $this->clearMediaCollection('avatar');
        $this->addMedia($file)->toMediaCollection('avatar');
    }
}
