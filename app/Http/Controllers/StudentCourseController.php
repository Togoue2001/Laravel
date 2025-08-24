<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentCourseController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();

        $courses = \App\Models\Course::whereIn('id', function ($query) use ($user) {
            $query->select('course_id')
                ->from('orders')
                ->where('user_id', $user->id)
                ->where('payment_status', 'paid');
        })->with(['lessons.users' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }])->get();

        return view('student.courses.courbay', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::with('lessons')->findOrFail($id);
        $user = Auth::user();

        $completedLessons = $user->lessons()->where('course_id', $course->id)->count();
        $courseIsCompletedByUser = $course->lessons->count() === $completedLessons;

        $certificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        $lessons = $course->lessons()->with(['users' => function ($q) use ($user) {
            $q->where('user_id', $user->id)->whereNotNull('lesson_user.completed_at');
        }])->get();

        return view('student.courses.show', compact('course', 'lessons', 'courseIsCompletedByUser', 'certificate'));
    }

    public function achats()
    {
        $user = Auth::user();

        // Récupérer tous les achats de l'utilisateur avec les informations du cours
        $orders = Order::with('course') // assuming Order a une relation course()
                       ->where('user_id', $user->id)
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('student.courses.achat', compact('orders'));
    }
}
