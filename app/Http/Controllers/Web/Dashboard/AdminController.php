<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    const PROTECTED_ROLES = ['admin', 'student', 'superadmin'];

    public function __construct()
    {
        $this->middleware('auth');

        // apply 'manage_users' permission to user-related methods
        $this->middleware('can:manage_users')->only([
            'getUsers',
            'editUser',
            'updateUser',
            'deleteUser'
        ]);

        // apply 'manage_roles' permission to role-related methods
        $this->middleware('can:manage_roles')->only([
            'getRoles',
            'createRole',
            'storeRole',
            'editRole',
            'updateRole',
            'destroyRole'
        ]);
    }



    /**
     * Show list of users.
     */
    public function getUsers()
    {
        try {
            $users = User::with('roles')->paginate(20);
            return view('dashboard.users.index', compact('users'));
        } catch (\Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
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
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
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
                'roles' => 'required|array',
                'roles.*' => 'exists:roles,id',
            ]);

            /**
             * @var \App\Models\User $currentUser
             */
            $currentUser = Auth::user();
            $assigningRoles = Role::whereIn('id', $validated['roles'])->pluck('name')->toArray();

            foreach ($assigningRoles as $roleName) {
                if ($roleName === 'admin' && ! $currentUser->can('assign_admin')) {
                    return back()->with('error', 'You are not authorized to assign the admin role');
                }

                if ($roleName === 'superadmin' && ! $currentUser->can('assign_superadmin')) {
                    return back()->with('error', 'You are not authorized to assign the superadmin role');
                }
            }

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $user->syncRoles($assigningRoles);

            return redirect()->route('dashboard.users')
                ->with('success', 'User updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Error updating user');
        }
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user)
    {
        try {
            if ($user->hasRole('superadmin')) {
                return back()->with('error', 'Cannot delete a Superadmin user.');
            }

            $user->delete();

            return redirect()->route('dashboard.users')
                ->with('success', 'User deleted successfully');
        } catch (\Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Error deleting user');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Role Management
    |--------------------------------------------------------------------------
    */

    public function getRoles()
    {
        try {
            $roles = Role::withCount('users')->paginate(20);
            return view('dashboard.roles.index', compact('roles'));
        } catch (\Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Error fetching roles');
        }
    }

    public function createRole()
    {
        try {
            return view('dashboard.roles.create');
        } catch (\Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load create role form');
        }
    }

    public function storeRole(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
                'description' => 'required|string'
            ]);

            Role::create($validated);

            return redirect()->route('dashboard.roles')
                ->with('success', 'Role created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to create role');
        }
    }

    public function editRole(Role $role)
    {
        try {
            return view('dashboard.roles.edit', compact('role'));
        } catch (\Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load role details');
        }
    }

    public function updateRole(Request $request, Role $role)
    {
        try {
            if (in_array($role->name, self::PROTECTED_ROLES)) {
                return back()->with('error', 'This role cannot be modified.');
            }

            $validated = $request->validate([
                'name' => "required|string|max:255|unique:roles,name," . $role->id,
                'description' => 'required|string'
            ]);

            $role->update($validated);

            return redirect()->route('dashboard.roles')
                ->with('success', 'Role updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to update role');
        }
    }

    public function destroyRole(Role $role)
    {
        try {
            if (in_array($role->name, self::PROTECTED_ROLES)) {
                return back()->with('error', 'This role cannot be deleted.');
            }

            $role->delete();

            return redirect()->route('dashboard.roles')
                ->with('success', 'Role deleted successfully');
        } catch (\Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to delete role');
        }
    }
}
