<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class ThrottleLoginAttempts
{
    public function handle(Request $request, Closure $next): Response
    {
        $email = $request->input('email');
        $ip = $request->ip();

        // request most be a POST request
        if (!$request->isMethod('post')) {
            return $next($request);
        }

        // determining the key for rate limiting
        $key = $email ? 'login-attempts:' . strtolower($email) . ':' . $ip : 'login-ip:' . $ip;

        // key for global IP rate limiting
        $ipKey = 'login-ip-global:' . $ip;

        $maxAttemptsEmail = 5; //max attempts for email
        $maxAttemptsIP = 10; //max attempts for IP

        $decaySeconds = 600; // 10 minutes decay time

        // check if the request is a login attempt
        if (RateLimiter::tooManyAttempts($key, $maxAttemptsEmail)) {
            $seconds = RateLimiter::availableIn($key);
            Log::channel('attacks')->warning('Login attempt throttled', [
                'email' => $email,
                'ip' => $ip,
                'attempts' => RateLimiter::attempts($key),
                'available_in' => $seconds
            ]);
            return back()->with('error', 'Too many login attempts. Please try again later.');
        }

        // check if the IP address has exceeded the maximum number of attempts
        if (RateLimiter::tooManyAttempts($ipKey, $maxAttemptsIP)) {
            $seconds = RateLimiter::availableIn($ipKey);
            Log::channel('attacks')->warning('IP login attempt throttled', [
                'ip' => $ip,
                'attempts' => RateLimiter::attempts($ipKey),
                'available_in' => $seconds
            ]);
            return back()->with('error', 'Too many login attempts. Please try again later.');
        }

        //  increment the attempts counter
        RateLimiter::hit($key, $decaySeconds);
        RateLimiter::hit($ipKey, $decaySeconds);

        return $next($request);
    }
}
