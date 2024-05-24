<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'subject_id');    
    }

    // public function 

    public function class()
    {
        return $this->hasMany(Classes::class);
    }

    protected $fillable = [
        'teacher_id',
        'name',
    ];
}
