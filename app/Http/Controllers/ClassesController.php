<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassStudent;
use App\Models\ClassTeacher;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{
    public function index()
    {
        return Classes::all();
    }

    public function getTotalClasses()
    {
        $count = Classes::count();
        return response()->json(['total_classes' => $count]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $class = Classes::create([
            'name' => $validatedData['name'],
        ]);

        return response()->json($class, 201);
    }

    public function addStudentToClass(Request $request)
    {
        $request->validate([
            'classes_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:students,id|unique:class_students,student_id,NULL,id,classes_id,' . $request->classes_id,
        ]);

        // Check if the student is already added to the class
        $existingStudent = ClassStudent::where('classes_id', $request->classes_id)
            ->where('student_id', $request->student_id)
            ->first();

        if ($existingStudent) {
            return response()->json(['errors' => ['student_id' => ['Student is already added to the class']]], 422);
        }

        // Add student to class
        ClassStudent::create([
            'classes_id' => $request->classes_id,
            'student_id' => $request->student_id,
        ]);

        // Get all teachers for the class
        $class = Classes::findOrFail($request->classes_id);
        $teachers = $class->teachers;

        // Create score records for each teacher
        foreach ($teachers as $teacher) {
            Score::create([
                'classes_id' => $request->classes_id,
                'student_id' => $request->student_id,
                'teacher_id' => $teacher->id,
                'att' => 0,
                'lab' => 0,
                'ass' => 0,
                'mid_term' => 0,
                'final' => 0,
            ]);
        }

        return response()->json(['message' => 'Student added to class and scores initialized successfully'], 201);
    }

    public function addTeacherToClass(Request $request)
    {
        $request->validate([
            'classes_id' => 'required|exists:classes,id',
            'teacher_id' => 'required|exists:teachers,id|unique:class_teachers,teacher_id,NULL,id,classes_id,' . $request->classes_id,
        ]);

        // Check if the teacher is already added to the class
        $existingTeacher = ClassTeacher::where('classes_id', $request->classes_id)
            ->where('teacher_id', $request->teacher_id)
            ->first();

        if ($existingTeacher) {
            return response()->json(['errors' => ['teacher_id' => ['Teacher is already added to the class']]], 422);
        }

        // Add teacher to class
        ClassTeacher::create([
            'classes_id' => $request->classes_id,
            'teacher_id' => $request->teacher_id,
        ]);

        return response()->json(['message' => 'Teacher added to class successfully']);
    }


    public function getStudent(Request $request, $id)
    {
        $students = ClassStudent::where('classes_id', $id)->with('student')->get();
        return response()->json($students);
    }

    public function getStudents(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $students = Score::where('classes_id', $id)
            ->where('teacher_id', $request->teacher_id)
            ->with('student')
            ->get();

        return response()->json($students);
    }

    public function getTeachers($id)
    {
        $teachers = ClassTeacher::where('classes_id', $id)->with('teacher')->get();
        return response()->json($teachers);
    }

    public function getEachStudentScore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'classes_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:students,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $scores = Score::where('classes_id', $request->classes_id)
            ->where('student_id', $request->student_id)
            ->with('teacher')
            ->get();

        return response()->json(['scores' => $scores]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'att' => 'integer',
            'lab' => 'integer',
            'ass' => 'integer',
            'mid_term' => 'integer',
            'final' => 'integer',
        ]);

        $score = Score::findOrFail($id);
        $score->update($validatedData);

        return response()->json(['message' => 'Score updated successfully', 'data' => $score]);
    }

    public function destroy(string $id)
    {
        // Handle the deletion logic
    }
}
