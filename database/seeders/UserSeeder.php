<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        DB::table('role_user')->truncate();
        Schema::enableForeignKeyConstraints();

        $adminRole = Role::where('name', 'admin')->first();
        $instructorRole = Role::where('name', 'instructor')->first();
        $studentRole = Role::where('name', 'student')->first();

        if (!$adminRole || !$instructorRole || !$studentRole) {
            $this->command->error('Admin, Instructor, or Student role not found. Please run RoleSeeder first.');
            return;
        }

        $admins = [
            [
                'name' => 'Ziad Hassan',
                'email' => 'ziad@gmail.com',
                'password' => Hash::make('123456789'),
                'avatar' => 'https://i.ibb.co/9DxRVC8/2.jpg'
            ],
            [
                'name' => 'Omar algamel',
                'email' => 'omeralgamel@gmail.com',
                'password' => Hash::make('123456789'),
                'avatar' => 'https://i.ibb.co/4nKy2ftM/WIN-20250128-14-29-18-Pro.jpg'
            ],
        ];

        // Create 2 admins
        // Create 2 admins
        $adminAvatars = [
            'https://i.ibb.co/9DxRVC8/2.jpg',
            'https://i.ibb.co/4nKy2ftM/WIN-20250128-14-29-18-Pro.jpg'
        ];

        for ($i = 1; $i <= 2; $i++) {
            $user = User::create([
                'user_id' => Str::uuid()->toString(),
                'name' => $admins[$i - 1]['name'],
                'email' => $admins[$i - 1]['email'],
                'password' => $admins[$i - 1]['password'],
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $user->roles()->attach($adminRole->role_id);

            $user->addMediaFromUrl($adminAvatars[$i - 1])->toMediaCollection('avatar');
        }

        // Create 4 instructors
        for ($i = 1; $i <= 4; $i++) {
            $user = User::create([
                'user_id' => Str::uuid()->toString(),
                'name' => "Instructor $i",
                'email' => "instructor$i@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $user->roles()->attach($instructorRole->role_id);

            $user->addMediaFromUrl("https://th.bing.com/th/id/OIP.m9dTL6OertLrSmrJfL3TRwHaE6?o=7rm=3&rs=1&pid=ImgDetMain")->toMediaCollection('avatar');
        }

        // Create 7 students
        for ($i = 1; $i <= 7; $i++) {
            $user = User::create([
                'user_id' => Str::uuid()->toString(),
                'name' => "Student $i",
                'email' => "student$i@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $user->roles()->attach($studentRole->role_id);

            $user->addMediaFromUrl("https://th.bing.com/th/id/R.dbabab887a119175ba22c8341e67de37?rik=n%2bIvPpmqpsc22g&pid=ImgRaw&r=0")->toMediaCollection('avatar');
        }

    }
}
