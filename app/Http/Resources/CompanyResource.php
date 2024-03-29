<?php

namespace App\Http\Resources;

use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'street' => $this->street,
            'post_code' => $this->post_code,
            'city' => $this->city,
            'krs' => $this->krs,
            'regon' => $this->regon,
            'nip' => $this->nip,
            'phone_number' => $this->phone_number,
            'avatar' => $this->avatar,
            'background_image' => $this->background_image,
            'province' => new ProvinceResource(Province::findOrFail($this->province_id)),
        ];
    }
}
