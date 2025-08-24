<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RateLimit
{
    public function handle($request, Closure $next)
    {
        $userId = Auth::id();
        $quizId = $request->route('id');
        $key = "quiz_{$quizId}_user_{$userId}";

        $attempts = Cache::get($key, 0);

        if ($attempts >= 3) { // Limiter à 3 tentatives, par exemple
            return response()->json(['error' => 'Rate limit exceeded'], 429);
        }

        Cache::increment($key);
        Cache::put($key, $attempts + 1, 3600); // Expires in 1 hour

        return $next($request);
    }
}
