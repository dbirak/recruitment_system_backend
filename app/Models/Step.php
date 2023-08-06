<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    protected $fillable = ['announcement_id', 'step_number', 'task_id', 'test_task_id', 'open_task_id', 'file_task_id', 'expiry_date'];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function testTask()
    {
        return $this->belongsTo(TestTask::class);
    }

    public function openTask()
    {
        return $this->belongsTo(OpenTask::class);
    }

    public function fileTask()
    {
        return $this->belongsTo(FileTask::class);
    }
}
