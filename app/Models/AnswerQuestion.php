<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'answer_id', 'test_task_id'];

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function testTask()
    {
        return $this->belongsTo(TestTask::class);
    }
}
