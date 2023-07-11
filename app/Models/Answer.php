<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['answer', 'is_correct'];

    public function answerQuesion()
    {
        return $this->hasMany(AnswerQuestion::class);
    }
}
