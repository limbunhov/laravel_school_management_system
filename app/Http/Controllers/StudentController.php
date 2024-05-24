<?php

namespace App\Http\Controllers;

use App\Models\ClassStudent;
use App\Models\ClassTeacher;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Student::all();
    }

    public function getTotalStudents()
    {
        $count = Student::count();
        return response()->json(['total_students' => $count]);
    }

    public function getStudentId($id)
    {
        $students = Student::where('user_id', $id)->get();

        // Check if there are any students found
        if ($students->isEmpty()) {
            return response()->json(['message' => 'No students found'], 404);
        }

        // Extract student IDs
        $studentIds = $students->pluck('id');

        return response()->json($students);
    }

    public function getStudentClass($id)
    {
        $students = ClassStudent::where('student_id', $id)->get();

        // Check if there are any students found
        if ($students->isEmpty()) {
            return response()->json(['message' => 'No students found'], 404);
        }

        // Extract student IDs
        $studentIds = $students->pluck('classes_id');

        return response()->json($studentIds);
    }

    public function getStudentClassId($id)
    {
        $students = Student::where('user_id', $id)->get();

        // Check if there are any students found
        if ($students->isEmpty()) {
            return response()->json(['message' => 'No students found'], 404);
        }

        // Extract student IDs
        $studentIds = $students->pluck('id');

        $classesId = ClassStudent::where('student_id', $studentIds)->get();

        return response()->json($classesId);
    }
    public function getClasses($id)
    {
        // Retrieve students based on the user_id
        $students = Student::where('user_id', $id)->get();

        // Check if there are any students found
        if ($students->isEmpty()) {
            return response()->json(['message' => 'No students found'], 404);
        }

        // Extract student IDs
        $studentIds = $students->pluck('id');

        // Retrieve classes for the found students
        $class_student = ClassStudent::whereIn('student_id', $studentIds)->get();

        if ($class_student->isEmpty()) {
            return response()->json(['message' => 'No teachers found'], 404);
        }

        $class_studentId = $class_student->pluck('classes_id');

        $teachers = ClassTeacher::whereIn('classes_id', $class_studentId)->get();

        if ($teachers->isEmpty()) {
            return response()->json(['message' => 'No teacher2 found'], 404);
        }

        $teachersId = $teachers->pluck('teacher_id');

        $subjects = Teacher::whereIn('id', $teachersId)->get();

        return response()->json($subjects);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'gender' => 'string',
            // 'dob' => 'string',
            // 'class' => 'string',
            // 'address' => 'string',
            'email' => 'string',
            // 'profile_image' => 'image|mimes:jpeg,png,jpg,gif',
        ]);


        $student = new Student();
        $student->name = $request->name;
        // $student->gender = $request->gender;
        // $student->class = $request->class;
        // $student->dob = $request->dob;
        $student->email = $request->email;
        // $student->address = $request->address;

        // if ($request->hasFile('profile_image')) {
        //     $image = $request->file('profile_image');
        //     $imageData = file_get_contents($image->getPathName());
        //     $student->profile_image = $imageData;
        // }

        $student->save();

        return response()->json(['message' => 'Student profile image uploaded successfully'], 200);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'gender' => 'sometimes|string',
            'dob' => 'sometimes|string',
            'class' => 'sometimes|string',
            'address' => 'sometimes|string',
        ]);

        $student = Student::findOrFail($id);
        $student->name = $request->name;
        $student->email = $request->email;
        if ($request->has('gender')) $student->gender = $request->gender;
        if ($request->has('dob')) $student->dob = $request->dob;
        if ($request->has('class')) $student->class = $request->class;
        if ($request->has('address')) $student->address = $request->address;

        $student->save();

        return response()->json(['message' => 'Student updated successfully'], 200);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(['message' => 'Student deleted successfully'], 200);
    }
}
