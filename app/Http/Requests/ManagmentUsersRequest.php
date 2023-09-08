<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagmentUsersRequest extends FormRequest
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
            'id' => 'required|integer|exists:steps,id',
            'not_applied_users' => 'nullable|array',
            'not_applied_users.*' => 'integer|exists:users,id',
            'applied_users' => 'array',
            'applied_users.*' => 'integer|exists:users,id',
            'rejected_users' => 'array',
            'rejected_users.*' => 'integer|exists:users,id',
            'accepted_users' => 'array',
            'accepted_users.*' => 'integer|exists:users,id',
        ];
    }
}
