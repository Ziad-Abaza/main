<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\ChildrenUniversity;
use App\Models\Product;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $children = ChildrenUniversity::all();
        $products = Product::all();

        if ($users->isEmpty() || $children->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Users, children, or products table is empty. Seed them first.');
            return;
        }

        for ($i = 0; $i < 5; $i++) {
            $user = $users->random();
            $child = $children->random();
            $orderId = (string) Str::uuid();
            $subtotal = rand(100, 500);
            $discount = rand(0, 50);
            $total = $subtotal - $discount;
            $order = Order::create([
                'order_id' => $orderId,
                'child_id' => $child->id,
                'user_id' => $user->user_id,
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'total_amount' => $total,
                'status' => collect(['pending','processing','shipped','completed','cancelled'])->random(),
                'payment_status' => collect(['unpaid','paid','partially_paid'])->random(),
                'notes' => fake()->sentence(),
            ]);

            // Add 1-3 order items (or as many products as available)
            $numItems = min(rand(1, 3), $products->count());
            $usedProducts = $products->random($numItems);
            foreach ($usedProducts as $product) {
                $quantity = rand(1, 5);
                $unitPrice = $product->price ?? rand(20, 100);
                $totalPrice = $unitPrice * $quantity;
                OrderItem::create([
                    'order_item_id' => (string) Str::uuid(),
                    'order_id' => $orderId,
                    'product_id' => $product->product_id,
                    'item_type' => 'product',
                    'item_id' => $product->product_id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                ]);
            }
        }
    }
}
