<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            ! $request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
                ! $request->user()->hasVerifiedEmail())
        ) {

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your email address is not verified.'], 409);
            }

            return response()->view('errors.custom', [
                'code' => 409,
                'title' => 'Email Not Verified',
                'message' => 'Your email address is not verified.'], 409);
        }

        return $next($request);
    }
}
