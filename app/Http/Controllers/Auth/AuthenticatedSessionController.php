<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Redirection en fonction du rôle
        return redirect($this->redirectTo($user));
    }

    /**
     * Redirection vers le tableau de bord approprié en fonction du rôle.
     */
    protected function redirectTo($user)
    {
        return match ($user->role) {
            'admin' => route('admin.dashboard'),
            'instructor' => route('instructor.dashboard'),
            'student' => route('student.dashboard'),
            default => route('dashboard'), // Pour les utilisateurs non spécifiés
        };
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
