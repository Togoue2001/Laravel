<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\StudentCourseController;
use App\Livewire\Chat;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route de Gestion pour l'administrateur
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Gestions des utilisateur
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');

    // Gestions des codes promos
    Route::resource('coupons', CouponController::class);

    // Gestions de contenus et stat
    Route::get('/analytics', [AdminController::class, 'showAnalytics'])->name('admin.analytics');
    Route::post('/content/{id}/approve', [AdminController::class, 'approveContent'])->name('content.approve');
    Route::post('/content/{id}/reject', [AdminController::class, 'rejectContent'])->name('content.reject');
});

// Route de Gestion pour l'instructeur
Route::prefix('instructor')->name('instructor.')->middleware(['auth'])->group(function () {
    // Gestions des cours et categories
    Route::resource('course', CourseController::class);
    Route::resource('category', CategoryController::class);
    Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics');
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Gestion des lessons
    Route::get('lesson/create', [InstructorController::class, 'createLesson'])->name('instructor.createLesson');
    Route::post('lesson', [InstructorController::class, 'storeLesson'])->name('instructor.storeLesson');
    Route::get('lessons', [InstructorController::class, 'indexLessons'])->name('instructor.lessons');
    Route::get('lesson/{id}/edit', [InstructorController::class, 'editLesson'])->name('instructor.editLesson');
    Route::put('lesson/{id}', [InstructorController::class, 'updateLesson'])->name('instructor.updateLesson');
    Route::delete('lesson/{id}', [InstructorController::class, 'deleteLesson'])->name('instructor.deleteLesson');

    // Gestion des QCM et réponses
    Route::get('questions', [InstructorController::class, 'showQuestions'])->name('questions.index'); // Liste des questions
    Route::get('questions/create', [InstructorController::class, 'create'])->name('questions.create'); // Formulaire de création
    Route::post('questions', [InstructorController::class, 'storeQuestionAndAnswers'])->name('questions.store'); // Stocker les questions
    Route::delete('questions/{id}', [InstructorController::class, 'destroy'])->name('questions.destroy');
});

Route::prefix('student')->name('student.')->middleware(['auth'])->group(function () {

    // Certificats
    Route::get('certificates', [\App\Http\Controllers\CertificateController::class, 'index'])
        ->name('certificates.index');

    Route::get('certificates/{certificate}/download', [\App\Http\Controllers\CertificateController::class, 'download'])
        ->name('certificates.download');

    Route::post('/apply-coupon', [App\Http\Controllers\CouponController::class, 'apply'])->name('coupon.apply');

    Route::get('courses/achats', [StudentCourseController::class, 'achats'])->name('courses.achats');
    // Affiche la liste des cours disponibles
    Route::get('courses', [PaymentController::class, 'index'])->name('index');
    Route::get('courses/add-cart/{id}', [PaymentController::class, 'addToCard'])->name('addToCard');
    Route::post('courses/cart/remove/{id}', [PaymentController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('courses/cart', [PaymentController::class, 'cart'])->name('courses.cart');
    Route::post('/create-checkout-session', [PaymentController::class, 'create'])->name('stripe.checkout');
    Route::get('checkout-success', [PaymentController::class, 'success'])->name('success');
    Route::get('checkout-cancel', [PaymentController::class, 'cancel'])->name('cancel');

    Route::get('courses/courbay', [StudentCourseController::class, 'index'])->name('courses.index');
    Route::get('courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');
    Route::get('lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('lessons/{lesson}/complete', [LessonController::class, 'complete'])->name('lessons.complete');
    Route::post('lessons/{lesson}/submit-quiz', [LessonController::class, 'submitQuiz'])->name('lessons.submitQuiz');

    // Tableau de bord étudiant
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get("chat", Chat::class)->name('chat');
});

require __DIR__ . '/auth.php';
