<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends User
{
    use HasApiTokens, HasFactory, Notifiable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_students', 'student_id', 'classes_id');
    }

    public function teacher()
    {
        return $this->hasMany(Teacher::class, 'teacher_id');
    }

    public function attendances()
    {
        return $this->hasOne(Attendance::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    protected $fillable = [
        'user_id',
        'name',
        'password',
        'role',
        'gender',
        'email',
    ];
}
