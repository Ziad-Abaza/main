<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Closure;

class CacheService
{
    protected int $ttl;

    public function __construct(int $ttl = 300) // default 5 minutes
    {
        $this->ttl = $ttl;
    }

    /**
     * Generates an automatic cache key from context if none is given.
     */
    protected function generateAutoKey(?string $key = null, array $context = []): string
    {
        if ($key) {
            return $key;
        }

        // Generate a key based on the context or request data
        $contextString = json_encode($context ?: Request::all());
        return 'cache_' . md5($contextString);
    }

    /**
     * Checks if a cache key exists.
     */
    public function has(string $key): bool
    {
        return Cache::has($key);
    }

    /**
     * Automatically handles cache with optional dynamic key generation.
     */
    public function remember(?string $key, Closure $callback, array $context = [], ?int $ttl = null): mixed
    {
        $finalKey = $this->generateAutoKey($key, $context);
        return Cache::remember($finalKey, $ttl ?? $this->ttl, $callback);
    }

    /**
     * Remove a cache key.
     */
    public function forget(string $key): void
    {
        Cache::forget($key);
    }

    /**
     * Force update the cache key (forget and recall).
     */
    public function update(?string $key, Closure $callback, array $context = [], ?int $ttl = null): mixed
    {
        $finalKey = $this->generateAutoKey($key, $context);
        $this->forget($finalKey);
        return $this->remember($finalKey, $callback, $context, $ttl);
    }
}
