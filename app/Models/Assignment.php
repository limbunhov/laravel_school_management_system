<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $fillable = [
        'classes_id',
        'teacher_id',
        'title',
        'description',
        'date',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
