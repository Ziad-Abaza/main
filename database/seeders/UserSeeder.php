<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        DB::table('model_has_roles')->truncate(); // Spatie uses this table
        Schema::enableForeignKeyConstraints();

        $superAdminRole = Role::where('name', 'superadmin')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $instructorRole = Role::where('name', 'instructor')->first();
        $studentRole = Role::where('name', 'student')->first();

        if (!($superAdminRole && $adminRole && $instructorRole && $studentRole)) {
            $this->command->error('One or more roles are missing. Run RoleSeeder first.');
            return;
        }

        $superAdmins = [
            [
                'name' => 'Ziad Hassan',
                'email' => 'ziad.h.abaza@gmail.com',
                'avatar' => 'https://i.ibb.co/9DxRVC8/2.jpg'
            ],
            [
                'name' => 'Omar algamel',
                'email' => 'omeralgamel@gmail.com',
                'avatar' => 'https://i.ibb.co/4nKy2ftM/WIN-20250128-14-29-18-Pro.jpg'
            ],
            [
                'name' => 'يوسف النقاش',
                'email' => 'yosif@gmail.com',
                'avatar' => 'https://i.ibb.co/4nKy2ftM/WIN-20250128-14-29-18-Pro.jpg'
            ],
        ];

        foreach ($superAdmins as $adminData) {
            $user = User::create([
                'user_id' => Str::uuid()->toString(),
                'name' => $adminData['name'],
                'email' => $adminData['email'],
                'password' => Hash::make('123456789'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user->assignRole('superadmin');

            $user->addMediaFromUrl($adminData['avatar'])->toMediaCollection('avatar');
        }

        // ✅ Instructors
        // for ($i = 1; $i <= 4; $i++) {
        //     $user = User::create([
        //         'user_id' => Str::uuid()->toString(),
        //         'name' => "Instructor $i",
        //         'email' => "instructor$i@example.com",
        //         'password' => Hash::make('password'),
        //         'email_verified_at' => now(),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);

        //     $user->assignRole('instructor');

        //     $user->addMediaFromUrl("https://th.bing.com/th/id/OIP.m9dTL6OertLrSmrJfL3TRwHaE6?o=7rm=3&rs=1&pid=ImgDetMain")->toMediaCollection('avatar');
        // }

        // ✅ Students
        // for ($i = 1; $i <= 7; $i++) {
        //     $user = User::create([
        //         'user_id' => Str::uuid()->toString(),
        //         'name' => "Student $i",
        //         'email' => "student$i@example.com",
        //         'password' => Hash::make('password'),
        //         'email_verified_at' => now(),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);

        //     $user->assignRole('student');

        //     $user->addMediaFromUrl("https://th.bing.com/th/id/R.dbabab887a119175ba22c8341e67de37?rik=n%2bIvPpmqpsc22g&pid=ImgRaw&r=0")->toMediaCollection('avatar');
        // }
    }
}
