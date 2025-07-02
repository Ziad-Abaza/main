<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Str;

class CourseEnrollmentsSeeder extends Seeder
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

        $studentEmails = [
            'Laravel for Beginners' => ['student1@example.com', 'student2@example.com', 'student3@example.com'],
            'Vue.js Fundamentals' => ['student4@example.com', 'student5@example.com'],
            'React Native: Build Mobile Apps' => ['student6@example.com', 'student7@example.com'],
        ];

        foreach ($courseTitles as $courseTitle) {
            $course = Course::where('title', $courseTitle)->first();
            if ($course) {
                foreach ($studentEmails[$courseTitle] as $studentEmail) {
                    $student = User::where('email', $studentEmail)->first();
                    if ($student) {
                        DB::table('course_enrollments')->insert([
                            [
                                'enrollment_id' => Str::uuid()->toString(),
                                'course_id' => $course->course_id,
                                'user_id' => $student->user_id,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ],
                        ]);
                    } else {
                        $this->command->info("Student with email '".$studentEmail."' not found.");
                    }
                }
            } else {
                $this->command->info("Course with title '".$courseTitle."' not found.");
            }
        }
    }
}
