<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ChildLevelSubscription extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'subscription_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'child_id',
        'level_id',
        'subscribe_date',
        'expiry_date',
        'status'
    ];

    protected $casts = [
        'subscribe_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    public function child()
    {
        return $this->belongsTo(ChildrenUniversity::class, 'child_id', 'id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'level_id');
    }
}
