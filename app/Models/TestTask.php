<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestTask extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'time', 'user_id'];

    public function answerQuesion()
    {
        return $this->hasMany(AnswerQuestion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function step()
    {
        return $this->hasMany(Step::class);
    }
}
