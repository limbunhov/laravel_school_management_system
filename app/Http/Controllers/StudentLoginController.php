<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentLoginController extends Controller
{
    public function studentlogin(LoginRequest $request) {
        $credentials = $request->validated();
        if(!Auth::attempt($credentials)){
            return response([
                'message' => 'The Password or Email is incorrect.'
            ]);
        }

        /** @var user $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user', 'token'));

    }
    

    public function studentsignup(SignupRequest $request) {
        $data = $request->validated();
        $user = Student::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
        ]);

        $token = $user->createToken('main')->plainTextToken;

        // return response([
        //     'user' => $user,
        //     'token' => $token,
        // ]);

        return response(compact('user', 'token'), 201);
    }

    public function studentlogout(Request $request) {
        $student = $request->student();
        $student->currentAccessToken()->delete();
        return response()->noContent();
    }
    
}
