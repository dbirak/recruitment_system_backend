<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'street', 'post_code', 'city', 'krs', 'regon', 'nip', 'phone_number', 'description', 'localization', 'avatar', 'background_image', 'contact_email', 'user_id', 'province_id'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
}
