<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function courses()
    {
        return $this->hasMany(Course::class); // Instructeur
    }

    public function enrollments()
    {
        return $this->belongsToMany(Course::class, 'enrollments'); // Étudiant
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function lessons()
    {
        // Relation many-to-many avec table pivot user_lesson (ou autre nom)
        // Si ta table pivot s'appelle différemment, adapte ici
        return $this->belongsToMany(Lesson::class)
            ->withPivot('completed_at') // si tu as cette colonne dans la table pivot
            ->withTimestamps();
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class)
            ->withTimestamps()
            ->withPivot('used_at');
    }
    
}
