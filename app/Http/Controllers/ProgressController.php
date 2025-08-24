<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    //
        public function completeLesson($lessonId)
    {
        $user = auth()->user();
        $lesson = Lesson::findOrFail($lessonId);

        // Associer la leçon à l'utilisateur avec la date de complétion
        $user->lessons()->syncWithoutDetaching([
            $lesson->id => ['completed_at' => now()]
        ]);

        return redirect()->back()->with('success', 'Leçon marquée comme complétée.');
    }
}
