<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'manage_students', 'description' => 'Full management of students (view, delete, approve)'],
            ['name' => 'manage_users', 'description' => 'Full management of users (view, delete, add)'],
            ['name' => 'manage_courses', 'description' => 'Manage educational courses'],
            ['name' => 'manage_lessons', 'description' => 'Manage lessons and educational content'],
            ['name' => 'upload_materials', 'description' => 'Upload educational materials'],
            ['name' => 'delete_materials', 'description' => 'Delete educational materials'],
            ['name' => 'manage_quizzes', 'description' => 'Manage quizzes and exams'],
            ['name' => 'view_reports', 'description' => 'View general and detailed reports'],
            ['name' => 'manage_settings', 'description' => 'Manage system settings'],
            ['name' => 'manage_roles', 'description' => 'Create, edit, and delete roles'],
        ];


        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name']
            ], [
                'permission_id' => Str::uuid()->toString(),
                'description' => $permission['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
