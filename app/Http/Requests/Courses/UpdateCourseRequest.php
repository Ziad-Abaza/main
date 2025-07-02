<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $course = $this->route('course');

        return [
            'title' => "sometimes|required|string|max:255|unique:courses,title,{$course->course_id},course_id",
            'description' => 'nullable|string',
            'category_id' => 'sometimes|required|exists:categories,category_id',
            'instructor_id' => 'sometimes|required|exists:users,user_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',

            // Coupon Fields
            'enable_coupon' => 'boolean',
            'coupon_id' => 'nullable|exists:coupons,coupon_id',
            'coupon_code' => 'nullable|string|max:255',
            'discount_value' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ];
    }
}
