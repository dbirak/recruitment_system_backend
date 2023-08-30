<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['announcement_id', 'user_id', 'step_id', 'step_number', 'task_id', 'file_answer_id', 'open_answer_id', 'test_answer_id', 'cv_answer_id'];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function fileAnswer()
    {
        return $this->belongsTo(FileAnswer::class);
    }

    public function openAnswer()
    {
        return $this->belongsTo(OpenAnswer::class);
    }

    public function testAnswer()
    {
        return $this->belongsTo(TestAnswer::class);
    }

    public function CvAnswer()
    {
        return $this->belongsTo(CvAnswer::class);
    }
}
