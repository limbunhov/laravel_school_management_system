<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    public function students()
    {
        // return $this->hasMany(ClassStudent::class, 'classes_id');
        return [$this->hasMany(Student::class),
                $this->belongsToMany(Student::class, 'class_students', 'classes_id', 'student_id'),
                $this->hasMany(ClassStudent::class, 'classes_id'),
                $this->hasMany(ClassTeacher::class, 'classes_id')];
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function attendance()
    {
        return $this->belongsToMany(Attendance::class, 'classes_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }


    // App\Models\Classes.php
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_teachers', 'classes_id', 'teacher_id');
    }


    protected $fillable = [
        'name',
    ];
}
