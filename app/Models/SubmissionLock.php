<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionLock extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'step_id'];

    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
