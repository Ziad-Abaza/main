<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // create roles or retrieve them if they already exist
        $superAdmin  = Role::firstOrCreate(['name' => 'superadmin'],  ['guard_name' => 'web']);
        $admin       = Role::firstOrCreate(['name' => 'admin'],       ['guard_name' => 'web']);
        $instructor  = Role::firstOrCreate(['name' => 'instructor'],  ['guard_name' => 'web']);
        $student     = Role::firstOrCreate(['name' => 'student'],     ['guard_name' => 'web']);

        //all permissions
        $allPermissions = Permission::pluck('name')->toArray();

        // super admin assigned all permissions
        $superAdmin->syncPermissions($allPermissions);

        // admin permissions
        $adminPermissions = [
            'manage_users',
            'manage_roles',
            'manage_courses',
            'upload_materials',
            'delete_materials',
            'manage_quizzes',
            'manage_child',
            'manage_absences',
            'manage_settings',
            'manage_blog',
            'manage_levels',
            'view_console',
            'view_dashboard',
        ];
        $admin->syncPermissions($adminPermissions);

        // Instructor permissions
        $instructorPermissions = [
            'manage_courses',
            'upload_materials',
            'delete_materials',
            'manage_quizzes',
            'manage_assignments',
            'manage_users',
            'manage_child',
            'manage_absences',
            'view_submissions',
            'manage_enrollments',
            'view_dashboard'
        ];
        $instructor->syncPermissions($instructorPermissions);
    }
}
