<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends User
{
    use HasApiTokens, HasFactory, Notifiable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return [$this->belongsToMany(Classes::class, 'class_teacher', 'teacher_id', 'classes_id'),
                $this->hasMany(Classes::class)];
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // public function classes()
    // {
    //     return $this->belongsToMany(Classes::class);
    //     // return [$this->hasMany(Classes::class),
    //     //         $this->belongsToMany(Classes::class, 'class_teachers', 'teachers_id', 'classes_id')
    //     // ];
    // }
    // public function classes()
    // {
    //     return $this->belongsToMany(Classes::class, 'class_students');
    // }

    public function teachers()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function student()
    {
        return $this->belongsToMany(Student::class, 'student_id');
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
    protected $fillable = [
        'user_id',
        'subject',
        'name',
        'email',
        'role',
        'password',
        'gender'
    ];

}
