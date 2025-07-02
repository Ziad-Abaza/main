<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
// log
use Illuminate\Support\Facades\Log;

class CoursePricing extends Model
{
    use SoftDeletes, HasUuids;

    protected $primaryKey = 'pricing_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'course_id',
        'price',
        'discount_price',
        'discount_start',
        'discount_end'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function isDiscountActive()
    {
        if (empty($this->discount_start) || empty($this->discount_end)) {
            return false;
        }

        try {
            $start = \Carbon\Carbon::parse($this->discount_start);
            $end = \Carbon\Carbon::parse($this->discount_end);
            return now()->between($start, $end, true);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getFinalPrice()
    {
        $price = (float) $this->price;
        $discountPrice = (float) $this->discount_price;
        if ($this->isDiscountActive() && $discountPrice > 0) {
            $finalPrice = $price - (($discountPrice / 100) * $price);
            return round($finalPrice, 2);
        }
        return $price;
    }

    // App\Models\CoursePricing.php

    public function getTimeLeft(): string
    {
        try {
            if (!$this->discount_end) {
                return 'No deadline';
            }

            $now = now();
            $end = \Carbon\Carbon::parse($this->discount_end);
            $diffInSeconds = $end->diffInSeconds($now, true); 

            if ($diffInSeconds <= 0) {
                return 'Offer has expired';
            }

            $days = floor($diffInSeconds / 86400);
            $hours = floor(($diffInSeconds % 86400) / 3600);

            if ($days > 0 && $hours > 0) {
                return "$days day" . ($days !== 1 ? 's' : '') . " and $hours hour" . ($hours !== 1 ? 's' : '');
            } elseif ($days > 0) {
                return "$days day" . ($days !== 1 ? 's' : '');
            } elseif ($hours > 0) {
                return "$hours hour" . ($hours !== 1 ? 's' : '');
            }

            return 'Less than an hour';
        } catch (\Exception $e) {
            return 'Invalid date';
        }
    }
}
