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
        Schema::create('course_purchases', function (Blueprint $table) {
            $table->uuid('purchase_id')->primary();
            $table->uuid('user_id');
            $table->uuid('course_id');
            $table->uuid('child_id')->nullable(); // If purchased for a child
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('EGP');
            $table->string('payment_status'); // pending, completed, failed, refunded
            $table->string('payment_method'); // credit_card, paypal, etc.
            $table->string('transaction_id')->nullable();
            $table->json('payment_response')->nullable();
            $table->timestamp('purchased_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->cascadeOnDelete();

            $table->foreign('child_id')
                ->references('id')
                ->on('children_universities')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_purchases');
    }
};
