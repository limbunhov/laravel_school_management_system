<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function assignTeacherToClass(Request $request, $classId)
    {
        $class = Classes::findOrFail($classId);
        $teacherId = $request->input('teacher_id');
        $class->teacher_id = $teacherId;
        $class->save();

        return redirect()->back()->with('success', 'Teacher assigned to class successfully.');
    }

    public function assignStudentToClass(Request $request, $classId)
    {
        $class = Classes::findOrFail($classId);
        $studentId = $request->input('student_id');
        $class->students()->attach($studentId);

        return redirect()->back()->with('success', 'Student assigned to class successfully.');
    }

    public function assignSubjectToClass(Request $request, $classId)
    {
        $class = Classes::findOrFail($classId);
        $subjectId = $request->input('subject_id');
        $class->subjects()->attach($subjectId);

        return redirect()->back()->with('success', 'Subject assigned to class successfully.');
    }
}
