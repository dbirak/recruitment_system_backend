<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserApplicationInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "announcement_id" => "required|integer|exists:announcements,id",
            "user_id" => "required|integer|exists:users,id",
            "step_id" => "required|integer|exists:steps,id",
            "step_number" => "required|integer",
        ];
    }
}
