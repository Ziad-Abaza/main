<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('courses')->truncate();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $categories = [
            [
                'category_name' => 'Web Development',
                'description' => 'Courses related to web design and development, including frontend and backend technologies.',
                'image' => 'https://i.ibb.co/3YLNdxqW/Web-Development.png',
            ],
            [
                'category_name' => 'Mobile Development',
                'description' => 'Courses on building applications for mobile platforms like iOS and Android.',
                'image' => 'https://i.ibb.co/HDJZwKGR/Mobile-Development.png',
            ],
            [
                'category_name' => 'Data Science',
                'description' => 'Learn data analysis, machine learning, and big data technologies.',
                'image' => 'https://i.ibb.co/S42ZBV4h/Data-Science.png',
            ],
            [
                'category_name' => 'Cloud Computing',
                'description' => 'Courses on cloud platforms like AWS, Azure, and Google Cloud.',
                'image' => 'https://i.ibb.co/5xc6m9jn/Cloud-Computing.png',
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'category_id' => Str::uuid()->toString(),
                'category_name' => $categoryData['category_name'],
                'description' => $categoryData['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (!empty($categoryData['image'])) {
                $category->addMediaFromUrl($categoryData['image'])->toMediaCollection('category_image');
            }
        }
    }
}
