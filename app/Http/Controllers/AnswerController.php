<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function index($questionId) {
        $answers = Answer::where('question_id', $questionId)->get();
        return response()->json($answers);
    }
}
