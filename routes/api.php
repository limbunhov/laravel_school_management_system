<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassScoreStudentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/student', function (Request $request) {
        return $request->student();
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


Route::get('/users', [AuthController::class, 'index']);

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/student', [AuthController::class, 'getAllStudents']);
Route::get('/teacher', [AuthController::class, 'getAllTeachers']);


Route::post('/student', [StudentController::class, 'store']);
Route::put('/student/{id}', [StudentController::class, 'update']);
Route::delete('/student/{id}', [StudentController::class, 'destroy']);
// Route::get('/student', [StudentController::class, 'index']);


Route::post('/subjects', [SubjectController::class, 'store']);
Route::get('/subjects', [SubjectController::class, 'index']);

Route::post('/classes', [ClassesController::class, 'store']);
Route::get('/classes', [ClassesController::class, 'index']);
Route::post('/add-student-to-class', [ClassesController::class, 'addStudentToClass']);
Route::post('/add-teacher-to-class', [ClassesController::class, 'addTeacherToClass']);

Route::post('/classes/{id}/students', [ClassesController::class, 'getStudents']);
Route::get('/classes/{id}/students', [ClassesController::class, 'getStudent']);
Route::get('/classes/{id}/teachers', [ClassesController::class, 'getTeachers']);
Route::post('/classes/updateStudent/{id}', [ClassesController::class, 'update']);

Route::post('/signupstudent', [StudentLoginController::class, 'studentsignup']);
Route::post('/loginstudent', [StudentLoginController::class, 'studentlogin']);

Route::post('/teacher', [TeacherController::class, 'store']);
Route::get('/teacher/{id}', [TeacherController::class, 'getTeacherAttendance']);
Route::put('/teacher/{id}', [TeacherController::class, 'update']);
Route::delete('/teacher/{id}', [TeacherController::class, 'destroy']);
Route::get('/teacher/{id}/classes', [TeacherController::class, 'getClasses']);
// Route::get('/teacher-id/{id}', [TeacherController::class, 'getTeacherId']);
// Route::get('/teacher/classes', [TeacherController::class, 'getClasses']);
// Route::get('/teacher', [TeacherController::class, 'index']);

// Route::post('/add-student-to-class-score', [ClassScoreStudentController::class, 'addStudentToClass']);

Route::post('/classes/{id}/attendance-students', [AttendanceController::class, 'getStudents']);
Route::post('/classes/{id}/attendance', [AttendanceController::class, 'recordMultipleAttendances']);
// Route::post('/attendances', [AttendanceController::class, 'recordMultipleAttendances']);
Route::post('/classes/each-student-attendance', [AttendanceController::class, 'getEachStudent']);

Route::post('assignments', [AssignmentController::class, 'store']);
Route::post('get-assignments', [AssignmentController::class, 'index']);

Route::get('/student/{id}/subjects', [StudentController::class, 'getClasses']);
Route::get('/student-id/{id}', [StudentController::class, 'getStudentId']);
Route::get('/student-class/{id}', [StudentController::class, 'getStudentClass']);
Route::get('/classes-id/{id}/student', [StudentController::class, 'getStudentClassId']);
Route::post('/each-student-score', [ClassesController::class, 'getEachStudentScore']);

Route::get('/total-teachers', [TeacherController::class, 'getTotalTeachers']);
Route::get('/total-students', [StudentController::class, 'getTotalStudents']);
Route::get('/total-classes', [ClassesController::class, 'getTotalClasses']);
