<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPanelAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string    $panel  // 'dashboard' or 'console'
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $panel)
    {
        // ensure the user is authenticated
        if (! Auth::check()) {
            abort(401, 'Authentication required');
        }

        $user = Auth::user();

        // check if the user is an admin
        $permission = match ($panel) {
            'console'   => 'view_console',
            'dashboard' => 'view_dashboard',
            default     => null,
        };

        if (! $permission) {
            abort(400, 'Invalid panel specified');
        }

        // check if the user has the required permission
        /**
         * @var App\Models\User $user
         */
        if (! $user->can($permission)) {
            abort(403, 'You do not have permission to access the ' . $panel);
        }

        return $next($request);
    }
}
