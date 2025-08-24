<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        // Charger questions et réponses
        $quiz->load('questions.answers');

        // TODO : Vérifier l’accès utilisateur au quiz via cours / leçon

        return view('student.quizzes.show', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $userAnswers = $request->input('answers'); // question_id => answer_id
        $score = 0;
        $total = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $correctAnswer = $question->answers->firstWhere('is_correct', true);

            if (isset($userAnswers[$question->id]) && $userAnswers[$question->id] == $correctAnswer->id) {
                $score++;
            }
        }

        // Optionnel : marquer la leçon comme terminée si score total
        if ($score == $total) {
            $user = Auth::user();
            $lesson = $quiz->lesson; // ou $quiz->course->lesson ?

            if ($lesson) {
                $user->lessons()->syncWithoutDetaching([
                    $lesson->id => ['completed_at' => now()]
                ]);
            }
        }

        // Redirection avec message et score
        return redirect()->route('student.quizzes.show', $quiz->id)
            ->with('success', "Quiz terminé ! Score : $score / $total");
    }
}
