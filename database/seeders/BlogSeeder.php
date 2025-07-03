<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run()
    {
        Blog::insert([
            [
                'title' => 'Welcome to CTU!',
                'excerpt' => 'Discover our mission, vision, and what makes CTU unique.',
                'content' => 'Borg El-Arab Technological University is dedicated to empowering learners and inspiring innovation.',
                'author' => 'CTU Team',
                'published_at' => now(),
            ],
            [
                'title' => 'CTU Launches New Programs',
                'excerpt' => 'We are excited to announce new programs for the upcoming academic year.',
                'content' => 'We are launching new undergraduate and graduate programs in technology and engineering.',
                'author' => 'Admissions Office',
                'published_at' => now(),
            ],
        ]);
    }
}
