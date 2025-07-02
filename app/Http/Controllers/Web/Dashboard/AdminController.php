<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    const PROTECTED_ROLES = ['admin', 'student'];

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show list of users.
     */
    public function getUsers()
    {
        try {
            $users = User::with('roles')->paginate(20); // ← استخدام pagination
            return view('dashboard.users.index', compact('users'));
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Error fetching users');
        }
    }

    /**
     * Show user edit form.
     */
    public function editUser(User $user)
    {
        try {
            $roles = Role::all();
            $user->load('roles');
            return view('dashboard.users.edit', compact('user', 'roles'));
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load user data');
        }
    }

    /**
     * Update user data.
     */
    public function updateUser(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => "required|email|max:255|unique:users,email," . $user->user_id . ',user_id',
                'roles' => 'required|array'
            ]);

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email']
            ]);

            $roleIds = collect($validated['roles'])->pluck('role_id')->toArray();
            $user->roles()->sync($roleIds);

            return redirect()->route('dashboard.users')
                ->with('success', 'User updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Error updating user');
        }
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user)
    {
        try {
            if ($user->roles()->where('role_name', 'admin')->exists()) {
                return back()->with('error', 'Cannot delete admin user');
            }

            $user->delete();

            return redirect()->route('dashboard.users')
                ->with('success', 'User deleted successfully');
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Error deleting user');
        }
    }

    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Role Management
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++

    /**
     * Show list of roles.
     */
    public function getRoles()
    {
        try {
            $roles = Role::withCount('users')->paginate(20);
            return view('dashboard.roles.index', compact('roles'));
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Error fetching roles');
        }
    }

    /**
     * Show create role form.
     */
    public function createRole()
    {
        try {
            return view('dashboard.roles.create');
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load create role form');
        }
    }

    /**
     * Store new role.
     */
    public function storeRole(Request $request)
    {
        try {
            $validated = $request->validate([
                'role_name' => 'required|string|max:255|unique:roles,role_name',
                'description' => 'required|string'
            ]);

            Role::create($validated);

            return redirect()->route('dashboard.roles')
                ->with('success',  'Role created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to create role');
        }
    }

    /**
     * Show edit role form.
     */
    public function editRole(Role $role)
    {
        try {
            return view('dashboard.roles.edit', compact('role'));
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load role details');
        }
    }

    /**
     * Update role data.
     */
    public function updateRole(Request $request, Role $role)
    {
        try {
            if (in_array($role->role_name, self::PROTECTED_ROLES)) {
                return back()->with('error', 'This role cannot be modified.');
            }

            $validated = $request->validate([
                'role_name' => "required|string|max:255|unique:roles,role_name," . $role->role_id . ',role_id',
                'description' => 'required|string'
            ]);

            $role->update($validated);

            return redirect()->route('dashboard.roles')
                ->with('success', 'Role updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to update role');
        }
    }

    /**
     * Delete a role.
     */
    public function destroyRole(Role $role)
    {
        try {
            if (in_array($role->role_name, self::PROTECTED_ROLES)) {
                return back()->with('error', 'This role cannot be deleted.');
            }

            $role->delete();

            return redirect()->route('dashboard.roles')
                ->with('success', 'Role deleted successfully');
        } catch (\Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to delete role');
        }
    }
}
