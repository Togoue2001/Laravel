<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
      public function dashboard() // Assurez-vous que le nom est correct
    {
        $user = Auth::user();

        // Logique pour rediriger ou afficher le bon tableau de bord
        switch ($user->role) {
            case 'admin':
                return view('admin.dashboard');
            case 'instructor':
                return view('instructor.dashboard');
            case 'student':
                return view('student.dashboard');
            default:
                return redirect()->route('dashboard');
        }
    }
}
