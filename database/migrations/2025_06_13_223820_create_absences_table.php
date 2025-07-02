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
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('child_university_id')->constrained('children_universities', 'id')->cascadeOnDelete();
            $table->foreignUuid('instructor_id')->constrained('users', 'user_id')->cascadeOnDelete();
            $table->date('date');
            $table->time('time');
            $table->string('scanned_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
