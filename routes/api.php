<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;


Route::post('signin', [StudentController::class, 'signin'])->name('signin');
Route::post('signup', [StudentController::class, 'signup'])->name('signup');
Route::get('students', [StudentController::class, 'index'])->name('student_index');

Route::get('courses', [CourseController::class, 'index'])->name('course.index');
Route::get('questions', [QuestionController::class, 'index'])->name('question.index');
// Route::get('courses/{courseId}/questions', [QuestionController::class, 'index'])->name('question.index');
Route::get('/questions/{questionId}/answers', [AnswerController::class, 'index'])->name('answer.index');



