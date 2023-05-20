<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkTime extends Model
{
    use HasFactory;

    protected $fillable = ['work_time_name'];

    public function announcement()
    {
        return $this->hasMany(Announcement::class);
    }
}
