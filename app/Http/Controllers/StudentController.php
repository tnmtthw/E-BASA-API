<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }
    
    public function signin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            /** @var \App\Models\User $user **/
            $student = Auth::user();
            $accessToken = $user->createToken('Login')->plainTextToken;

            return response()->json([
                'student' => $student->toArray(),
                'accessToken' => $accessToken
            ]);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function signup(Request $request)
    {

        $data = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:students',
            'username' => 'required|string|unique:students',
            'school' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $student = Student::create($data);

        return response()->json($student, 201);
    }
}