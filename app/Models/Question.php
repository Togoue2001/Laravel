<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',   // Ajoutez cette ligne
        'question_text',
    ];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }


    public function answers()
    {
        return $this->hasMany(\App\Models\Answer::class);
    }
}
