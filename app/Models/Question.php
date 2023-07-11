<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question'];

    public function answerQuesion()
    {
        return $this->hasMany(AnswerQuestion::class);
    }
}
