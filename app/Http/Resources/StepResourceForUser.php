<?php

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StepResourceForUser extends JsonResource
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
            'announcement_id' => $this->announcement_id,
            'step_number' => $this->step_number,
            'task' => new TaskResource(Task::findOrFail($this->task_id)),
            'info' => $this->info,
            'expiry_date' => $this->expiry_date,
        ];
    }
}
