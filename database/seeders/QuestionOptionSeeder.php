<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuestionOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define options grouped by question text
        $optionsMap = [
            'What file primarily defines web routes in Laravel?' => [
                ['text' => 'routes/web.php', 'correct' => true],
                ['text' => 'app/Http/routes.php', 'correct' => false],
                ['text' => 'config/routes.php', 'correct' => false],
                ['text' => 'public/web.php', 'correct' => false],
            ],
            'Which Artisan command can list all registered routes?' => [
                ['text' => 'php artisan route:list', 'correct' => true],
                ['text' => 'php artisan routes', 'correct' => false],
                ['text' => 'php artisan show:routes', 'correct' => false],
                ['text' => 'php artisan route:show', 'correct' => false],
            ],
            'What is the typical file extension for a single-file Vue component?' => [
                ['text' => '.vue', 'correct' => true],
                ['text' => '.js', 'correct' => false],
                ['text' => '.jsx', 'correct' => false],
                ['text' => '.component.vue', 'correct' => false],
            ],
            'Props are used to pass data from parent to child components. True or False?' => [
                ['text' => 'True', 'correct' => true],
                ['text' => 'False', 'correct' => false],
                ['text' => 'Depends on the component type', 'correct' => false],
                ['text' => 'Only when using Vuex', 'correct' => false],
            ],
        ];

        foreach ($optionsMap as $questionText => $options) {
            // Get question_id dynamically
            $question = DB::table('questions')
                ->where('question_text', $questionText)
                ->first();

            if (!$question) {
                $this->command->warn("Question not found: {$questionText}");
                continue;
            }

            foreach ($options as $index => $option) {
                DB::table('question_options')->insert([
                    'option_id' => Str::uuid(),
                    'question_id' => $question->question_id,
                    'option_text' => $option['text'],
                    'is_correct' => $option['correct'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}