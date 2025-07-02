<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            Log::warning('Unauthorized access attempt - No authenticated user', [
                'url' => $request->url(),
                'ip' => $request->ip(),
                'role_required' => implode(', ', $roles)
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Authentication required',
                    'authenticated' => false
                ], Response::HTTP_UNAUTHORIZED);
            }

            return redirect()->guest(route('dashboard.login'));
        }

        try {
            $user->loadMissing('roles');

            $userRoleNames = $user->roles->pluck('name')->toArray();

            if (!collect($roles)->intersect($userRoleNames)->isNotEmpty()) {
                Log::notice('Forbidden access attempt', [
                    'user_id' => $user->user_id,
                    'email' => $user->email,
                    'url' => $request->url(),
                    'ip' => $request->ip(),
                    'required_roles' => $roles,
                    'user_roles' => $userRoleNames
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Forbidden - Insufficient permissions',
                        'authorized' => false
                    ], Response::HTTP_FORBIDDEN);
                }

                return response()->view('errors.custom', [
                    'code' => Response::HTTP_FORBIDDEN,
                    'title' => 'Forbidden',
                    'message' => 'You do not have permission to access this resource.',
                ], Response::HTTP_FORBIDDEN);
            }
        } catch (\Exception $e) {
            Log::error('Role middleware error: ' . $e->getMessage(), [
                'user_id' => $user->user_id ?? null,
                'url' => $request->url(),
                'ip' => $request->ip(),
                'roles_required' => $roles,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Internal server error',
                'error' => app()->environment('production') ? null : $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $next($request);
    }
}
