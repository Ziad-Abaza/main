<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use Illuminate\Support\Str;

class CourseDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courseTitles = [
            'Laravel for Beginners',
            'Vue.js Fundamentals',
            'React Native: Build Mobile Apps',
        ];

        $courseDetails = [
            [
                'objectives' => 'Learn the basics of Laravel',
                'prerequisites' => 'Basic PHP knowledge',
                'content' => 'Introduction to Laravel, Routing, Controllers',
                'total_duration' => 1200, // in minutes
                'language' => 'en',
                'level' => 'Beginner',
            ],
            [
                'objectives' => 'Understand Vue.js fundamentals',
                'prerequisites' => 'Basic JavaScript knowledge',
                'content' => 'Vue.js components, directives, events',
                'total_duration' => 900, // in minutes
                'language' => 'en',
                'level' => 'Beginner',
            ],
            [
                'objectives' => 'Build mobile apps with React Native',
                'prerequisites' => 'Basic JavaScript and React knowledge',
                'content' => 'React Native components, Navigation, APIs',
                'total_duration' => 1500, // in minutes
                'language' => 'en',
                'level' => 'Intermediate',
            ],
        ];

        foreach ($courseTitles as $index => $courseTitle) {
            $course = Course::where('title', $courseTitle)->first();
            if ($course) {
                DB::table('course_details')->insert([
                    [
                        'detail_id' => Str::uuid()->toString(),
                        'course_id' => $course->course_id,
                        'objectives' => $courseDetails[$index]['objectives'],
                        'prerequisites' => $courseDetails[$index]['prerequisites'],
                        'content' => $courseDetails[$index]['content'],
                        'total_duration' => $courseDetails[$index]['total_duration'],
                        'language' => $courseDetails[$index]['language'],
                        'level' => $courseDetails[$index]['level'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            } else {
                $this->command->info("Course with title '".$courseTitle."' not found.");
            }
        }
    }
}
