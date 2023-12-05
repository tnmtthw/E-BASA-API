<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;


Route::post('signin', [StudentController::class, 'signin'])->name('signin');
Route::post('signup', [StudentController::class, 'signup'])->name('signup');
Route::get('students', [StudentController::class, 'index'])->name('index');

