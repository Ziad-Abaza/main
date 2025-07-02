<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('role_id');
        $instructorRoleId = DB::table('roles')->where('name', 'instructor')->value('role_id');
        $studentRoleId = DB::table('roles')->where('name', 'student')->value('role_id');

        $permissions = DB::table('permissions')->pluck('permission_id', 'name');

        // Admin has all permissions
        $adminPermissions = array_values($permissions->toArray());
        foreach ($adminPermissions as $permId) {
            DB::table('permission_role')->insert([
                'role_id' => $adminRoleId,
                'permission_id' => $permId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Instructor permissions
        $instructorPerms = [
            'manage_students',
            'manage_courses',
            'manage_lessons',
            'upload_materials',
            'delete_materials',
            'manage_quizzes',
        ];
        foreach ($instructorPerms as $permName) {
            DB::table('permission_role')->insert([
                'role_id' => $instructorRoleId,
                'permission_id' => $permissions[$permName],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
