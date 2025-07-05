<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('videos')->truncate();
        DB::table('user_course_progress')->truncate();
        DB::table('certificates')->truncate();
        DB::table('course_details')->truncate();
        DB::table('course_pricings')->truncate();
        DB::table('course_enrollments')->truncate();
        // DB::table('course_reviews')->truncate();
        // DB::table('course_favorites')->truncate();
        // DB::table('course_questions')->truncate();
        // DB::table('course_answers')->truncate();
        // DB::table('course_quizzes')->truncate();
        // DB::table('course_quiz_questions')->truncate();
        // DB::table('course_quiz_answers')->truncate();
        // DB::table('course_quiz_results')->truncate();
        // DB::table('course_quiz_attempts')->truncate();
        Course::truncate();
        Schema::enableForeignKeyConstraints();

        $webDevCategory = Category::where('category_name', 'Web Development')->first();
        $mobileDevCategory = Category::where('category_name', 'Mobile Development')->first();
        $instructor = User::where('email', 'instructor1@example.com')->first();

        if (!$webDevCategory || !$mobileDevCategory || !$instructor) {
            $this->command->error('Required categories or instructor not found. Please run CategorySeeder and UserSeeder first.');
            return;
        }

        $courses = [
            [
                'title' => 'Laravel for Beginners',
                'description' => 'A comprehensive guide to Laravel framework for building modern web applications.',
                'category_id' => $webDevCategory->category_id,
                'image' => 'https://i.ibb.co/Qv3C1PhB/Laravel-for-Beginners.jpg',
                'icon' => 'https://i.ibb.co/MDH78BHV/Laravel-icon.jpg',
            ],
            [
                'title' => 'Vue.js Fundamentals',
                'description' => 'Learn the fundamentals of Vue.js, the progressive JavaScript framework.',
                'category_id' => $webDevCategory->category_id,
                'image' => 'https://i.ibb.co/5XPpy9m6/Vue-js-Fundamentals.png',
                'icon' => 'https://i.ibb.co/spKfvgVy/Vue-js-icon.png',
            ],
            [
                'title' => 'React Native: Build Mobile Apps',
                'description' => 'Develop cross-platform mobile applications using React Native.',
                'category_id' => $mobileDevCategory->category_id,
                'image' => 'https://i.ibb.co/3YvgnCtg/React-Native-Build-Mobile-Apps.png',
                'icon' => 'https://i.ibb.co/4Z3sghmn/React-Native-icon.jpg',
            ],
        ];

        foreach ($courses as $data) {
            $course = Course::create([
                'course_id' => Str::uuid()->toString(),
                'title' => $data['title'],
                'description' => $data['description'],
                'instructor_id' => $instructor->user_id,
                'category_id' => $data['category_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // if (!empty($data['image'])) {
            //     $course->addMediaFromUrl($data['image'])->toMediaCollection('course_image');
            // }

            // if (!empty($data['icon'])) {
            //     $course->addMediaFromUrl($data['icon'])->toMediaCollection('course_icon');
            // }
        }
    }
}
