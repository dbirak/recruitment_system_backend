<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['answer'];

    public function application()
    {
        return $this->hasMany(Application::class);
    }
}
