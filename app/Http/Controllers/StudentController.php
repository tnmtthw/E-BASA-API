<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }
    
    public function signin(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'username' => 'required',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['username', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Username & Password does not match with our record.',
                ], 401);
            }

            $student = Student::where('username', $request->username)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $student->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function signup(Request $request)
    {
        try {
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
    
            $student = Student::create([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'middlename' => $data['middlename'],
                'age' => $data['age'],
                'gender' => $data['gender'],
                'email' => $data['email'],
                'username' => $data['username'],
                'school' => $data['school'],
                'password' => Hash::make($data['password']),
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $student->createToken("API TOKEN")->plainTextToken
            ], 201);
    
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }    
}