<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChildLevelSubscription;
use App\Models\ChildrenUniversity;
use App\Models\Level;
use Carbon\Carbon;

class ChildLevelSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $children = ChildrenUniversity::all();
        $levels = Level::all();

        if ($children->isEmpty() || $levels->isEmpty()) {
            $this->command->info('No children or levels found. Please run ChildrenUniversitySeeder and LevelSeeder first.');
            return;
        }

        $statuses = ['active', 'inactive', 'expired', 'suspended'];

        foreach ($children as $child) {
            // Create 1-2 subscriptions per child
            $numSubscriptions = rand(1, 2);

            for ($i = 0; $i < $numSubscriptions; $i++) {
                $level = $levels->random();
                $status = $statuses[array_rand($statuses)];

                $subscribeDate = Carbon::now()->subDays(rand(1, 365));
                $expiryDate = $subscribeDate->copy()->addDays(rand(30, 365));

                // Check if child already has a subscription for this level
                $existingSubscription = ChildLevelSubscription::where('child_id', $child->id)
                    ->where('level_id', $level->level_id)
                    ->first();

                if (!$existingSubscription) {
                    ChildLevelSubscription::create([
                        'child_id' => $child->id,
                        'level_id' => $level->level_id,
                        'subscribe_date' => $subscribeDate,
                        'expiry_date' => $expiryDate,
                        'status' => $status,
                    ]);
                }
            }
        }

        $this->command->info('Child level subscriptions seeded successfully!');
    }
}
