<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\InstructorProfile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class InstructorProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        InstructorProfile::truncate();
        Schema::enableForeignKeyConstraints();


        $instructors = User::role('instructor')->get();

        foreach ($instructors as $instructor) {
            InstructorProfile::create([
                'instructor_profile_id' => Str::uuid()->toString(),
                'user_id' => $instructor->user_id,
                'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'specialization' => 'Web Development',
                'experience' => '5 years',
                'linkedin_url' => 'https://www.linkedin.com/in/example',
                'github_url' => 'https://github.com/example',
                'website_url' => 'https://example.com',
                'skills' => json_encode(['PHP', 'Laravel', 'JavaScript']),
            ]);
        }
    }
}
