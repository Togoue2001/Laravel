<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Enroullment;

class CheckEnrollment
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $courseId = $request->route('id');

        if (!$user || !Enroullment::where('user_id', $user->id)->where('course_id', $courseId)->exists()) {
            return response()->json(['error' => 'Enrollment required'], 403);
        }

        return $next($request);
    }
}
