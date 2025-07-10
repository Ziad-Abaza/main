<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
// log
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showInstructorLoginForm()
    {
        return view('auth.instructor-login');
    }

    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function instructorLogin(Request $request)
    {
        return $this->handleLogin($request, 'dashboard');
    }

    public function adminLogin(Request $request)
    {
        return $this->handleLogin($request, 'console');
    }


    private function handleLogin(Request $request, string $area)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        // ⛏ تحميل المستخدم مع الأدوار والصلاحيات المرتبطة بكل دور
        $user = User::with('roles.permissions')
            ->where('email', $credentials['email'])
            ->first();

        if (!$user) {
            Log::debug('Login Failed: User not found for email: ' . $credentials['email']);
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
        }

        if (!Auth::validate($credentials)) {
            Log::debug('Login Failed: Invalid password for email: ' . $credentials['email']);
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
        }

        // ✳️ حدد الصلاحيات المطلوبة حسب المنطقة
        $requiredPermissions = $area === 'console'
            ? ['manage_roles', 'manage_users', 'assign_admin', 'assign_superadmin', 'manage_child']
            : ['manage_child', 'manage_absences', 'manage_enrollments', 'view_submissions', 'manage_assignments', 'manage_quizzes', 'manage_courses', 'manage_users', 'manage_categories'];

        Log::debug("User Roles for {$user->email}: " . json_encode($user->roles->pluck('name')));

        foreach ($user->roles as $role) {
            Log::debug("Role [{$role->name}] permissions: " . json_encode($role->permissions->pluck('name')));
        }

        // ✅ استخرج كل صلاحيات الأدوار الخاصة بالمستخدم فقط
        $rolePermissions = $user->roles
            ->flatMap(fn($role) => $role->permissions->pluck('name'))
            ->unique();

        Log::debug("Collected role permissions for {$user->email}: " . json_encode($rolePermissions));

        $hasPermission = collect($requiredPermissions)->some(fn($permission) => $rolePermissions->contains($permission));

        Log::debug("Checking permission for area [$area]: Result = " . ($hasPermission ? '✅ GRANTED' : '❌ DENIED'));

        if (!$hasPermission) {
            return back()->withErrors(['email' => 'You do not have permission to access this area.'])->withInput($request->only('email'));
        }

        // ✅ تسجيل الدخول
        Auth::login($user, $remember);
        $user->tokens()->delete();
        $request->session()->regenerate();

        RateLimiter::clear('login-attempts:' . strtolower($user->email) . ':' . $request->ip());
        RateLimiter::clear('login-ip-global:' . $request->ip());

        Log::debug("User {$user->email} logged in successfully to area [$area]");

        return $area === 'console'
            ? redirect()->route('console')
            : redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        try {
            $request->user()?->tokens()?->delete();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->is('dashboard*')) {
                return redirect()->route('dashboard.login')->with('success', 'successfully logged out');
            }

            if ($request->is('console*')) {
                return redirect()->route('console.login')->with('success', 'successfully logged out');
            }

            return redirect('/')->with('success', 'successfully logged out');
        } catch (\Throwable $th) {
            return back()->with('error', 'An error occurred while logging out.' . ' ' . $th->getMessage());
        }
    }

    public function userProfile(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            if ($request->is('dashboard*')) {
                return redirect()->route('dashboard.login')->with('error', 'must be logged in first.');
            }

            if ($request->is('console*')) {
                return redirect()->route('console.login')->with('error', 'must be logged in first.');
            }
        }

        if ($request->is('dashboard*')) {
            return view('dashboard.profile', compact('user'));
        }

        if ($request->is('console*')) {
            return view('console.profile', compact('user'));
        }

        abort(404);
    }
}
