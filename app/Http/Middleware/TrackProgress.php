<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TrackProgress
{
    public function handle($request, Closure $next)
    {
        // Logique pour suivre la progression
        // Par exemple, mettre à jour la progression dans la base de données

        return $next($request);
    }
}
