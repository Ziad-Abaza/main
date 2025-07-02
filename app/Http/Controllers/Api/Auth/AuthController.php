<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\TransientToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validation
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);

            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $user->setAvatar($request->file('avatar'));
            }

            // Assign default role 'user'
            $userRole = Role::where('name', 'student')->first();

            if (!$userRole) {
                return response()->json([
                    'success' => false,
                    'code' => 500,
                    'message' => 'Default role not found',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $user->roles()->attach($userRole);

            // Generate token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'code' => 201,
                'user' => $user->load('roles'),
                'token' => $token,
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Something went wrong during registration',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
            ]);

            $credentials = $request->only('email', 'password');
            $email = strtolower($request->email);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'code' => 401,
                    'message' => 'Invalid email or password',
                ], Response::HTTP_UNAUTHORIZED);
            }

            $user = User::where('email', $email)->with('roles')->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            RateLimiter::clear('login-attempts:' . strtolower($user->email) . ':' . $request->ip());
            RateLimiter::clear('login-ip-global:' . $request->ip());
            return response()->json([

                'success' => true,
                'code' => 200,
                'user' => $user,
                'token' => $token,
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Something went wrong during login',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            $token = $user?->currentAccessToken();
            if ($token && !($token instanceof TransientToken)) {
                $token->delete();
            }

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Logged out successfully',
            ], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Logout failed',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function user(Request $request)
    {
        try {
            $user = $request->user()->load('roles');

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'code' => 401,
                    'message' => 'User not authenticated',
                ], Response::HTTP_UNAUTHORIZED);
            }

            return response()->json([
                'success' => true,
                'code' => 200,
                'user' => $user,
            ], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Failed to retrieve user data',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
