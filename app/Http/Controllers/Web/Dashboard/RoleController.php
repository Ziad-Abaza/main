<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Throwable;

class RoleController extends Controller
{
    const PROTECTED_ROLES = ['admin', 'student', 'instructor', 'superadmin'];

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show list of roles.
     */
    public function index()
    {
        try {
            $roles = Role::withCount('users')->paginate(30);
            return view('dashboard.roles.index', compact('roles'));
        } catch (Throwable $th) {
            Log::error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to retrieve roles');
        }
    }

    /**
     * Show create role form.
     */
    public function create()
    {
        try {
            $allPermissions = Permission::all();
            return view('dashboard.roles.create', compact('allPermissions'));
        } catch (Throwable $th) {
            Log::error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load create role form');
        }
    }

    /**
     * Store new role.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
                'description' => 'nullable|string|max:1000',
                'permissions' => 'array',
                'permissions.*' => 'exists:permissions,name',
            ]);

            $role = Role::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'guard_name' => 'web',
            ]);

            if (!empty($validated['permissions'])) {
                $role->syncPermissions($validated['permissions']);
            }

            return redirect()->route('console.roles.index')->with('success', 'Role created successfully');
        } catch (ValidationException $e) {
            Log::error(__METHOD__ . ' - ' . $e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (Throwable $th) {
            Log::error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to create role');
        }
    }

    /**
     * Show edit role form.
     */
    public function edit(Role $role)
    {
        try {
            $allPermissions = Permission::all();
            return view('dashboard.roles.edit', compact('role', 'allPermissions'));
        } catch (Throwable $th) {
            Log::error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load edit role form');
        }
    }

    /**
     * Update role data.
     */

    public function update(Request $request, Role $role)
    {
        try {
            if (in_array($role->name, self::PROTECTED_ROLES)) {
                return back()->with('error', 'This role cannot be modified');
            }

            $validated = $request->validate([
                'name' => "required|string|max:255|unique:roles,name,{$role->id}",
                'description' => 'nullable|string|max:1000',
                'permissions' => 'array',
                'permissions.*' => 'exists:permissions,name',
            ]);

            $role->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? $role->description,
            ]);

            if (!empty($validated['permissions'])) {
                $role->syncPermissions($validated['permissions']);
            }

            return redirect()->route('console.roles.index')->with('success', 'Role updated successfully');
        } catch (ValidationException $e) {
            Log::error(__METHOD__ . ' - ' . $e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (Throwable $th) {
            Log::error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to update role');
        }
    }
    
    /**
     * Delete a role.
     */
    public function destroy(Role $role)
    {
        try {
            if (in_array($role->name, self::PROTECTED_ROLES)) {
                return back()->with('error', 'This role cannot be deleted');
            }

            $role->delete();

            return redirect()->route('console.roles.index')->with('success', 'Role deleted successfully');
        } catch (Throwable $th) {
            Log::error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to delete role');
        }
    }
}
