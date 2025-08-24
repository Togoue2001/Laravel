<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
public function index()
{
    $userId = Auth::id();

    $courseCount = Course::where('user_id', $userId)->count();
    $lessonCount = Lesson::whereIn('course_id', Course::where('user_id', $userId)->pluck('id'))->count();
    $categoryCount = Category::count(); // Nombre total de catégories
    $studentCount = User::whereHas('orders')->count();
    $orders = Order::all();
    $students = User::whereHas('orders')->get();
    $coursesBought = Course::whereIn('id', $orders->pluck('course_id'))->get();

    return view('instructor.statistics.index', compact(
        'courseCount', 'lessonCount', 'categoryCount', 'studentCount',
        'orders', 'students', 'coursesBought'
    ));
}
}
