<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Video;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    private array $insertedQuestions = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('question_options')->truncate();
        DB::table('quiz_attempts')->truncate();
        Question::truncate();
        Schema::enableForeignKeyConstraints();

        $laravelRoutingVideo = Video::where('title', 'Laravel Routing')->first();
        $vueComponentsVideo = Video::where('title', 'Vue Components')->first();

        if (!$laravelRoutingVideo || !$vueComponentsVideo) {
            $this->command->error('Required videos not found. Please run VideoSeeder first.');
            return;
        }

        $questionTemplates = [
            // Laravel Routing Questions
            [
                'video_id' => $laravelRoutingVideo->video_id,
                'question_text' => 'What file primarily defines web routes in Laravel?',
                'points' => 10,
            ],
            [
                'video_id' => $laravelRoutingVideo->video_id,
                'question_text' => 'Which Artisan command can list all registered routes?',
                'points' => 10,
            ],
            // Vue Components Questions
            [
                'video_id' => $vueComponentsVideo->video_id,
                'question_text' => 'What is the typical file extension for a single-file Vue component?',
                'points' => 10,
            ],
            [
                'video_id' => $vueComponentsVideo->video_id,
                'question_text' => 'Props are used to pass data from parent to child components. True or False?',
                'points' => 5,
            ],
        ];

        foreach ($questionTemplates as $template) {
            $question = new Question();
            $question->fill([
                ...$template,
                'question_id' => Str::uuid()->toString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $question->save();
            $this->insertedQuestions[] = $question;
        }
    }

    /**
     * Get the inserted questions for reuse in other seeders.
     *
     * @return Question[]
     */
    public function getInsertedQuestions(): array
    {
        return $this->insertedQuestions;
    }
}