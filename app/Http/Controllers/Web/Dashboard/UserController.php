<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Throwable;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $query = User::with('roles');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            }

            if ($request->filled('role')) {
                $query->whereHas('roles', fn($q) => $q->where('name', $request->role));
            }

            $users = $query->paginate(30)->appends($request->except('page'));
            $roles = Role::all();

            return view('dashboard.users.index', compact('users', 'roles'));
        } catch (Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to retrieve users');
        }
    }

    public function edit(User $user)
    {
        try {
            $roles = Role::all();
            $user->load('roles');

            return view('dashboard.users.edit', compact('user', 'roles'));
        } catch (Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load edit page');
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => "required|email|max:255|unique:users,email," . $user->user_id . ',user_id',
                'roles' => 'required|array',
                'roles.*' => 'exists:roles,id'
            ]);

            /** @var \App\Models\User $currentUser */
            $currentUser = Auth::user();
            $assigningRoles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();

            foreach ($assigningRoles as $roleName) {
                if ($roleName === 'admin' && ! $currentUser->can('assign_admin')) {
                    return back()->with('error', 'You are not authorized to assign the admin role');
                }

                if ($roleName === 'superadmin' && ! $currentUser->can('assign_superadmin')) {
                    return back()->with('error', 'You are not authorized to assign the superadmin role');
                }
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $user->syncRoles($assigningRoles);

            $hasInstructorRole = in_array('instructor', $assigningRoles);
            $hasProfile = $user->instructorProfile()->exists();

            if ($hasInstructorRole && !$hasProfile) {
                $user->instructorProfile()->create([
                    'bio' => '',
                    'specialization' => '',
                    'experience' => '',
                    'linkedin_url' => '',
                    'github_url' => '',
                    'website_url' => '',
                    'skills' => json_encode([]),
                ]);
            } elseif (!$hasInstructorRole && $hasProfile) {
                $user->instructorProfile()->delete();
            }

            return redirect()->route('console.users.index')
                ->with('success', 'User updated successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage(), [
                'user_id' => $user->user_id,
                'request_roles' => $request->roles ?? [],
            ]);
            return back()->with('error', 'Failed to update user');
        }
    }


    public function destroy(User $user)
    {
        try {
            if ($user->hasRole('superadmin')) {
                return back()->with('error', 'Superadmin users cannot be deleted');
            }

            $user->delete();

            return redirect()->route('console.users.index')
                ->with('success', 'User deleted successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to delete user');
        }
    }

    public function profile()
    {
        try {
            $user = Auth::user();
            return view('dashboard.profile.index', compact('user'));
        } catch (Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load profile');
        }
    }

    public function editProfile()
    {
        try {
            $user = Auth::user();
            return view('dashboard.profile.edit', compact('user'));
        } catch (Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load profile edit page');
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            /**
             * @var \App\Models\User $user
             */
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
                $user->setAvatar($request->file('avatar'));
            }

            return redirect()->route('dashboard.profile.index')
                ->with('success', 'Profile updated successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to update profile');
        }
    }

    public function showChangePasswordForm()
    {
        try {
            return view('dashboard.profile.change-password');
        } catch (Throwable $th) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to load password change page');
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

            /**
             * @var \App\Models\User $user
             */
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
            Log::channel('debug')->error(__METHOD__ . ' - ' . $th->getMessage());
            return back()->with('error', 'Failed to change password');
        }
    }
}
