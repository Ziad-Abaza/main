<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            // if ($request->is('dashboard/*') || $request->is('dashboard')) {
            //     return route('dashboard.login');
            // }

            if ($request->is('console/*') || $request->is('console')) {
                return route('console.login');
            }

            return '/login';
        }

        return null;
    }
}
