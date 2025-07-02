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
        Schema::create('course_details', function (Blueprint $table) {
            $table->uuid('detail_id')->primary();
            $table->text('objectives')->nullable(); // الأهداف التعليمية
            $table->text('prerequisites')->nullable(); // المتطلبات السابقة
            $table->text('content')->nullable(); // محتويات الكورس
            $table->integer('total_duration')->nullable(); // المدة الزمنية بالدقائق مثلاً
            $table->string('language', 50)->default('ar'); // اللغة
            $table->string('level', 50); // مثل: مبتدئ، متوسط، متقدم
            $table->string('status', 20)->default('available')->comment('available, upcoming, suspended');
            $table->foreignUuid('course_id')->constrained('courses', 'course_id')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_details');
    }
};
