<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Company;
use App\Models\Contract;
use App\Models\EarnTime;
use App\Models\WorkTime;
use App\Models\WorkType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'duties' => json_decode($this->duties),
            'requirements' => json_decode($this->requirements),
            'offer' => json_decode($this->offer),
            'expiry_date' => $this->expiry_date,
            'min_earn' => $this->min_earn === null ? null : $this->min_earn,
            'max_earn' => $this->max_earn === null ? null : $this->max_earn,
            'earn_time' => $this->earn_time_id === null ? null : new EarnTimeResource(EarnTime::findOrFail($this->earn_time_id)),
            'contract' => new ContractResource(Contract::findOrFail($this->contract_id)),
            'company' => new CompanyResource(Company::findOrFail($this->company_id)),
            'category' => new CategoryResource(Category::findOrFail($this->category_id)),
            'work_time' => new WorkTimeResource(WorkTime::findOrFail($this->work_time_id)),
            'work_type' => new WorkTypeResource(WorkType::findOrFail($this->work_type_id)),
            "steps" => $this->steps,
            "last_step_info" => $this->last_step_info,
            'created_at' => $this->created_at,
        ];
    }
}
