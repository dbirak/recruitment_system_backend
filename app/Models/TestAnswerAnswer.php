<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAnswerAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['test_answer_id', 'question_id', 'answer_id', 'is_checked'];

    public function application()
    {
        return $this->hasMany(Application::class);
    }

    public function testAnswer()
    {
        return $this->belongsTo(TestAnswer::class);
    }
}
