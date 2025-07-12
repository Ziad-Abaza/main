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
        Schema::create('child_level_subscriptions', function (Blueprint $table) {
            $table->uuid('subscription_id')->primary();
            $table->uuid('child_id');
            $table->uuid('level_id');
            $table->timestamp('subscribe_date')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('child_id')
                ->references('id')
                ->on('children_universities')
                ->cascadeOnDelete();

            $table->foreign('level_id')
                ->references('level_id')
                ->on('levels')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_level_subscriptions');
    }
};
