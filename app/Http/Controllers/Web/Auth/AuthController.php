<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

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
        return $this->handleLogin($request, 'instructor');
    }

    public function adminLogin(Request $request)
    {
        return $this->handleLogin($request, 'admin');
    }

    private function handleLogin(Request $request, string $role)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Auth::validate($credentials)) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
        }

        if (!$user->hasRole($role)) {
            return back()->withErrors(['email' => 'You do not have permission to access this area.'])->withInput($request->only('email'));
        }

        Auth::login($user, $remember);
        $user->tokens()->delete();
        $request->session()->regenerate();

        RateLimiter::clear('login-attempts:' . strtolower($user->email) . ':' . $request->ip());
        RateLimiter::clear('login-ip-global:' . $request->ip());

        return $role === 'admin'
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
