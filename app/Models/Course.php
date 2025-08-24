<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'category_id',
        'user_id',
        'status',
        'video_path',
    ];

    // Définir la relation avec les utilisateurs
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments'); // 'enrollments' est le nom de votre table pivot
    }

    // Définir la relation avec les leçons
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id'); // Modifiez ici pour refléter le bon champ
    }

    public function category()
    {
        return $this->belongsTo(Category::class); // Catégorie
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function forum()
    {
        return $this->hasOne(forum::class);
    }
}
