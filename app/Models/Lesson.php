<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'video_path',
        'content',
        'completed'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // app/Models/Lesson.php

    public function quiz()
    {
        return $this->hasOne(Quiz::class); // à remplacer selon ton vrai modèle
    }


    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'lesson_user')
            ->withPivot('completed_at')
            ->withTimestamps();
    }
}
