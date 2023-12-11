<?php

// app/Models/Question.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer;
use App\Models\Course; // Import the Course model

class Question extends Model
{
    protected $table = 'questions';
    use HasFactory;

    protected $fillable = [
        'course_id',
        'question_text',
        'difficulty',
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}