<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Apply auth and role middleware to admin-related routes only
        $this->middleware(['auth', 'role:admin'])->only(['edit', 'update', 'destroy']);
    }

    /*
    |--------------------------------------------------------------------------
    | > User Management - Dashboard
    |--------------------------------------------------------------------------
    */

    /**
     * Display a listing of all users.
     */
    public function index(Request $request)
    {
        try {
            $query = User::with('roles');

            // Search by name or email
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            }

            // Filter by role
            if ($request->filled('role')) {
                $query->whereHas('roles', function ($q) use ($request) {
                    $q->where('name', $request->role);
                });
            }

            $users = $query->paginate(30)->appends($request->except('page'));
            $roles = Role::all();

            return view('dashboard.users.index', compact('users', 'roles'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to retrieve users');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | > User CRUD (Admin Only)
    |--------------------------------------------------------------------------
    */

    /**
     * Show edit user form (Admin only).
     */
    public function edit(User $user)
    {
        try {
            $roles = Role::all();
            $user->load('roles');

            return view('dashboard.users.edit', compact('user', 'roles'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load edit page');
        }
    }

    /**
     * Update user data (Admin only).
     */
    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => "required|email|max:255|unique:users,email," . $user->user_id . ',user_id',
                'roles' => 'required|array'
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            $validRoleIds = Role::whereIn('role_id', $request->roles)->pluck('role_id')->toArray();
            $user->roles()->sync($validRoleIds);

            return redirect()->route('console.users.index')
                ->with('success', 'User updated successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to update user');
        }
    }

    /**
     * Delete a user (Admin only).
     */
    public function destroy(User $user)
    {
        try {
            if ($user->roles()->where('name', 'admin')->exists()) {
                return back()->with('error', 'Admin users cannot be deleted');
            }

            $user->delete();

            return redirect()->route('console.users.index')
                ->with('success', 'User deleted successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to delete user');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | > Profile Management
    |--------------------------------------------------------------------------
    */

    /**
     * Show the user's profile.
     */
    public function profile()
    {
        try {
            $user = Auth::user();
            return view('dashboard.profile.index', compact('user'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load profile');
        }
    }

    /**
     * Show edit profile form.
     */
    public function editProfile()
    {
        try {
            $user = Auth::user();
            return view('dashboard.profile.edit', compact('user'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load profile edit page');
        }
    }

    /**
     * Update user's profile information.
     */
    public function updateProfile(Request $request)
    {
        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => "required|email|max:255|unique:users,email," . $user->user_id . ',user_id',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png'
            ]);

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email']
            ]);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $user->setAvatar($avatar);
            }

            return redirect()->route('dashboard.profile.index')
                ->with('success', 'Profile updated successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to update profile');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | > Password Management
    |--------------------------------------------------------------------------
    */

    /**
     * Show change password form.
     */
    public function showChangePasswordForm()
    {
        try {
            return view('dashboard.profile.change-password');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load password change page');
        }
    }

    /**
     * Handle password change request.
     */
    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect');
            }

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return redirect()->route('dashboard.profile')
                ->with('success', 'Password changed successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to change password');
        }
    }
}
