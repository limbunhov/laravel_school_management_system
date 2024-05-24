<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassScoreStudent extends Model
{
    use HasFactory;

    public function students()
    {
        return $this->hasMany(ClassStudent::class, 'classes_id');
    }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_teachers', 'class_id', 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id');
    }

    protected $fillable = [
        'classes_id', 
        'student_id',
        'att',
        'lab',
        'ass',
        'mid_term',
        // 'final',
    ];
}
