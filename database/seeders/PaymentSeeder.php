<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\User;
use App\Models\Order;
use App\Models\CoursePurchase;
use App\Models\ChildLevelSubscription;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $orders = Order::all();
        $purchases = CoursePurchase::all();
        $subscriptions = ChildLevelSubscription::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }

        $paymentMethods = ['credit_card', 'paypal', 'bank_transfer', 'cash'];
        $paymentStatuses = ['pending', 'completed', 'failed', 'refunded'];
        $currencies = ['EGP', 'USD', 'EUR'];

        // Create payments for orders
        foreach ($orders as $order) {
            if (rand(1, 3) === 1 && $order->total > 0) { // 33% chance to create payment for each order with valid total
                Payment::create([
                    'order_id' => $order->order_id,
                    'user_id' => $order->user_id,
                    'amount' => $order->total ?? rand(100, 1000),
                    'currency' => $order->currency ?? 'EGP',
                    'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'transaction_id' => 'TXN_' . strtoupper(uniqid()),
                    'payment_gateway_response' => [
                        'gateway' => 'test_gateway',
                        'response_code' => '200',
                        'response_message' => 'Payment processed successfully',
                        'timestamp' => now()->toISOString()
                    ],
                    'paid_at' => rand(1, 2) === 1 ? now()->subDays(rand(1, 30)) : null,
                ]);
            }
        }

        // Create payments for course purchases
        foreach ($purchases as $purchase) {
            if (rand(1, 2) === 1) { // 50% chance to create payment for each purchase
                Payment::create([
                    'purchase_id' => $purchase->purchase_id,
                    'user_id' => $purchase->user_id,
                    'amount' => rand(100, 1000),
                    'currency' => $currencies[array_rand($currencies)],
                    'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'transaction_id' => 'TXN_' . strtoupper(uniqid()),
                    'payment_gateway_response' => [
                        'gateway' => 'test_gateway',
                        'response_code' => '200',
                        'response_message' => 'Payment processed successfully',
                        'timestamp' => now()->toISOString()
                    ],
                    'paid_at' => rand(1, 2) === 1 ? now()->subDays(rand(1, 30)) : null,
                ]);
            }
        }

        // Create payments for subscriptions
        foreach ($subscriptions as $subscription) {
            if (rand(1, 2) === 1) { // 50% chance to create payment for each subscription
                Payment::create([
                    'subscription_id' => $subscription->subscription_id,
                    'user_id' => $subscription->child->user_id,
                    'amount' => rand(500, 2000),
                    'currency' => $currencies[array_rand($currencies)],
                    'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'transaction_id' => 'TXN_' . strtoupper(uniqid()),
                    'payment_gateway_response' => [
                        'gateway' => 'test_gateway',
                        'response_code' => '200',
                        'response_message' => 'Payment processed successfully',
                        'timestamp' => now()->toISOString()
                    ],
                    'paid_at' => rand(1, 2) === 1 ? now()->subDays(rand(1, 30)) : null,
                ]);
            }
        }

        // Create some standalone payments
        for ($i = 0; $i < 5; $i++) {
            Payment::create([
                'user_id' => $users->random()->user_id,
                'amount' => rand(50, 500),
                'currency' => $currencies[array_rand($currencies)],
                'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'transaction_id' => 'TXN_' . strtoupper(uniqid()),
                'payment_gateway_response' => [
                    'gateway' => 'test_gateway',
                    'response_code' => '200',
                    'response_message' => 'Payment processed successfully',
                    'timestamp' => now()->toISOString()
                ],
                'paid_at' => rand(1, 2) === 1 ? now()->subDays(rand(1, 30)) : null,
            ]);
        }

        $this->command->info('Payments seeded successfully!');
    }
}
