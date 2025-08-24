<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use App\Notifications\NewCourseNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        return view('instructor.courses.index', [
            'courses' => Course::orderBy('created_at', 'desc')->paginate(25)
        ]);
    }

    public function create()
    {
        $course = new Course();
        return view('instructor.courses.form', [
            'course' => $course,
            'category' => Category::pluck('name', 'id')
        ]);
    }

    public function store(CourseRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();
        $course = Course::create($validatedData);

        // ➕ Créer automatiquement un forum pour ce cours
        $course->forum()->create();

        // 🔔 Envoi automatique de l'email aux étudiants
        $students = User::where('role', 'student')->get();
        Notification::send($students, new NewCourseNotification($course));

        return to_route('instructor.course.index')
            ->with('success', 'Le cours a été ajouté');
    }



    public function edit(Course $course)
    {
        return view('instructor.courses.form', [
            'course' => $course,
            'category' => Category::pluck('name', 'id')
        ]);
    }


    public function update(CourseRequest $request, Course $course)
    {
        $validatedData = $request->validated();
        $course->update($validatedData);

        return to_route('instructor.course.index')->with('success', 'Le cours a été modifié');
    }

 public function show(\App\Models\Course $course)
{
    $user = \Illuminate\Support\Facades\Auth::user();

    // Charger les leçons avec UNIQUEMENT l’utilisateur courant sur la relation users,
    // et seulement si la leçon est complétée (completed_at non null)
    $lessons = $course->lessons()
        ->with(['users' => function ($q) use ($user) {
            $q->where('users.id', $user->id)
                ->whereNotNull('lesson_user.completed_at');
        }])
        ->get();

    // Nombre total de leçons du cours
    $totalLessons = $course->lessons()->count();

    // Nombre de leçons complétées par l'utilisateur (via pivot)
    $completedLessons = $user->lessons()
        ->where('lessons.course_id', $course->id)
        ->whereNotNull('lesson_user.completed_at')
        ->count();

    $courseIsCompletedByUser = ($totalLessons > 0 && $completedLessons === $totalLessons);

    // Certificat (s’il existe déjà)
    $certificate = \App\Models\Certificate::where('user_id', $user->id)
        ->where('course_id', $course->id)
        ->latest()
        ->first();

    // 🔹 Charger le forum avec les threads et leurs auteurs
    $course->load('forum.threads.user');

    // 🔹 Vérifier si le forum existe, sinon le créer automatiquement
    if (!$course->forum) {
        $course->forum()->create();
        $course->load('forum.threads.user'); // Recharger le forum
    }

    return view('student.courses.show', compact(
        'course',
        'lessons',
        'courseIsCompletedByUser',
        'certificate'
    ));
}



    public function destroy(Course $course)
    {
        $course->delete();
        return to_route('instructor.course.index')->with('success', 'le cour a été supprimer');
    }
}
