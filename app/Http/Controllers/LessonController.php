<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Notifications\NewLessonNotification;
use Illuminate\Support\Facades\Notification;

class LessonController extends Controller
{
    /**
     * Affiche une leçon et les leçons restantes.
     */
    public function show($id)
    {
        $lesson = Lesson::with(['course.lessons.users', 'questions.answers'])->findOrFail($id);
        $user = Auth::user();

        // Filtrer les leçons non terminées par l'utilisateur
        $remainingLessons = $lesson->course->lessons->filter(function ($l) use ($user) {
            return !$l->users->contains($user->id);
        })->where('id', '!=', $lesson->id);

        return view('student.lessons.show', compact('lesson', 'remainingLessons'));
    }

    /**
     * Marquer une leçon comme complétée (sans quiz) et générer le certificat si nécessaire.
     */
    public function complete(Request $request, Lesson $lesson)
    {
        $user = Auth::user();

        // Marquer la leçon terminée
        $user->lessons()->syncWithoutDetaching([
            $lesson->id => ['completed_at' => now()]
        ]);

        // Vérifier et générer le certificat si toutes les leçons du cours sont terminées
        $lesson->load('course');
        $this->generateCertificateIfEligible($user->id, $lesson->course);

        return redirect()->back()->with('success', 'Leçon marquée comme terminée.');
    }

    /**
     * Soumettre le quiz d'une leçon.
     */
    public function submitQuiz(Request $request, Lesson $lesson)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $user = Auth::user();
        $questions = $lesson->questions()->with('answers')->get();
        $correctAnswersCount = 0;

        foreach ($questions as $question) {
            $userAnswerId = $request->answers[$question->id] ?? null;
            $correctAnswer = $question->answers->firstWhere('is_correct', true);
            $isCorrect = $userAnswerId && $correctAnswer && $userAnswerId == $correctAnswer->id;

            // Enregistrer la réponse dans la table quizzes
            DB::table('quizzes')->updateOrInsert(
                [
                    'user_id'     => $user->id,
                    'lesson_id'   => $lesson->id,
                    'question_id' => $question->id,
                ],
                [
                    'answer_id'  => $userAnswerId,
                    'is_correct' => $isCorrect,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            if ($isCorrect) {
                $correctAnswersCount++;
            }
        }

        // Si toutes les réponses sont correctes, marquer la leçon terminée
        if ($correctAnswersCount === $questions->count()) {
            $user->lessons()->syncWithoutDetaching([
                $lesson->id => ['completed_at' => now()]
            ]);

            // Vérifier si le cours est terminé et générer le certificat
            $lesson->load('course');
            $this->generateCertificateIfEligible($user->id, $lesson->course);

            return redirect()->route('student.courses.show', $lesson->course->id)
                ->with('success', '🎉 Félicitations ! Vous avez réussi le quiz et votre certificat est disponible.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', '❌ Réponses incorrectes. Veuillez réessayer.');
    }

    /**
     * Générer un certificat si toutes les leçons du cours sont terminées par l'utilisateur.
     */
    private function generateCertificateIfEligible($userId, $course)
    {
        $user = Auth::user();
        $totalLessons = $course->lessons->count();
        $completedLessons = $user->lessons()->where('course_id', $course->id)->count();

        if ($totalLessons === $completedLessons) {
            // Vérifier si le certificat existe déjà
            $certificate = Certificate::firstOrCreate(
                ['user_id' => $userId, 'course_id' => $course->id],
                [
                    'code' => strtoupper(uniqid('CERT-')),
                    'file_path' => 'certificates/' . $user->id . '_' . $course->id . '.pdf',
                    'issued_at' => now(),
                ]
            );

            // Générer le PDF si le fichier n'existe pas
            if (!Storage::disk('public')->exists($certificate->file_path)) {
                $pdf = PDF::loadView('student.certificates.certificate', [
                    'user' => $user,
                    'course' => $course,
                    'code' => $certificate->code,
                    'issuedAt' => now(),
                ]);

                Storage::disk('public')->put($certificate->file_path, $pdf->output());
            }
        }
    }

    public function store(Request $request)
{
    $lesson = Lesson::create($request->all());

    // Envoyer la notification aux étudiants inscrits au cours
    $students = $lesson->course->students; // si tu as une relation
    Notification::send($students, new NewLessonNotification($lesson));

    return redirect()->route('instructor.instructor.lessons')
        ->with('success', 'Leçon créée et notification envoyée 🎉');
}
}
