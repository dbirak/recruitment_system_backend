<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkType extends Model
{
    use HasFactory;

    protected $fillable = ['work_type_name'];

    public function announcement()
    {
        return $this->hasMany(Announcement::class);
    }
}
