<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // User management
            ['name' => 'manage_users', 'description' => 'Manage users (view, delete, add)'],

            // Roles and permissions management
            ['name' => 'manage_roles', 'description' => 'Create, update, and delete roles'],
            ['name' => 'assign_admin', 'description' => 'Assign users as Admin'],
            ['name' => 'assign_superadmin', 'description' => 'Assign users as Super Admin'],

            // Courses and learning materials management
            ['name' => 'manage_courses', 'description' => 'Manage courses (create, update, delete)'],
            ['name' => 'manage_categories', 'description' => 'Manage categories (create, update, delete)'],
            ['name' => 'upload_materials', 'description' => 'Upload educational materials'],
            ['name' => 'delete_materials', 'description' => 'Delete educational materials'],
            ['name' => 'manage_quizzes', 'description' => 'Manage quizzes and questions'],
            ['name' => 'manage_assignments', 'description' => 'Manage assignments and tasks'],
            ['name' => 'view_submissions', 'description' => 'View student assignment submissions'],

            // Enrollments
            ['name' => 'manage_enrollments', 'description' => 'Approve student enrollments in courses'],

            // Students management
            ['name' => 'manage_child', 'description' => 'Manage students (approve, reject, delete)'],
            ['name' => 'manage_absences', 'description' => 'Manage student absences'],

            // Site settings management
            ['name' => 'manage_settings', 'description' => 'Manage general site settings (FAQs, contact messages)'],

            // Content management
            ['name' => 'manage_blog', 'description' => 'Manage blog and articles'],
            ['name' => 'manage_levels', 'description' => 'Manage educational levels (beginner, advanced, etc.)'],

            // view dashboard
            ['name' => 'view_dashboard', 'description' => 'View the dashboard'],
            // view console
            ['name' => 'view_console', 'description' => 'View the console dashboard'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['description' => $permission['description']]
            );
        }
    }
}
