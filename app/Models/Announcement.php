<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'duties', 'requirements', 'offer', 'expiry_date', 'min_earn', 'max_earn', 'earn_time_id', 'contract_id', 'company_id', 'category_id', 'work_time_id', 'work_type_id'];

    public function earnTime()
    {
        return $this->belongsTo(EarnTime::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function workTime()
    {
        return $this->belongsTo(WorkTime::class);
    }

    public function workType()
    {
        return $this->belongsTo(WorkType::class);
    }

    public function step()
    {
        return $this->hasMany(Step::class);
    }
}
