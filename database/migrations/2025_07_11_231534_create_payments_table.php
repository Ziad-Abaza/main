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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('payment_id')->primary();
            $table->uuid('order_id')->nullable();
            $table->uuid('purchase_id')->nullable();
            $table->uuid('subscription_id')->nullable();
            $table->uuid('user_id');
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('EGP');
            $table->string('payment_status'); // pending, completed, failed, refunded
            $table->string('payment_method'); // credit_card, paypal, etc.
            $table->string('transaction_id')->nullable();
            $table->json('payment_gateway_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')
                ->references('order_id')
                ->on('orders')
                ->nullOnDelete();

            $table->foreign('purchase_id')
                ->references('purchase_id')
                ->on('course_purchases')
                ->nullOnDelete();

            $table->foreign('subscription_id')
                ->references('subscription_id')
                ->on('child_level_subscriptions')
                ->nullOnDelete();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
