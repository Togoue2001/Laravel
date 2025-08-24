<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function indexLessons()
    {
        $lessons = Lesson::with('course')->get(); // Récupère toutes les leçons avec leurs cours associés
        return view('instructor.lessons.index', compact('lessons'));
    }

    public function createLesson()
    {
        $courses = Course::all(); // Récupérer tous les cours pour le menu déroulant
        return view('instructor.lessons.create', compact('courses'));
    }

 public function storeLesson(Request $request)
{
    $request->validate([
        'course_id' => 'required|exists:courses,id',
        'title' => 'required|string|max:255',
        'video_path' => 'nullable|file|mimes:mp4,avi,mov|max:102400', // 100 MB max
        'description' => 'nullable|string',
    ]);

    $lesson = new Lesson();
    $lesson->course_id = $request->course_id;
    $lesson->title = $request->title;
    $lesson->description = $request->description; // Assure-toi que le champ existe

    if ($request->hasFile('video_path')) {
        // Stocke la vidéo dans storage/app/public/videos
        $lesson->video_path = $request->file('video_path')->store('videos', 'public');
    }

    $lesson->save();

    return redirect()->route('instructor.instructor.lessons', $request->course_id)
        ->with('success', 'Leçon ajoutée avec succès.');
}
    public function editLesson($id)
    {
        $lesson = Lesson::findOrFail($id); // Récupérer la leçon par son ID
        $courses = Course::all(); // Récupérer tous les cours pour le menu déroulant
        return view('instructor.lessons.edit_lesson', compact('lesson', 'courses'));
    }

 public function updateLesson(Request $request, $id)
{
    $request->validate([
        'course_id' => 'required|exists:courses,id',
        'title' => 'required|string|max:255',
        'video_path' => 'nullable|file|mimes:mp4,avi,mov|max:20480',
        'description' => 'nullable|string',
    ]);

    $lesson = Lesson::findOrFail($id);
    $lesson->course_id = $request->course_id;
    $lesson->title = $request->title;
    $lesson->description = $request->description;

    if ($request->hasFile('video_path')) {
        // Supprimer l’ancienne vidéo si besoin (optionnel)
        // Storage::disk('public')->delete($lesson->video_path);

        $lesson->video_path = $request->file('video_path')->store('videos', 'public');
    }

    $lesson->save();

    return redirect()->route('instructor.instructor.lessons')
        ->with('success', 'Leçon mise à jour avec succès.');
}

    public function create()
    {
        $lessons = Lesson::all(); // Récupérer toutes les leçons
        return view('instructor.questions.create', compact('lessons')); // Passer les leçons à la vue
    }

    public function showQuestions()
    {
        $questions = Question::with('answers')->get(); // Récupérer toutes les questions avec leurs réponses
        return view('instructor.questions.index', compact('questions')); // Passer les questions à la vue
    }

    public function storeQuestionAndAnswers(Request $request)
    {
        // Validation des données
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'question_text' => 'required|string|max:255',
            'answers' => 'required|array|min:1',
            'answers.*.text' => 'required|string|max:255',
            'correct_answer' => 'required|integer',
        ]);

        // Création de la question
        $question = Question::create([
            'lesson_id' => $request->lesson_id,
            'question_text' => $request->question_text,
        ]);

        // Création des réponses
        foreach ($request->answers as $index => $answer) {
            Answer::create([
                'question_id' => $question->id,
                'answer_text' => $answer['text'],
                'is_correct' => $index == $request->correct_answer,
            ]);
        }

        // Redirection avec un message de succès
        return redirect()->route('instructor.questions.index')->with('success', 'Question et réponses ajoutées avec succès.');
    }

    public function deleteLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete(); // Supprime la leçon

        return redirect()->route('instructor.instructor.lessons')->with('success', 'Leçon supprimée avec succès.');
    }

    public function destroy($id)
    {
        // Trouver la question par son ID
        $question = Question::with('answers')->findOrFail($id);

        // Supprimer les réponses associées
        $question->answers()->delete();

        // Supprimer la question
        $question->delete();

        // Redirection avec un message de succès
        return redirect()->route('instructor.questions.index')->with('success', 'Question et réponses supprimées avec succès.');
    }
}
