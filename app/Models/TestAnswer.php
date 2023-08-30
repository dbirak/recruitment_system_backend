<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAnswer extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function application()
    {
        return $this->hasMany(Application::class);
    }

    public function testAnswerAnswer()
    {
        return $this->hasMany(TestAnswerAnswer::class);
    }
}
