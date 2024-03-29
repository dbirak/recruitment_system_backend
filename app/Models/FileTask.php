<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileTask extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'descryption', 'time', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function step()
    {
        return $this->hasMany(Step::class);
    }
}
