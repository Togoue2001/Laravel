<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Content;
use App\Models\Course;
use App\Models\Lesson;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function manageUsers()
    {
        // Récupérer les utilisateurs
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        // dd($users);
        // Passer les utilisateurs à la vue
        return view('admin.users.index', ['users' => $users]);
    }

    // Afficher le formulaire d'ajout d'utilisateur
    public function createUser()
    {
        $user = new User();
        return view('admin.users.create', [
            'user' => $user,
        ]);
    }

    // Stocker un nouvel utilisateur
    public function storeUser(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:student,instructor,admin', // Validation pour le rôle
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Enregistrement du rôle
        ]);

        // Événement de l'utilisateur enregistré
        event(new Registered($user));

        // Redirection vers la page de gestion des utilisateurs
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur ajouté avec succès.');
    }

    // Afficher le formulaire d'édition d'utilisateur
    public function editUser($id)
    {
        $user = User::where("id", $id)->first();
        return view('admin.users.edit', [
            'user' => $user
        ]);
    }

    // Mettre à jour un utilisateur
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            // Pas besoin de valider le mot de passe si on ne le modifie pas
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email'));

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function moderateContent()
    {
        // Récupérer les contenus avec un statut 'pending'
        $unmoderatedContent = Content::where('status', 'pending')->get();

        // Passer la variable à la vue
        return view('admin.content', compact('unmoderatedContent'));
    }

public function showAnalytics()
{
    $userCount = User::count();
    $courseCount = Course::count();

    // Compter les leçons complétées dans la table pivot lesson_user
    $completedLessons = DB::table('lesson_user')
        ->whereNotNull('completed_at')
        ->count();

    // Récupérer les détails des cours
    $courseDetails = Course::withCount([
        'users as enrolled_users' => function ($query) {
            $query->where('enrollment_status', 'enrolled');
        },
        'lessons as completed_lessons' => function ($query) {
            $query->whereHas('users', function ($q) {
                $q->whereNotNull('lesson_user.completed_at');
            });
        }
    ])->get();

    return view('admin.analytics', compact(
        'userCount',
        'courseCount',
        'completedLessons',
        'courseDetails'
    ));
}


    public function approveContent($id)
    {
        $content = Content::findOrFail($id);
        $content->status = 'approved'; // Changez le statut
        $content->save();

        return redirect()->route('admin.admin.content')->with('success', 'Contenu approuvé avec succès.');
    }

    public function rejectContent($id)
    {
        $content = Content::findOrFail($id);
        $content->status = 'rejected'; // Changez le statut
        $content->save();

        return redirect()->route('admin.admin.content')->with('success', 'Contenu rejeté avec succès.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    // Ajoutez les méthodes pour approuver et rejeter le contenu
}
