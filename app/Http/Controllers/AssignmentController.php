<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssignmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'classes_id' => 'required|exists:classes,id',
            'teacher_id' => 'required|exists:teachers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $assignment = Assignment::create([
            'classes_id' => $request->classes_id,
            'teacher_id' => $request->teacher_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json($assignment, 201);
    }


    public function index(Request $request)
    {
        $assignments = Assignment::where('classes_id', $request->classes_id)
        ->where('teacher_id', $request->teacher_id)
        ->with(['class', 'teacher'])->get();
        return response()->json($assignments);
    }
}
