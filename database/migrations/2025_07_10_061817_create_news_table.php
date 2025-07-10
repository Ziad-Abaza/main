<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('author_id');
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->text('content');
            $table->string('category');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('author_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
};
