<?php

namespace App\Http\Controllers;

use App\Models\ClassScoreStudent;
use App\Models\ClassStudent;
use Illuminate\Http\Request;

class ClassScoreStudentController extends Controller
{
    public function addStudentToClass(Request $request)
    {
        $request->validate([
            'classes_id' => 'required',
            'student_id' => 'required',
            'att' => 'integer',
            'lab' => 'integer',
            'ass' => 'integer',
            'mid_term' => 'integer',
            'final' => 'integer',
        ]);

        // Assuming you have a Class_Student model
        ClassScoreStudent::create([
            'classes_id' => $request->classes_id,
            'student_id' => $request->student_id,
            'att' => $request->att,
            'lab' => $request->lab,
            'ass' => $request->ass,
            'mid_term' => $request->mid_term,
            'final' => $request->final,
        ]);

        return response()->json(['message' => 'Student added to class successfully']);
    }
}
