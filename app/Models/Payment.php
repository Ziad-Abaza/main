<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Payment extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'payment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'purchase_id',
        'subscription_id',
        'user_id',
        'amount',
        'currency',
        'payment_status',
        'payment_method',
        'transaction_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function purchase()
    {
        return $this->belongsTo(CoursePurchase::class, 'purchase_id', 'purchase_id');
    }

    public function subscription()
    {
        return $this->belongsTo(ChildLevelSubscription::class, 'subscription_id', 'subscription_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
