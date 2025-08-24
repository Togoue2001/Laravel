<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Spécifiez les colonnes qui peuvent être remplies massivement
    protected $fillable = [
        'receiver_address',
        'receiver_phone',
        'user_id',
        'course_id',
        'payment_status',
    ];

    // Définir la relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Définir la relation avec le modèle Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
