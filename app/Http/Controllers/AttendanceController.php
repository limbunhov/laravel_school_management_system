<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function getStudents(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'classes_id' => 'required|exists:classes,id',
            'teacher_id' => 'required|exists:teachers,id',
            'student_id' => 'required|exists:students,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $students = Attendance::where('classes_id', $id)
        ->where('teacher_id', $request->teacher_id)->get();
        return response()->json($students);
    }

    public function getEachStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'classes_id' => 'required|exists:classes,id',
            'teacher_id' => 'required|exists:teachers,id',
            'student_id' => 'required|exists:students,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $attendances = Attendance::where('classes_id', $request->classes_id)
            ->where('teacher_id', $request->teacher_id)
            ->where('student_id', $request->student_id)
            ->get();

        return response()->json([
            'attendances' => $attendances
        ]);
    }

    public function recordMultipleAttendances(Request $request)
    {
        Log::info('Incoming attendance data', $request->all());

        $validator = Validator::make($request->all(), [
            'attendances' => 'required|array',
            'attendances.*.classes_id' => 'required|exists:classes,id',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.teacher_id' => 'required|exists:teachers,id',
            'attendances.*.date' => 'required|date',
            'attendances.*.status' => 'required|in:attend,absent,permission'
        ]);

        if ($validator->fails()) {
            Log::error('Validation errors', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($request->attendances as $attendance) {
            Attendance::updateOrCreate(
                [
                    'classes_id' => $attendance['classes_id'],
                    'student_id' => $attendance['student_id'],
                    'date' => $attendance['date'],
                    'teacher_id' => $attendance['teacher_id'],
                    'status' => $attendance['status']
                ]
            );
        }

        return response()->json(['message' => 'Attendances recorded successfully']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
