<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChildrenUniversity;
use App\Models\User;
use App\Models\Level;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ChildrenUniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = collect();
        $funnyNames = [
            'عمر الكسلان',
            'عمر الكلبوب',
            'عمر أبو أعذار',
            'عمر ملك الـ Ctrl + C'
        ];

        for ($i = 0; $i < 4; $i++) {
            $users->push(User::create([
                'user_id' => (string) Str::uuid(),
                'name' => $funnyNames[$i],
                'email' => "omar{$i}@example.com",
                'password' => Hash::make('password'),
            ]));
        }


        $level = Level::first();
        if (!$level) {
            $level = Level::create([
                'level_id' => (string) Str::uuid(),
                'name' => 'level_1',
                'description' => 'المستوى الأول',
            ]);
        }
        foreach ($users as $index => $user) {
            ChildrenUniversity::create([
                'id' => (string) Str::uuid(),
                'code' => 'CODE' . rand(1000, 9999),
                'password' => encrypt('password'),
                'level_id' => $level->level_id,
                'user_id' => $user->user_id,
                'meta' => [
                    'age' => 12,
                    'parent_phone' => '01012345037',
                ],
            ]);
        }
}
}
