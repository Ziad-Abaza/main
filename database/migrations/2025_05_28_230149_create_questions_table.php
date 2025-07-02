<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('question_id')->primary();
            $table->foreignUuid('video_id')->nullable()->constrained('videos', 'video_id')->cascadeOnDelete();
            $table->foreignUuid('quiz_id')->nullable()->constrained('quiz_assignments', 'quiz_id')->cascadeOnDelete();
            $table->text('question_text');
            $table->integer('points')->default(0);
            $table->string('type', 20)->default('mcq');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
