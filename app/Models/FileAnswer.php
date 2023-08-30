<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['original_name', 'storage_name'];

    public function application()
    {
        return $this->hasMany(Application::class);
    }
}
