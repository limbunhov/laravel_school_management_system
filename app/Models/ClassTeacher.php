<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassTeacher extends Model
{
    use HasFactory;

    protected $table = 'class_teachers';
    protected $fillable = [
        'classes_id',
        'teacher_id',
        // 'user_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // public function user()
    // {
    //     return $this->belongsTo(Teacher::class, 'classes_id');
    // }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id');
    }
}
