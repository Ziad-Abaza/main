<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\QrCodeGenerator;

class ChildrenUniversity extends Model
{
    use HasUuids, QrCodeGenerator;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'code',
        'password',
        'class_name',
        'level_id',
        'meta',
        'image',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * Get the user that owns the ChildrenUniversity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the absences for the child
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function absences()
    {
        return $this->hasMany(Absence::class, 'child_university_id', 'id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(ChildLevelSubscription::class, 'child_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'child_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'child_id', 'id');
    }
}
