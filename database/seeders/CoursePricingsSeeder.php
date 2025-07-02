<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use Illuminate\Support\Str;

class CoursePricingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [
            'Laravel for Beginners',
            'Vue.js Fundamentals',
            'React Native: Build Mobile Apps',
        ];

        $prices = [
            [
                'price' => 99.99,
                'currency' => 'USD',
                'description' => 'Standard Course Price',
            ],
            [
                'price' => 149.99,
                'currency' => 'USD',
                'description' => 'Premium Course Price',
            ],
            [
                'price' => 129.99,
                'currency' => 'USD',
                'description' => 'Intermediate Course Price',
            ],
        ];

        foreach ($courses as $index => $title) {
            $course = Course::where('title', $title)->first();
            if ($course) {
                DB::table('course_pricings')->insert([
                    [
                        'pricing_id' => Str::uuid()->toString(),
                        'course_id' => $course->course_id,
                        'price' => $prices[$index]['price'],
                        'discount_price' => null,
                        'discount_start' => null,
                        'discount_end' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            } else {
                $this->command->info("Course with title '".$title."' not found.");
            }
        }
    }
}
