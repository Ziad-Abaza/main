<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CoursePurchase extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'purchase_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'course_id',
        'child_id',
        'amount',
        'currency',
        'payment_status',
        'payment_method',
        'transaction_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function child()
    {
        return $this->belongsTo(ChildrenUniversity::class, 'child_id', 'id');
    }
}
