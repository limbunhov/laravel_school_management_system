<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassTeacher;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function index()
    {
        return Teacher::all();
    }

    public function getTotalTeachers()
    {
        $count = Teacher::count();
        return response()->json(['total_teachers' => $count]);
    }

    // public function getTEacherId($id)
    // {
    //     $teacher = Teacher::where('user_id', $id)->get();
    //     return response()->json($teacher);
    // }

    public function getTeacherAttendance($id)
    {
        $teacher = Teacher::where('user_id', $id)->get();
        return response()->json($teacher);
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
            'email' => 'string',
        ]);


        $teacher = new Teacher();
        $teacher->name = $request->name;
        $teacher->email = $request->email;

        $teacher->save();

        return response()->json(['message' => 'Student profile image uploaded successfully'], 200);
    
    }

    public function getClasses($id)
    {

        $teacher = Teacher::where('user_id', $id)->pluck('id');

        $teacherId = ClassTeacher::whereIn('teacher_id', $teacher)->pluck('classes_id');

        $class = Classes::whereIn('id', $teacherId)->get();

        return response()->json($class);
        // $classes = $teacher->classes;

        // return response()->json($classes);
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
        ]);

        $teacher = Teacher::findOrFail($id);
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->save();

        return response()->json(['message' => 'Teacher updated successfully'], 200);
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return response()->json(['message' => 'Teacher deleted successfully'], 200);
    }
}
