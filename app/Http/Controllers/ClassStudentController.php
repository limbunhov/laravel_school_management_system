<?php

namespace App\Http\Controllers;

use App\Models\ClassStudent;
use App\Models\ClassTeacher;
use Illuminate\Http\Request;

class ClassStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addStudentToClass(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'student_id' => 'required',
            'att' => 'integer',
            'lab' => 'integer',
            'ass' => 'integer',
            'mid_term' => 'integer',
            'final' => 'integer',
        ]);

        // Assuming you have a Class_Student model
        ClassStudent::create([
            'class_id' => $request->class_id,
            'student_id' => $request->student_id
        ]);

        return response()->json(['message' => 'Student added to class successfully']);
    }

// Controller method to add a teacher to a class
    public function addTeacherToClass(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'teacher_id' => 'required'
        ]);

        // Assuming you have a Class_Teacher model
        ClassTeacher::create([
            'class_id' => $request->class_id,
            'teacher_id' => $request->teacher_id
        ]);

        return response()->json(['message' => 'Teacher added to class successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
