<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $credentials = $request->validated();
        if(!Auth::attempt($credentials)){
            return response([
                'message' => 'The Role Password or Email is incorrect.'
            ], 401);
        }
    
        /** @var user $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user', 'token'));
    }
    

    public function signup(SignupRequest $request) {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
            'gender' => $data['gender'],
        ]);

        if($data['role'] === "student"){
            $student = Student::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => $data['role'],
                'gender' => $data['gender'],
            ]);
        } else if($data['role'] === "teacher"){
            $student = Teacher::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => $data['role'],
                'gender' => $data['gender'],
                'subject' => $data['subject'],
            ]);
        }

        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user', 'token'), 201);
    }

    public function getAllStudents()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function getAllTeachers()
    {
        $teachers = Teacher::all();
        return response()->json($teachers);
    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->noContent();
    }
    
}
// if($data['role'] === 'admin'){
//     $user = User::create([
//         'name' => $data['name'],
//         'email' => $data['email'],
//         'password' => bcrypt($data['password']),
//         'role' => $data['role'],
//     ]);

//     $user = Admin::create([
//         'name' => $data['name'],
//         'email' => $data['email'],
//         'password' => bcrypt($data['password']),
//         'role' => $data['role'],
//     ]);

//     $token = $user->createToken('main')->plainTextToken;

//     // return response([
//     //     'user' => $user,
//     //     'token' => $token,
//     // ]);

//     return response(compact('user', 'token'), 201);
// } else if($data['role'] === 'student'){
//     $user = Student::create([
//         'name' => $data['name'],
//         'email' => $data['email'],
//         'password' => bcrypt($data['password']),
//         'role' => $data['role'],
//     ]);

//     $user = User::create([
//         'name' => $data['name'],
//         'email' => $data['email'],
//         'password' => bcrypt($data['password']),
//         'role' => $data['role'],
//     ]);

//     $token = $user->createToken('main')->plainTextToken;

//     // return response([
//     //     'user' => $user,
//     //     'token' => $token,
//     // ]);

//     return response(compact('user', 'token'), 201);
// }

// else if($data['role'] === 'teacher'){
//     $user = Teacher::create([
//         'name' => $data['name'],
//         'email' => $data['email'],
//         'password' => bcrypt($data['password']),
//         'role' => $data['role'],
//     ]);

//     $user = User::create([
//         'name' => $data['name'],
//         'email' => $data['email'],
//         'password' => bcrypt($data['password']),
//         'role' => $data['role'],
//     ]);

//     $token = $user->createToken('main')->plainTextToken;

//     // return response([
//     //     'user' => $user,
//     //     'token' => $token,
//     // ]);

//     return response(compact('user', 'token'), 201);
// }